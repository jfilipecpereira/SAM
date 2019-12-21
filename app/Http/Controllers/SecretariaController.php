<?php

namespace App\Http\Controllers;
use App\Notas;
use Illuminate\Support\Facades\DB;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use App\alunos;


use App\Exports\UsersExport;
use App\User;
use Hamcrest\Type\IsNumeric;
use Maatwebsite\Excel\Facades\Excel;

class SecretariaController extends Controller
{

    public function showCSV(){
        $dados['titulo'] = 'ISAM | Secretaria';
        return view('secretaria/uploadCSV')->with('dados', $dados);
    }


    //Carregar CSV
    public function uploadCSV(Request $request){

        try{
            \Excel::import(new UsersImport,request()->file('file'));
        }catch (\Exception $e) {
            $dados['erro'] = true;
            $dados['mensagem'] = 'Erro com a inserção, um dos alunos está repetido';
            return view('secretaria/uploadCSV')->with('dados', $dados);
        }


        $dados['sucesso']=true;
        $dados['mensagem']='Aluno(s) inserido(s) com sucesso';
        return view('secretaria/uploadCSV')->with('dados', $dados);

        //return back();

    }

    public function getTabelaModulos(){
        //->Query SQL pretendida
        /*SELECT id_aluno, COUNT(id_aluno) AS NumeroVezes FROM notas
        where id_nota in (select max(id_nota) FROM notas group by id_aluno, id_modulo)
        and `nota` < 10 GROUP BY id_aluno ORDER BY COUNT(id_aluno) DESC
        'COUNT(id_aluno) AS NumeroVezes'
        */
        //DB::raw('COUNT(issue_subscriptions.issue_id) as followers')

        $sql = DB::table('notas')->select('id_aluno', DB::raw('COUNT(id_aluno) AS NumeroVezes'))
        ->whereRaw("id_nota in (select max(id_nota) FROM notas group by id_aluno, id_modulo)")
        ->where('nota', '<', '10')
        ->groupBy('id_aluno')
        ->orderBy('NumeroVezes', 'Desc')
        ->take(5)
        //->toSql();
        ->get();

        $nvezes = array();
        $dados = array();
        foreach($sql as $s){
            $aluno = alunos::with('cursos')
            ->where('id_aluno', '=', $s->id_aluno)
            ->get();


            //$aluno[0]->cursos->nome_curso;

            $arrayTmp = array();
            $array = str_split($aluno[0]->cursos->nome_curso);
            foreach ($array as $char) {
                if (preg_match("/^[A-Z]+$/", $char) == 1 || is_numeric($char) || $char == '/'){
                    array_push($arrayTmp, $char);
                }
            }


            $aluno[0]->cursos->nome_curso = implode("", $arrayTmp);

            $aluno->push($s->NumeroVezes);
            array_push($dados, $aluno);
        }
        return $dados;
    }


    //Datatable com todos os módulos
    public function view(){
        return view('list');
    }


    public function query(){
        //ir buscar os dados em JSON
        $dados = User::with('permissao', 'Aluno.cursos')
                ->where('permissao', '=', 4)
                ->get();


        /*foreach($dados as $dado){
            $arrayTmp = array();
            $teste = $dado->aluno[0]->cursos->nome_curso;
            $array = str_split($teste);
            foreach($array as $char){
                if (preg_match("/^[A-Z]+$/", $char) == 1 || is_numeric($char) || $char == '/'){
                    array_push($arrayTmp, $char);
                }
            }
            $dado['aluno'][0]['cursos']['nome_curso'] = implode("",$arrayTmp);
        }*/



        return $dados;
        //Retornar a view com os dados em JSON descodificados
        //Desta forma enviam-se os dados das relações
        //return $dados;
        return view('secretaria/query')->with('dados', $dados);
    }
    public function showEditForm(Request $request, $id){
        $dados = User::with('Aluno')->where('id', '=', $id)->get();

        if(count($dados) == NULL){
            return redirect()->route('Secretariaperguntar');
        }

        //return $dados;
        return view('secretaria/editar')->with('dados', $dados);
    }

    public function update(Request $request, $id_user){
        $user = User::findOrFail($id_user);
        //Fazer uma cópia temporária do user
        $userTMP = $user;

        $aluno = Alunos::findOrFail($user->id_aluno);

        //EDTAR ALUNO
        $aluno->numero_aluno = $request->numero;
        $aluno->nome_aluno = $request->nome;
        $aluno->save();

        //Editar USER
        $user->email = $request->email;

        //Tirar o primeiro
        $primeiro_nome = explode(' ',trim($request->nome));
        $primeiro_nome = $primeiro_nome[0]; // will print Test

        //Tirar último nome
        $ultimo_nome = explode(' ', $request->nome);
        $ultimo_nome = array_pop($ultimo_nome);

        //Concactenar nomes
        $user->nome = $primeiro_nome.' '.$ultimo_nome;

        //Se a password estiver em branco nao altera
        if($request->password == ''){
            $user->password = $userTMP->password;
        }else{
            $user->password = bcrypt($request->password);
        }

        $user->save();

        //return $aluno;

        //ir buscar os dados em JSON
        $dados = User::with('permissao', 'Aluno.cursos')
                ->where('permissao', '=', 4)
                ->where('id', '=', $id_user)
                ->get();

                //return $dados;

        $dados['success'] = 'Dados de aluno atualizados com sucesso!';
        return view('secretaria/editar')->with('dados', $dados);
    }

    public function apagar($id){

        //Procura o utilizador
        $utilizador = User::findOrFail($id);

        //E apaga-o
        $nome = $utilizador->nome;
        User::destroy($id);

        return redirect()->route('Secretariaperguntar')->with('success','O aluno '.$nome.' foi apagado com sucesso!');

    }


    public function dataTable(){
        $dados = Notas::with(
            'modulos',
            'alunos',
            'modulos.disciplina',
            'modulos.disciplina.curso'
            )
        ->whereRaw("id_nota in (select max(id_nota) FROM notas group by id_aluno, id_modulo)")
        ->get();

        foreach($dados as $dado){
            if($dado->nota < 10)
                $dado->nota = 'NS';
        }
        return datatables()->of($dados)->make(true);



    }


    public function index(){
        $t = Notas::with(
            'modulos',
            'alunos',
            'modulos.disciplina',
            'modulos.disciplina.curso'
            )
        ->whereRaw("id_nota in (select max(id_nota) FROM notas group by id_aluno, id_modulo)")
        ->get();


        $s =  DB::table('notas')
        ->whereRaw("id_nota in (select max(id_nota) FROM notas group by id_aluno, id_modulo)")
        ->where('nota', '<', '10')
        ->get();
        //$s -> apenas notas negativas

        $dados['chartjs'] = app()->chartjs
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['Módulos Superados', 'Módulos não Superados'])
        ->datasets([
            [
                'backgroundColor' => ['#FF6384', '#36A2EB'],
                'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                'data' => [(count($t)-count($s)), (count($t)-(count($t)-count($s)))]
            ]
        ])
        ->options([]);

        $dados["tabelaModulos"]=$this->getTabelaModulos();
        $dados['titulo'] = 'ISAM | Secretaria';
        //Retornar a view com os dados em JSON descodificados
        //Desta forma enviam-se os dados das relações
        //return view('secretaria.ver')->with('dados', json_decode($dados, true), $superados, $total);
        return view('secretaria.ver')->with('dados', $dados);
        //return $dados;
    }

}
