<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('users')->insert([
            'name' => 'Administrador',
            'email' => 'cineiffitaperuna@gmail.com',
            'password' => Hash::make('Cineiff!@#'),
            'documento' => '10779511000700',
            'telefone' => '2238262300',
            'tipo' => 'administrador',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $user_id = DB::table('users')->where('email', 'cineiffitaperuna@gmail.com')->first()->id;
        DB::table('reservas')->where('user_id', $user_id)->delete();
        DB::table('users')->where('id', $user_id)->delete();
    }
};