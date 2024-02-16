<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use App\Models\TentativasMalsucedidas;

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
            $reservas = Reserva::where('status', 'agendado')
                ->where('fim', '>', date('Y-m-d'));
            $reservas = $reservas->orderBy('inicio', 'asc');
            $reservas = $reservas->get();

            $reservas->map(function ($reserva) {
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

    public function show($id)
    {
        try {
            $reserva = Reserva::find($id);
            $reserva->lugares_disponiveis;
            $reserva->total_lugares = env('QUANTIDADE_DE_INGRESSOS');
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

    public function relatorio(Request $request)
    {
        try {
            $data_inicio = $request->data_inicio;
            $data_fim = $request->data_fim;

            $reservas = Reserva::whereIn('status', ['agendado', 'concluido']);
            $reservas = $reservas->whereBetween('inicio', [$data_inicio, $data_fim]);
            $reservas = $reservas->orderBy('inicio', 'desc');
            $reservas = $reservas->get();

            if (!$reservas) {
                return response()->json([
                    'status' => false,
                    'message' => 'Nenhuma reserva encontrada.',
                ], 404);
            }

            $qtdeTentativasMalSucedidas = TentativasMalsucedidas::whereBetween('inicio', [$data_inicio, $data_fim])->count();

            return response()->json(['reservas' => $reservas, 'qtdeTentativasMalSucedidas' => $qtdeTentativasMalSucedidas], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao listar reservas.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}