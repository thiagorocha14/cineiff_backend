<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitacaoReserva;
use DB;

class SolicitacaoReservaController extends Controller
{
    public function index()
    {
        return SolicitacaoReserva::all();
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    public function show($id)
    {
        return SolicitacaoReserva::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $solicitacaoReserva = SolicitacaoReserva::findOrFail($id);
        $solicitacaoReserva->update($request->all());

        return $solicitacaoReserva;
    }

    public function destroy($id)
    {
        $solicitacaoReserva = SolicitacaoReserva::findOrFail($id);
        $solicitacaoReserva->delete();

        return 204;
    }
}
