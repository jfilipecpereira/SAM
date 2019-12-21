<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;
use App\Notas;
use App\alunos;
use App\Permissoes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class DirecaoController extends Controller
{

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
        ->get();

        $nvezes = array();
        $dados = array();
        foreach($sql as $s){
            $aluno = alunos::with('cursos')
            ->where('id_aluno', '=', $s->id_aluno)
            ->get();

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

        //Retornar a view com os dados em JSON descodificados
        //Desta forma enviam-se os dados das relações
        //return view('direcao.ver')->with('dados', json_decode($dados, true), $superados, $total);
        return view('direcao.ver')->with('dados', $dados);


}
}
