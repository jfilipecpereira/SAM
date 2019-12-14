@extends('layouts.app')

@section('content')
<div class="container">



<div class="row mt-8">
    <!-- Tabela do data table global -->
    <table class="table table-bordered" id="laravel_datatable">
        <thead>
            <tr>
            <th scope="col">Nota</th>
            <th scope="col">Aluno</th>
            <th scope="col">Turma</th>
            <th scope="col">Disciplina</th>
            <th scope="col">Modulo</th>
            <th scope="col">Professor</th>
            </tr>
        </thead>
    </table>
</div>


<!-- end of content -->
</div>








<!-- End of document where the scrit is -->
<script>
    $(document).ready( function () {
     $('#laravel_datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('Direcaodatatable') }}",
            columns: [
                     { data: 'nota', name: 'nota' },
                     { data: 'alunos.nome_aluno', name: 'alunos.nome_aluno' },
                     { data: 'modulos.disciplina.curso.nome_curso', name: 'modulos.disciplina.curso.nome_curso' },
                     { data: 'modulos.disciplina.nome_disciplina', name: 'modulos.disciplina.nome_disciplina' },
                     { data: 'modulos.nome_modulo', name: 'modulos.nome_modulo' },
                     { data: 'modulos.professor.nome_professor', name: 'modulos.professor.nome_professor' }
                  ]
         });
      });
</script>

@endsection

