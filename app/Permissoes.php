<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permissoes extends Model
{
    //
    public $timestamps = true;

    protected $fillable = [
        'id', 'nome',

    ];

    public function Users(){

        return $this->hasMany('App\User');
    }


}
