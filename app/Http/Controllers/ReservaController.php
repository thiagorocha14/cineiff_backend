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

    public function reservasConfirmadas(Request $request)
    {
        try {
            $somenteComImagem = $request->imagem ?? false;
            $reservas = Reserva::where('status', 'agendado')
                ->where('fim', '>', date('Y-m-d'));
            if ($somenteComImagem) {
                $reservas = $reservas->whereHas('solicitacao_reserva', function ($query) {
                    $query->whereNotNull('anexo')
                        ->orWhereHas('filme', function ($query) {
                            $query->whereNotNull('imagem');
                        });
                });
            }
            $reservas = $reservas->get();

            $reservas->map(function ($reserva) {
                $reserva->title = $reserva->solicitacao_reserva->nome_evento;
                $reserva->description = $reserva->solicitacao_reserva->descricao;
                if ($reserva->solicitacao_reserva->anexo) {
                    $reserva->image = asset($reserva->solicitacao_reserva->anexo);
                } else if ($reserva->solicitacao_reserva->filme && $reserva->solicitacao_reserva->filme->imagem) {
                    $reserva->image = asset($reserva->solicitacao_reserva->filme->imagem);
                }
                $reserva->link = '/reserva' . '/' . $reserva->id;
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

    public function show($id)
    {
        try {
            $reserva = Reserva::find($id);
            $reserva->lugares_disponiveis;
            if ($reserva->solicitacao_reserva->anexo) {
                $reserva->image = asset($reserva->solicitacao_reserva->anexo);
            } else if ($reserva->solicitacao_reserva->filme && $reserva->solicitacao_reserva->filme->imagem) {
                $reserva->image = asset($reserva->solicitacao_reserva->filme->imagem);
            }
            return response()->json($reserva, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao listar reserva.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
