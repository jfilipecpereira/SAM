{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

<!-- Ecra dividido para tabela e gráfico -->

<div class="row" style="border-color:red;">
    <div class="col-8">
            <div class="card mb-3">
                    <div class="card-header">
                            <i class="fa fa-table" aria-hidden="true" style="margin-right:10px;"></i>Alunos com mais módulos em atraso
                        </div>

                    <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Aluno</th>
                                <th scope="col">Nº de Módulos</th>
                                <th scope="col">Turma</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dados["tabelaModulos"] as $item)
                                <tr>
                                    <td>{{ $item[0]['nome_aluno'] }}</td>
                                    <td>{{ $item[1] }}</td>
                                    <td>{{ $item[0]['cursos']['nome_curso'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    <div class="card-footer small text-muted">Classificações atualizadas</div>
            </div>
    </div>

    <div class="col-4">
            <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-chart-pie" style="margin-right:10px;"></i>Estatística geral de módulos
                    </div>

                        <div class="vertical-center align-middle" style="height: 283px; margin-top:50px;">

                            {!! $dados['chartjs']->render() !!}

            </div>
            <div class="card-footer small text-muted">Classificações atualizadas</div>
        </div>
</div>


    </div>
</div>
<div class="card mb-3">
        <div class="card-header">
                <i class="fa fa-table" aria-hidden="true" style="margin-right:10px;"></i>Notas por disciplinas
            </div>

        <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>

            <!-- Tabela do data table global -->
            <table class="table table-bordered" id="laravel_datatable">
                <thead>
                    <tr>
                    <th scope="col">Nota</th>
                    <th scope="col">Aluno</th>
                    <th scope="col">Turma</th>
                    <th scope="col">Disciplina</th>
                    <th scope="col">Modulo</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="card-footer small text-muted">Classificações atualizadas</div>
</div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
            $(document).ready( function () {
             $('#laravel_datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('Secretariadatatable') }}",
                    columns: [
                             { data: 'nota', name: 'nota' },
                             { data: 'alunos.nome_aluno', name: 'alunos.nome_aluno' },
                             { data: 'modulos.disciplina.curso.nome_curso', name: 'modulos.disciplina.curso.nome_curso' },
                             { data: 'modulos.disciplina.nome_disciplina', name: 'modulos.disciplina.nome_disciplina' },
                             { data: 'modulos.nome_modulo', name: 'modulos.nome_modulo' }
                          ]
                });
                $.fn.dataTable.ext.errMode = 'throw';

              });
        </script>
@stop
