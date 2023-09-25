<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('solicitacao_reservas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->string('nome_evento');
            $table->string('justificativa');
            $table->string('instituicao');
            $table->string('publico_alvo');
            $table->dateTime('inicio');
            $table->dateTime('fim');
            $table->binary('anexo')->nullable();

            $table->string('nome_solicitante');
            $table->string('documento');
            $table->string('telefone');
            $table->string('email');
            $table->string('descricao');

            $table->bigInteger('filme_id')->unsigned()->nullable();
            $table->foreign('filme_id')->references('id')->on('filmes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitacao_reservas');
    }
};
