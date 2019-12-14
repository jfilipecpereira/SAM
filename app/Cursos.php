<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cursos extends Model
{
    //
    public $timestamps = true;


    public function disciplina(){

        //return $this->hasMany('App\permissoes', 'id', 'permissao');

        return $this->hasMany('App\Disciplinas', 'id_discilina', 'id_curso');

    }
}
