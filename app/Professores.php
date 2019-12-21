<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Professores extends Model
{
    //
    protected $table = 'professores';
    protected $primaryKey = 'id_professor';

    public function modulos(){

        //return $this->hasMany('App\permissoes', 'id', 'permissao');
        return $this->hasMany('App\ModulosUfcds', 'id_professor', 'id_modulo');



    }
}
