<?php

namespace App\Imports;

use App\alunos;
use App\cursos;
use Illuminate\Support\Facades\DB;
use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;

use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel
{

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $curso = cursos::where('nome_curso', '=', $row[4])->first();

        if($curso === null){
            //Criar um novo curso
            $newCurso = new cursos();
            $newCurso->nome_curso = $row[4];
            $newCurso->save();
            //Procurar o curso criado para o associar ao aluno
            $curso = cursos::where('nome_curso', '=', $row[4])->first();
        }


        $aluno = new alunos();
        $aluno->nome_aluno = $row[0];
        $aluno->numero_aluno = $row[3];
        $aluno->id_curso = $curso['id_curso'];
        $aluno->save();

        $id_aluno = DB::table('alunos')
        ->where('numero_aluno', $row[3])->first();

        //$row[0] -> nome do aluno

        //Tirar o primeiro
        $primeiro_nome = explode(' ',trim($row[0]));
        $primeiro_nome = $primeiro_nome[0];

        //Tirar último nome
        $ultimo_nome = explode(' ', $row[0]);
        $ultimo_nome = array_pop($ultimo_nome);


        return new User([
            'id_aluno' => $id_aluno->id_aluno,
            'nome' => $primeiro_nome.' '.$ultimo_nome,
            'password' => \Hash::make($row[2]),
            'email' => $row[1],
            'permissao' => 4,
        ]);


    }
}
