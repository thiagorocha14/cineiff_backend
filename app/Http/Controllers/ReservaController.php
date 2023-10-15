<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function index()
    {
        try {
            $reservas = Reserva::all();
            return response()->json($reservas, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao listar reservas.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}