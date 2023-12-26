<?php

namespace App\Http\Controllers;

use App\Mail\NovaSolicitacaoMail;
use App\Mail\SolicitacaoReservaMail;
use App\Models\Reserva;
use Illuminate\Http\Request;
use App\Models\SolicitacaoReserva;
use App\Models\User;
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
                    'anexo' => 'mimes:png,jpg,jpeg',
                ]
            );

            if ($validateSolicitacaoReserva->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Solicitação de reserva inválida',
                    'errors' => $validateSolicitacaoReserva->errors()
                ], 401);
            }

            DB::beginTransaction();

            // salvando arquivo
            $caminhoAnexo = '';
            if ($request->hasFile('anexo') && $request->file('anexo')->isValid()) {
                $file = $request->file('anexo');
                $name = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/reservas', $name);
                $caminhoAnexo = 'storage/reservas/' . $name;
            }


            $periodo = SolicitacaoReserva::where(function ($query) use ($request) {
                $query->whereBetween('inicio', [$request->inicio, $request->fim])
                    ->orWhereBetween('fim', [$request->inicio, $request->fim])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('inicio', '<=', $request->inicio)
                            ->where('fim', '>=', $request->fim);
                    });
            })
                ->where('status', '!=', 'indeferido')
                ->exists();

            if ($periodo) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Já existe uma solicitação de reserva para esse período.',
                ], 401);
            }

            $solicitacaoReserva = SolicitacaoReserva::create([
                'nome_evento' => $request->nome_evento,
                'justificativa' => $request->justificativa,
                'instituicao' => $request->instituicao,
                'publico_alvo' => $request->publico_alvo,
                'inicio' => $request->inicio,
                'fim' => $request->fim,
                'anexo' => $caminhoAnexo,
                'nome_solicitante' => $request->nome_solicitante,
                'documento' => $request->documento,
                'telefone' => $request->telefone,
                'email' => $request->email,
                'descricao' => $request->descricao,
                'filme_id' => $request->filme_id,
            ]);

            User::all()->each(function ($user) use ($solicitacaoReserva) {
                Mail::to($user->email)->send(new NovaSolicitacaoMail($solicitacaoReserva));
            });

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

            $solicitacaoReserva->status = 'deferido';
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

    public function destroy($id, Request $request)
    {
        try {
            $solicitacaoReserva = SolicitacaoReserva::findOrFail($id);
            $solicitacaoReserva->status = 'indeferido';
            $solicitacaoReserva->justificativa_indeferimento = $request->justificativa_indeferimento;
            $solicitacaoReserva->save();
            return response()->json([
                'status' => true,
                'message' => 'Solicitação de reserva indeferida com sucesso.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao indeferir solicitação de reserva.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function recuperar($id)
    {
        try {
            $solicitacaoReserva = SolicitacaoReserva::findOrFail($id);
            $solicitacaoReserva->status = 'pendente';
            $solicitacaoReserva->save();
            return response()->json([
                'status' => true,
                'message' => 'Solicitação de reserva recuperada com sucesso.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao recuperar solicitação de reserva.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
