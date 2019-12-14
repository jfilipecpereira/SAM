<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notas', function (Blueprint $table) {
            $table->bigIncrements('id_nota')->unsigned();
            $table->date('data_final');
            $table->integer('nota');
            $table->bigInteger('id_aluno')->nullable()->unsigned();
            $table->bigInteger('id_modulo')->nullable()->unsigned();
            $table->timestamps();

            //Chaves estrangeiras
            $table->foreign('id_aluno')->references('id_aluno')->on('alunos')->onDelete('cascade');
            $table->foreign('id_modulo')->references('id_modulo')->on('modulos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notas');
    }
}
