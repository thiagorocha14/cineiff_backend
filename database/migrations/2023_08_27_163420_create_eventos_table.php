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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->string('nome');
            $table->dateTime('inicio');
            $table->dateTime('fim');
            $table->string('descricao');
            $table->binary('anexo')->nullable();

            $table->bigInteger('filme_id')->unsigned()->nullable();
            $table->foreign('filme_id')->references('id')->on('filmes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
