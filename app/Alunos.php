<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class alunos extends Model
{
    //
    protected $table = 'alunos';
    protected $primaryKey = 'id_aluno';
    public $timestamps = true;

    public function Notas(){

        //return $this->hasMany('App\Comment', 'foreign_key', 'local_key');

        return $this->belongsTo('App\Notas', 'id_aluno', 'id_nota');
    }

    public function Users(){
        return $this->belognsTo('App\User', 'id_aluno', 'numero_aluno');
    }

    public function cursos(){
        return $this->belongsTo('App\Cursos', 'id_curso', 'id_curso');
    }
}
