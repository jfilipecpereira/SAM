<?php

namespace App\Http\Controllers;


use App\permissoes;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //Redirect controller
        if(auth()->user()->permissao == 1)
            return redirect()->action('SuperUserController@index');

        //Redirect controller
        if(auth()->user()->permissao == 2)
            return redirect()->action('DirecaoController@index');

        //Redirect controller
        if(auth()->user()->permissao == 3)
            return redirect()->action('SecretariaController@index');

        //Redirect Controller
        if(auth()->user()->permissao == 4)

            return redirect()->action('AlunoController@index');


        return view('login');

    }
}
