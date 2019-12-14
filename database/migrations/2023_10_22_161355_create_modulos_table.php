<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modulos', function (Blueprint $table) {
            $table->bigIncrements('id_modulo')->unsigned();
            $table->string('nome_modulo');
            //$table->bigInteger('id_professor')->unsigned()->nullable();
            $table->bigInteger('id_disciplina')->unsigned()->nullable();
            $table->timestamps();

            //Chaves estrangeiras
            //$table->foreign('id_professor')->references('id_professor')->on('professores')->onDelete('cascade');
            $table->foreign('id_disciplina')->references('id_disciplina')->on('disciplinas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modulos');
    }
}
