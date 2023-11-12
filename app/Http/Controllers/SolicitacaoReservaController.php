<?php

namespace App\Http\Controllers;

use App\Mail\SolicitacaoReservaMail;
use App\Models\Reserva;
use Illuminate\Http\Request;
use App\Models\SolicitacaoReserva;
use DB;
use Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SolicitacaoReservaController extends Controller
{
    public function index()
    {
        try {
            $solicitacaoReservas = SolicitacaoReserva::all();
            return response()->json($solicitacaoReservas, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao listar solicitações de reserva.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {

            //Validate
            $validateSolicitacaoReserva = Validator::make(
                $request->all(),
                [
                    'nome_evento' => 'required',
                    'justificativa' => 'required',
                    'instituicao' => 'required',
                    'publico_alvo' => 'required',
                    'inicio' => 'required',
                    'fim' => 'required',
                    'nome_solicitante' => 'required',
                    'documento' => 'required',
                    'telefone' => 'required',
                    'email' => 'required',
                    'descricao' => 'required',
                ]
            );

            // header('Access-Control-Allow-Origin: *');
            // header('Access-Control-Allow-Methods: *');
            // header('Access-Control-Allow-Headers: *');
            // dd($request->all());

            if ($validateSolicitacaoReserva->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Solicitação de reserva inválida',
                    'errors' => $validateSolicitacaoReserva->errors()
                ], 401);
            }

            DB::beginTransaction();


            $solicitacaoReserva = SolicitacaoReserva::create([
                'nome_evento' => $request->nome_evento,
                'justificativa' => $request->justificativa,
                'instituicao' => $request->instituicao,
                'publico_alvo' => $request->publico_alvo,
                'inicio' => $request->inicio,
                'fim' => $request->fim,
                'anexo' => $request->anexo,
                'nome_solicitante' => $request->nome_solicitante,
                'documento' => $request->documento,
                'telefone' => $request->telefone,
                'email' => $request->email,
                'descricao' => $request->descricao,
                'filme_id' => $request->filme_id,
            ]);

            DB::commit();



            return response()->json([
                'status' => true,
                'message' => 'Solicitação de reserva cadastrada com sucesso.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Erro ao cadastrar solicitação de reserva.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        return SolicitacaoReserva::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $solicitacaoReserva = SolicitacaoReserva::findOrFail($id);

            $user_id = auth('sanctum')->user()->id;

            $reserva = Reserva::create([
                'inicio' => $solicitacaoReserva->inicio,
                'fim' => $solicitacaoReserva->fim,
                'user_id' => $user_id,
                'solicitacao_reserva_id' => $solicitacaoReserva->id,
                'status' => 'agendado',
            ]);

            $solicitacaoReserva->status = 'aprovado';
            $solicitacaoReserva->save();

            Mail::to($solicitacaoReserva->email)->send(new SolicitacaoReservaMail($solicitacaoReserva));
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Reserva agendada com sucesso.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Erro ao aprovar reserva.',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $solicitacaoReserva = SolicitacaoReserva::findOrFail($id);
            $solicitacaoReserva->status = 'reprovado';
            $solicitacaoReserva->save();
            return response()->json([
                'status' => true,
                'message' => 'Solicitação de reserva excluída com sucesso.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao excluir solicitação de reserva.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
