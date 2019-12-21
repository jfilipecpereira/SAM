<?php

namespace App\Http\Controllers;

use App\Professores;
use App\ModulosUfcds;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Disciplinas;

class APIgetIdsController extends Controller
{
    //
    /**
     * Método para procurar o id de professor
     * E verificar se existe
     * Parametros de entrada:
     * -nome do professor
     * Parametros de saida:
     * -id do professor
     * Fluxograma: XXXX
     * @return int
     */
    public function checkProfessor($nomeProfessor){
        $idProfessor = DB::table('professores')
        ->select('id_professor')
        ->where('nome_professor', $nomeProfessor)
        ->get();

        if(count($idProfessor)==0){
            $idProfessor = $this->storeProfessor($nomeProfessor);
        }

        return $idProfessor[0]->id_professor;
    }


    /**
     * Método para procurar o id de aluno
     * e verificar se existe
     * Parametros de entrada:
     * -nome do aluno
     * Parametros de saida:
     * -id do aluno
     * Fluxograma: XXXX
     * @return int
     */
    public function checkAluno($nAluno){
        $idAluno = DB::table('alunos')
                    ->select('id_aluno')
                    ->where('numero_aluno', $nAluno)
                    ->get();


        if(count($idAluno) == 0){
            //Return do erro HTTP 400 - Requisição inválida
            //PASSAR A MENSAGEM DE ALUNO x NÃO ENCONTRADO NA BASE DE DADOS
            //O ALUNO DEVE SER CRIADO NO INICIO DO ANO PELO FICHEIRO CSV
            /*$idAluno = DB::table('alunos')
                    ->select('id_aluno')
                    ->where('numero_aluno', $nAluno)
                    ->get();
                    echo $idAluno;*/

            return "ERROR 400";

        }

        return $idAluno[0]->id_aluno;
    }

    /**
     * Método para procurar o id do curso
     * e verificar se existe
     * Parametros de entrada:
     * -nome do curso
     * Parametros de saida:
     * -id do curso
     * Fluxograma: XXXX
     * @return int
     */
    public function checkCurso($idaluno){
        $idCurso = DB::table('cursos')
        ->select('id_curso')
        ->where('nome_curso', $idaluno)
        ->get();

        if(count($idCurso) == 0){
            //Return do erro HTTP 400 - Requisição inválida
            //PASSAR A MENSAGEM DE ALUNO x NÃO ENCONTRADO NA BASE DE DADOS
            //O CURSO DEVE SER CRIADO NO INICIO DO ANO PELO FICHEIRO CSV
            echo ($idaluno);
            return "ERROR 400";
        }

        return $idCurso[0]->id_curso;
    }

    /**
     * Método para procurar o id da disciplina de determinado curso
     * e verificar se existe
     * Parametros de entrada:
     * -nome da disciplina
     * -id do curso
     * Parametros de saida:
     * -id da disciplina
     * Fluxograma: XXXX
     * @return int
     */
    public function checkDisciplina($idCurso, $nomeDisciplina){
        //Verificar se a Disciplina daquele curso existe
        $idDisciplina = DB::table('disciplinas')
                    ->select('id_disciplina')
                    ->where([
                        ['nome_disciplina', '=', $nomeDisciplina],
                        ['id_curso', '=', $idCurso],
                    ])
                    ->get();

        if(count($idDisciplina)== 0){
            $idDisciplina = $this->storeDisciplina($nomeDisciplina, $idCurso);
        }

        return $idDisciplina[0]->id_disciplina;

    }

    /**
     * Método para procurar o id do modulo de determinada disciplina
     * e verificar se existe
     * Parametros de entrada:
     * -nome da disciplina
     * -id do curso
     * Parametros de saida:
     * -id da disciplina
     * Fluxograma: XXXX
     * @return int
     */
    public function checkModulo($idDisciplina, $nomeModulo){

        $idModulo = DB::table('modulos')
                    ->select('id_modulo')
                    ->where([
                        ['nome_modulo', '=', $nomeModulo],
                        ['id_disciplina', '=', $idDisciplina],
                    ])
                    ->get();

        //Se não existe criar
        if(count($idModulo) == 0){
            $idModulo = $this->storeModulo($nomeModulo, $idDisciplina);
        }

        //return $idModulo = 1;
        return $idModulo[0]->id_modulo;

    }


    public function storeProfessor($nomeProfessor){
        //CRIAR PROFESSOR E PROCURAR O ID
        $professor = new Professores();
        $professor-> nome_professor = $nomeProfessor;
        $professor->save();

        $idProfessor = DB::table('professores')
        ->select('id_professor')
        ->where('nome_professor', $nomeProfessor)
        ->get();

        return $idProfessor;
    }


    public function storeDisciplina($nomeDisciplina, $idCurso){
        $disciplina = new Disciplinas();
        $disciplina-> nome_disciplina = $nomeDisciplina;
        $disciplina-> id_curso = $idCurso;
        $disciplina->save();
        //PROCURAR O ID DA DISCIPLINA CRIADA

        $idDisciplina = DB::table('disciplinas')
                ->select('id_disciplina')
                ->where([
                    ['nome_disciplina', '=', $nomeDisciplina],
                    ['id_curso', '=', $idCurso],
                ])
                ->get();

        return $idDisciplina;
    }

    public function storeModulo($nomeModulo, $idDisciplina){
        DB::table('modulos')->insert([
            'nome_modulo' => $nomeModulo,
            'id_disciplina' => $idDisciplina,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        $idModulo = DB::table('modulos')
                    ->select('id_modulo')
                    ->where([
                    ['nome_modulo', '=', $nomeModulo],
                    ['id_disciplina', '=', $idDisciplina],
                    ])
        ->get();

        return $idModulo;
    }

}
