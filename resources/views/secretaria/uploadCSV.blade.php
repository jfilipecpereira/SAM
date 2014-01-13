{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>UploadCSV</h1>
@stop

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <i class="fas fa-plus" style="margin-right:10px;"></i>Inserir Alunos
    </div>

    <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>

    @if(isset($dados['erro']))
        <div class="alert alert-warning" role="alert">
            {{ $dados['mensagem'] }}
        </div>
    @elseif(isset($dados['sucesso']))
        {{ $dados['mensagem'] }}

    @endif
        <form action="{{ route('SecretariauploadCSV') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" class="form-control">
            <br>
            <button class="btn btn-success">Importar Alunos</button>
            <a class="btn btn-danger" style="margin-left:10px;" href="{{ route('SecretariaindexSecretaria') }}">Voltar</a>
        </form>
    </div>
    <div class="card-footer small text-muted">Criação de novos alunos</div>
</div>
</div>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

