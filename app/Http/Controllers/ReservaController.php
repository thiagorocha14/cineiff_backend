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

    public function reservasConfirmadas()
    {
        try {
            $reservas = Reserva::where('status', 'agendado')->where('fim', '>', date('Y-m-d'))->get();
            $reservas->map(function ($reserva) {
                $reserva->title = $reserva->solicitacao_reserva->nome_evento;
                $reserva->description = $reserva->solicitacao_reserva->descricao;
                if ($reserva->solicitacao_reserva->anexo) {
                    $reserva->image = asset($reserva->solicitacao_reserva->anexo);
                } else if ($reserva->solicitacao_reserva->filme && $reserva->solicitacao_reserva->filme->imagem) {
                    $reserva->image = asset($reserva->solicitacao_reserva->filme->imagem);
                }
                return $reserva;
            });
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
