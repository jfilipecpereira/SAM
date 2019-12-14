{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    @if(isset($dados['protect']) && $dados['protect']==589)
        <div class="jumbotron">
            <h1 class="display-4">Ainda não tens notas</h1>
            <p class="lead">Ainda não foram lançadas notas de nenhum módulo. </p>
            <hr class="my-4">
            <p>Para mais informações dirige-te à secretaria.</p>

          </div>
    @else{
        <script>window.location = "/aluno";</script>
    }@endif

@stop



