<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
Use App\Professores;

class ModulosUfcds extends Model
{

    public $timestamps = true;
    protected $table = 'modulos';
    protected $primaryKey = 'id_modulo';


    public function Notas(){

        return $this->hasMany('App\Notas', 'id_modulo', 'id_nota');
    }

    public function professor(){

         return $this->belongsTo('App\Professores', 'id_professor', 'id_professor');
    }

    public function disciplina(){

        return $this->belongsTo('App\Disciplinas', 'id_disciplina', 'id_disciplina');
   }

}
