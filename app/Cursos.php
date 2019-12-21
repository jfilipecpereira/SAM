<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cursos extends Model
{
    //
    public $timestamps = true;


    public function alunos(){
        return $this->hasMany('App\alunos', 'id_curso', 'id_curso');

    }


    public function disciplina(){

        return $this->hasMany('App\Disciplinas', 'id_discilina', 'id_curso');

    }
}
