<?php

namespace App\Http\Controllers;

use App\Mail\IngressoMail;
use App\Models\Ingresso;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class IngressosController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $email = $request->email;
            $documento = $request->documento;
            $reserva_id = $request->reserva_id;

            if (!$email || !$documento || !$reserva_id) {
                throw new \Exception('Dados inválidos.');
            }

            $reserva = Reserva::find($reserva_id);

            $ingressoEmail = $reserva->ingressos()->where('email', $email)->exists();
            if ($ingressoEmail) {
                throw new \Exception('Ingresso já cadastrado para este e-mail.');
            }

            $ingressoDocumento = $reserva->ingressos()->where('documento', $documento)->exists();
            if ($ingressoDocumento) {
                throw new \Exception('Ingresso já cadastrado para este documento.');
            }

            $ingresso = Ingresso::create([
                'email' => $email,
                'documento' => $documento,
                'reserva_id' => $reserva_id
            ]);

            $ingresso->data_inicio = $ingresso->reserva->inicio;
            $ingresso->data_fim = $ingresso->reserva->fim;
            $ingresso->nome_evento = $ingresso->reserva->solicitacao_reserva->nome_evento;
            $ingresso->url = $request->headers->get('origin') . '/ingresso/' . $ingresso->uuid;

            Mail::to($email)->send(new IngressoMail($ingresso));
            DB::commit();
            return response()->json($ingresso, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 401);
        }
    }

    public function show($uuid)
    {
        try {
            $ingresso = Ingresso::where('uuid', $uuid)->first();
            $ingresso->data_inicio = $ingresso->reserva->inicio;
            $ingresso->data_fim = $ingresso->reserva->fim;
            $ingresso->nome_evento = $ingresso->reserva->solicitacao_reserva->nome_evento;

            if (!$ingresso) {
                throw new \Exception('Ingresso não encontrado.');
            }

            return response()->json($ingresso, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 401);
        }
    }
}