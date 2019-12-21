<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Users
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function superUser(){
        return \Auth::user()->permissao == 1;
    }

    public function direcao(){
        return \Auth::user()->permissao == 2;
    }

    public function secretaria(){
        return \Auth::user()->permissao == 3;
    }
}
