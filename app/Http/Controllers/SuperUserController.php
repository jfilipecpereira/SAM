<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Permissoes;

class SuperUserController extends Controller
{

    public function index(){

        //ir buscar os dados em JSON
        $dados = User::with('permissao')
                ->where('permissao', '!=', 4)
                ->get()
                ->toJson();

        //Retornar a view com os dados em JSON descodificados
        //Desta forma enviam-se os dados das relações
        return view('superUser.ver')->with('dados', json_decode($dados, true));
    }


    public function showEditForm($id){
        $items = permissoes::all();
        $utilizador = User::find($id);

        $dados['items'] = $items;
        $dados['utilizador'] = $utilizador;
        $dados['titulo'] = 'ISAM | Administrção';

        return $dados;

        //return $dados['utilizador']->id;
        return view('superUser.editar')->with('dados', $dados);

    }

    public function update(Request $request, $id){

        $user = User::findOrFail($id);
        //Fazer uma cópia temporária do user
        $userTMP = $user;

        if($request->nome == ''){
            $user->nome = $userTMP->nome;
        }else{
            $user->nome = $request->nome;
        }

        if($request->email == ''){
            $user->email = $userTMP->email;
        }else{
            $user->email = $request->email;
        }

        if($request->password == ''){
            $user->password = $userTMP->password;
        }else if($request->password != $request->password_confirm){
            print('erro');
        }else{
            $user->password = bcrypt($request->password);
        }

        $user->save();

        $items = permissoes::all();
        $utilizador = User::find($id);

        $dados['items'] = $items;
        $dados['utilizador'] = $utilizador;
        $dados['success'] = 'Dados de utilizador atualizados com sucesso!';



        return view('superUser.editar')->with('dados', $dados);

    }

    public function apagar($id){

        //Procura o utilizador
        $utilizador = User::findOrFail($id);

        //E apaga-o
        $nome = $utilizador->nome;
        User::destroy($id);

        return redirect()->route('SuperUserver')->with('success','O utilizador '.$nome.' foi apagado com sucesso!');

    }

}
