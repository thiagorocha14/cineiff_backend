<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('filmes', function (Blueprint $table) {
            $table->longText('sinopse')->change();
        });
        Schema::table('solicitacao_reservas', function (Blueprint $table) {
            $table->longText('justificativa')->change();
            $table->longText('descricao')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('filmes', function (Blueprint $table) {
            $table->string('sinopse')->change();
        });
        Schema::table('solicitacao_reservas', function (Blueprint $table) {
            $table->string('justificativa')->change();
            $table->string('descricao')->change();
        });
    }
};