<?php

namespace App\Http\Controllers;

use App\Disciplinas;
use App\Http\Controllers\AlunoAuxController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notas;
use Auth;

class AlunoController extends AlunoAuxController
{
    //use AlunoAuxController;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //Middleware para apenas mostrar a class a autilizadores logados
        $this->middleware('auth');
        //Middleware para apenas mostrar a class a autilizadores alunos
        $this->middleware('Aluno');
    }

    /**
     * Nome: index
     * Detalhes: Recolher e organizar todos os dados processados
     * para serem interpretados pelos pacotes gráficos
     *
     * Parâmetros de entrada: Sem parâmetro
     * Parâmetro de saída: view principal de aluno, com uma collection $dados
     *
     * @return view()
     */
    public function index(){

        //Criação da collect que transportará os dados para a view
        $dados = collect();

        //Ir buscar todas as notas (mais recentes e positivas) referentes ao aluno
        //Mais recentes e apenas positivas, pois são estas que contam para as estatísticas
        $notas = Notas::with('modulos')
        ->whereRaw("id_nota in (select max(id_nota) FROM notas group by id_aluno, id_modulo)")
        ->where('id_aluno', Auth::user()->id_aluno)
        ->where('nota', '>', '9')
        ->groupBy('id_modulo')
        ->get();

        //Verificar se o aluno tem notas
        //Caso não tenha mostra uma view que apenas tem uma mensagem
        if(count($notas)!=0){
            //dados do gráfico gauge
            $dados['mediaTotal'] = self::dadosVelocimetro($notas);
            //dados para o gráfico de barras
            $datasets = self::graficoBarras($notas);
            //Preparar o gráfico de barras. Opções, passar o dataset de valores, criar labels
            $dados['barras'] = self::prepareGraph($datasets[0]["labels"], $datasets);
            return view('Aluno.index')->with('dados', $dados);

        }else{
            // Número aleatório para aumentar segurança
            $dados['protect']=589;
            return view('Aluno.semnota')->with('dados', $dados);
        }
    }
}
