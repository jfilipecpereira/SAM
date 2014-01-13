{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Gestão de utilizadores</h1>
@stop

@section('content')

    @if (isset($dados['success']) && strlen($dados['success']) != 0)
        <div class="alert alert-success">
            <p>{{ $dados['success'] }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
        <br />
    @endif

    <div class="row">
        <div class="col-sm-8 offset-sm-2">


            <form method="post" action="{{ route('SuperUserupdate', $dados['utilizador']->id) }}">
                @method('PATCH')
                @csrf
                <div class="form-group">
                    <label for="first_name">Nome:</label>
                    <input type="text" class="form-control" name="nome"  value="{{ $dados['utilizador']->nome }}" />
                </div>

                <div class="form-group">
                    <label for="first_name">Email:</label>
                    <input type="text" class="form-control" name="email"  value="{{ $dados['utilizador']->email }}"/>
                </div>

                <div class="form-group">
                    <label for="first_name">Password:</label>
                    <input type="text" class="form-control" name="password"  />
                </div>

                <div class="form-group">
                    <label for="first_name">Confirmação de Password:</label>
                    <input type="text" class="form-control" name="password_confirm"  />
                </div>

                <div class="form-group">
                    <label for="permissao" >{{ __('Tipo de utilizador') }}</label>
                        <select name="permissao" class="form-control">
                            @foreach ($dados['items'] as $item)
                                @if ($dados['utilizador']->id_permissao === $item->id)
                                    <option value="{{ $item->id_permissao }}" selected="selected">{{$item->nome}}</option>
                                @else
                                    <option value="{{ $item->id_permissao }}">{{$item->nome}}</option>
                                @endif

                            @endforeach
                            </select>
                </div>


                <button type="submit" class="btn btn-primary">Update</button>
                <a class="btn btn-danger" style="margin-left:10px;" href="{{ route('SuperUserverp') }}">Voltar</a>
            </form>
        </div>
    </div>

    @stop

    @section('css')
        <link rel="stylesheet" href="/css/admin_custom.css">
    @stop

    @section('js')
    @stop

