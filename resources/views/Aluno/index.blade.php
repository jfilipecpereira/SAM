{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
    <div class="col-7">
            <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-chart-bar" style="margin-right:10px;"></i>Média por disciplina
                    </div>

                    <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>

                        <div>
                            {!! $dados['barras']->render() !!}
                        </div>
                    </div>
                    <div class="card-footer small text-muted">Classificações atualizadas</div>
            </div>
    </div>



    <div class="col-5">
        <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-chart-bar" style="margin-right:10px;"></i>Média de curso
                </div>

                <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>


                        <div id="gauge" style="height: 335px;"></div>

                </div>
                <div class="card-footer small text-muted">Classificações atualizadas</div>
        </div>
</div>




</div>
<br/><br/>

<div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-chart-bar" style="margin-right:10px;"></i>Classificação geral de todos os módulos/UFCD
        </div>

        <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>

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
    <script> console.log('Hi!'); </script>
    <script>
        $(document).ready( function () {
         $('#laravel_datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ app('url')->route('Alunodatatable', 1234) }}",
                columns: [
                         { data: 'nota', name: 'nota' },
                         { data: 'alunos.nome_aluno', name: 'alunos.nome_aluno' },
                         { data: 'modulos.disciplina.curso.nome_curso', name: 'modulos.disciplina.curso.nome_curso' },
                         { data: 'modulos.disciplina.nome_disciplina', name: 'modulos.disciplina.nome_disciplina' },
                         { data: 'modulos.nome_modulo', name: 'modulos.nome_modulo' },
                      ]
             });
          });
    </script>

    <script>

       var g = new JustGage({
            id: "gauge",
            decimals: true,
            value: {{$dados['mediaTotal']}},
            min: 0,
            max: 20,
            label: "Média total de notas"
        });
    </script>
@stop


