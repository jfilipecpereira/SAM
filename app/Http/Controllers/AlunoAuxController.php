<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notas;
use Auth;
use App\Disciplinas;

class AlunoAuxController extends Controller
{
    //

    /**
     * Nome: alunoDataTable
     * Detalhes: Alimentar os dados da datatable dos alunos
     *  - Query SQL: select * from `notas` where id_nota in (select max(id_nota) FROM notas group by id_aluno, id_modulo) and `id_aluno` = ?
     *
     * Parâmetros de entrada: Sem parâmetro
     * Parâmetro de saída: Dados recolhidos no formato datatable
     *
     * @return void
     */

    //
    public function alunoDataTable(){
        //Ir buscar o número do aluno. Presente na classe Auth->user, classe de utilizadores logados
        $this->nAluno = Auth::user()->id_aluno;

        //Preparar a query com Eloquent query builder
        $dados = Notas::with(
            //Realizar um JOIN de todas as tabelas relacionadas
            'modulos',
            'alunos',
            'modulos.disciplina',
            'modulos.disciplina.curso'
            )
        //Em caso de notas ao mesmo módulo repetidas, ir buscar a mais recente
        //Pois é possível serem lançadas novas notas
        ->whereRaw("id_nota in (select max(id_nota) FROM notas group by id_aluno, id_modulo)")
        //Ir buscar apenas os dados relacionados ao aluno
        ->where('id_aluno', $this->nAluno)
        ->get();

        //Retornar os dados no formato específico para o pacote datatable consumir
        return datatables()->of($dados)->make(true);
    }


    /**
     * Nome: dadosVelocimetro
     * Detalhes: Receber todas as notas do aluno e calcular a média:
     *              - Calcular média aritmétrica caso não haja FCT nem PAP
     *              - Calcular com fórmula específica caso haja FCT
     *              - Calcular com fórmula específica caso haja FCT e PAP
     * métodos de calculo:
     *  0 -> sem FCT nem PAP
     *  1 -> caso haja FCT e não haja PAP
     *  2 -> caso hava FCT e PAP
     *
     *  OBS: Nota de PAP e estágio não entram para a média aritmétrica de disciplinas
     *
     * Parâmetros de entrada: $notas -> todas as notas do aluno
     * Parâmetro de saída: média total do curso
     *
     * @return view()
     */
    public function dadosVelocimetro($notas){

        //Método de calculo, com ou sem PAP e Estágio
        $metodo = 0;
        foreach($notas as $nota){
            if($nota->modulos->nome_modulo == 'Formação em Contexto de Trabalho' && $metodo != 2)
                $metodo = 1;
            if($nota->modulos->nome_modulo == 'Prova de Aptidão Profissional')
                $metodo = 2;
        }

        //Somatório de notas de módulos
        $total = 0;

        //As notas da pap e fct vão ser guardadas em variáveis auxiliares,
        //pois, caso existam, serão necessárias para o o cálculo da nota final
        foreach($notas as $nota){
            if($nota->modulos->nome_modulo != 'Prova de Aptidão Profissional' && $nota->modulos->nome_modulo != 'Formação em Contexto de Trabalho')
                $total = $total + $nota->nota;
            if($nota->modulos->nome_modulo == 'Prova de Aptidão Profissional'){
                $pap = $nota->nota;
            }
            if($nota->modulos->nome_modulo == 'Formação em Contexto de Trabalho'){
                $fct = $nota->nota;
            }
        }
        // $mediaDisciplinas = somatório/número de módulos
        $mediaDisciplinas =  $total/count($notas);

        if($metodo == 0){
            //Nota apenas com disciplinas
            return $mediaDisciplinas;
        }else if($metodo == 1){
            //Nota com Estágio
            return ((((2*$mediaDisciplinas) + (0.3*$fct)))/3);
        }else if($metodo == 2){
            //Nota com estagio + PAP
            return ((((2*$mediaDisciplinas) + (0.3*$fct) + (0.7*$pap)))/3);
        }


    }


    /**
     * Nome: graficoBarras
     * Detalhes: Receber todas as notas do aluno e calcular a média por disciplina:
     *              - adicionar cor a cada barra
     *              - adicionar valor a cada barra
     *              - adicionar label de cada barra
     *
     * Parâmetros de entrada: $notas -> todas as notas do aluno
     * Parâmetro de saída: dataset com todos os dados para montar o gráfico de barras
     *
     * @return datasets
     */
    public function graficoBarras($notas){
        //Ir buscar todos os ids das disciplinas
        $idsDisciplinas = collect();
        foreach($notas as $nota){
            $query = DB::table('modulos')
            ->where('id_modulo', '=', $nota->id_modulo)
            ->get();
            $idsDisciplinas->push($query[0]->id_disciplina);
        }
        //Filtrar os ids das disciplinas, para estes não se repetirem
        $idsDisciplinas = $idsDisciplinas->unique();

        //Criar uma nova collection para guardar as disciplinas
        $dados['disciplinas'] = collect();

        //Declarar os arrays que receberão os dados
        //do gráfico de barras para ChartJS
        $datasets = array();
        $datasets[0]["data"] = array();
        $datasets[0]["labels"]= array();

        //Adicionar todas as diferentes disciplinas para a collection criada
        foreach($idsDisciplinas as $id){
            $query = Disciplinas::where('id_disciplina', '=', $id)->get();
            $dados['disciplinas']->push($query);
        }

        $datasets[0]["label"]='Nota';

        //ir buscar todas as notas de cada disciplina
        foreach($dados['disciplinas'] as $key=> $disciplina){
            $sumNotas = 0;
            $cnt = 0;
            foreach($notas as $nota){
                //Variáveis auxiliares para média por disciplina
                //São passadas a 0 no inicio de cada iteração do ciclo principal
                $query = DB::table('modulos')
                        ->where('id_modulo', '=', $nota->id_modulo)
                        ->get();
                if($query[0]->id_disciplina == $disciplina[0]->id_disciplina){
                    $sumNotas += $nota->nota;
                    $cnt++;
                }

            }

            //guardar os resultados no array
            if($cnt > 0){
                array_push($datasets[0]["data"], $sumNotas/$cnt);

            }

            //Adicionar o nome da disciplina
            array_push($datasets[0]["labels"], $dados['disciplinas'][$key][0]->nome_disciplina);
            //Adicionar a cor da barra
            $datasets[0]["backgroundColor"][] = 'rgba(228, 42, 42, 0.8)';


        }
        return $datasets;
    }


    public function prepareGraph($labels, $datasets){
            //Definir o intervalo do gráfico de barras
            $chartOptions = [
                'scales' => [
                    'yAxes' => [
                        [
                            'ticks' => [
                                //Começar em zero e máximo 20
                                'beginAtZero' => true,
                                'max' => 20,
                            ],
                        ],
                    ],
                ],
                'legend' =>[
                    //Não mostrar legendas
                    'display' => false
                ],
            ];


            //Configuração para o gráfico de barras
            $barras = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels($labels)
            ->datasets($datasets)
            ->options($chartOptions);

            return $barras;
    }
}
