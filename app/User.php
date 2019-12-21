<?php

namespace App;

use Hamcrest\Core\HasToString;
use Laravel\Passport\HasApiTokens;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = true;
    protected $fillable = [
        'nome', 'email', 'password', 'permissao', 'id_aluno',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function permissao(){

        return $this->hasOne('App\Permissoes', 'id', 'permissao');

    }

    public function Aluno(){
        return $this->hasMany('App\Alunos', 'id_aluno', 'id_aluno');
    }

    //Mutator para ir buscar o titulo da pagina
    public function getTituloAttribute()
    {
        $titulo = Permissoes::where('id', auth()->user()->permissao)->get();
        return $titulo[0]->titulo_pagina;
    }

}
