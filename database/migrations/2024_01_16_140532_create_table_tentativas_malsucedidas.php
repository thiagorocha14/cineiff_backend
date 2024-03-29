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
        Schema::create('tentativas_malsucedidas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nome_evento');
            $table->dateTime('inicio');
            $table->dateTime('fim');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_tentativas_malsucedidas');
    }
};