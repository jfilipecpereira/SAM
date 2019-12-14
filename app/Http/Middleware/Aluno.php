<?php

namespace App\Http\Middleware;

use Closure;

class Aluno
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( \Auth::check() ) {

            //Verifica se o tipo de utilizador é Aluno (código de permissão 3)
            //Caso o código de ermissão não seja 3, o utilizador será redirecionado para
            //a página de login com o erro de permissão
            if(auth()->user()->permissao != 4){
                return redirect('/login');
            }

        }
        return $next($request);
    }
}
