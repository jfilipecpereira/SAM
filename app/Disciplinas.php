<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disciplinas extends Model
{
    public $timestamps = true;

    public function modulos(){

        //return $this->hasMany('App\permissoes', 'id', 'permissao');

        return $this->hasMany('App\Modulos', 'id_discilina', 'id_modulo');

    }


    public function curso(){

        return $this->belongsTo('App\Cursos', 'id_curso', 'id_curso');
   }
}
