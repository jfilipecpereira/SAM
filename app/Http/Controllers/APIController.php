<?php

namespace App\Http\Controllers;

use App\Notas;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Response;

use App\Disciplinas;

class APIController extends APIgetIdsController
{

    public function index(Request $request)
    {
        /**
         * $request:
         * nota
         * data
         * nomeProfessor
         * nomeAluno
         * nomeCurso
         * nomeDisciplina
         * nomeModulo
         */


        $idAluno = self::checkAluno($request->id_aluno);
        if($idAluno === "ERROR 400"){
            return response('Aluno Inexistente', 400);
        }
        $idCurso = self::checkCurso($request->curso_desc);
        if($idCurso === "ERROR 400"){
            return response('Curso Inexistente', 400);
        }
        $idDisciplina = self::checkDisciplina($idCurso, $request->disc_desc);
        $idModulo = self::checkModulo($idDisciplina, $request->id_modulo);

        //Converter a data
        $originalDate = $request->data_final;
        $newDate = date("Y-m-d", strtotime($originalDate));

        //Ver se existe a nota do estágio
        if($request->id_modulo == 'PAP'){
            $dados = Notas::with('modulos')->where('id_aluno', '=', $idAluno)->get();
            $cnt = 0;
            foreach($dados as $dado){
                if($dado->modulos->nome_modulo == 'FCT'){
                    $cnt ++;
                }
            }

            if($cnt == 0){
                return response('Não pode por a nota da PAP antes da FCT', 401);
            }
        }

        //Depois dos dados todos tratados, insere-se a nota
        $nota = new Notas();
        //Dados da nota
        $nota->nota = $request->nota_val;
        $nota->data_final = $newDate;
        $nota->id_aluno = (int)$idAluno;
        $nota->id_modulo = (int)$idModulo;
        $nota-> created_at = Carbon::now()->format('Y-m-d H:i:s');
        $nota->updated_at = Carbon::now()->format('Y-m-d H:i:s');
        $nota->save();
        return response('Aluno inserido com sucesso', 200);

    }

}
