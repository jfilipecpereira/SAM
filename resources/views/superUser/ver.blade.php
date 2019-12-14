{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Gestão de utilizadores</h1>
@stop

@section('content')

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

<div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-table" aria-hidden="true" style="margin-right:10px;"></i>Todos os utilizadores
        </div>

        <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>

            <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Email</th>
                            <th scope="col">Tipo de Utilizador</th>
                            <th scope="col">Ação</th>
                        </tr>
                        </thead>
                        <tbody>
                                @foreach($dados as $utilizador)
                                    <tr>

                                        <td>{{ $utilizador['nome'] }}</td>
                                        <td>{{ $utilizador['email'] }}</td>
                                        <td>{{ $utilizador['permissao']['nome'] }}</td>
                                        <td>
                                            <a href="{{ route('SuperUserformEditar', $utilizador['id']  ) }}" class="btn btn-primary">Editar</a>
                                            <form action="{{ route('SuperUserapagar', $utilizador['id']  ) }}" method="post" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit">Apagar</button>
                                            </form>
                                    </tr>
                                @endforeach

                        </tbody>
                </table>
            </div>
            <div class="card-footer small text-muted">A alteração indevida de utilizadores pode levar ao incorreto funcionamento da aplicação</div>
    </div>



        @stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

