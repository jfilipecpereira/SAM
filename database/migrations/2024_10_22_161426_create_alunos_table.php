<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlunosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alunos', function (Blueprint $table) {
            $table->bigIncrements('id_aluno')->unsigned();
            $table->string('nome_aluno');
            $table->integer('numero_aluno');
            $table->bigInteger('id_curso')->unsigned();
            $table->timestamps();


            //Chaves estrangeiras
            $table->foreign('id_curso')->references('id_curso')->on('cursos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alunos');
    }
}
