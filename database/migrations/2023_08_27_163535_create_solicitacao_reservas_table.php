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

            $table->bigInteger('evento_id')->unsigned();
            $table->foreign('evento_id')->references('id')->on('eventos');

            $table->string('justificativa');
            $table->string('nome');
            $table->string('telefone');
            $table->string('email');
            $table->string('instituicao');
            $table->string('publico_alvo');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
