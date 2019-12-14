@extends('layouts.app')

@section('content')
<div class="container">
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

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


@endsection
