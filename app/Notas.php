<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class notas extends Model
{
    //

    protected $table = 'notas';
    protected $primaryKey = 'id_nota';
    public $timestamps = true;


    public function modulos(){

        return $this->belongsTo('App\ModulosUfcds', 'id_modulo', 'id_modulo');

    }

    public function alunos(){

        return $this->hasOne('App\Alunos', 'id_aluno', 'id_aluno');

    }




}
