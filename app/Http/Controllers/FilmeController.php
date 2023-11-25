<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filme;
use Illuminate\Support\Facades\Validator;

class FilmeController extends Controller
{
    public function index()
    {
        try {
            return Filme::all();
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao listar filmes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            return Filme::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao listar filme',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validateFilme = Validator::make(
                $request->all(),
                [
                    'nome' => 'required',
                    'classificacao_indicativa' => 'required',
                    'sinopse' => 'required',
                    'imagem' => 'mimes:jpeg,jpg,png,gif|max:10000',
                    'duracao_minutos' => 'required',
                ]
            );

            if ($validateFilme->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Erro ao cadastrar filme',
                    'errors' => $validateFilme->errors()
                ], 401);
            }

            $caminhoAnexo = '';
            if ($request->hasFile('anexo') && $request->file('anexo')->isValid()) {
                $file = $request->file('anexo');
                $name = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/filmes', $name);
                $caminhoAnexo = 'storage/filmes/' . $name;
            }

            $filme = new Filme();
            $filme->fill($request->except('anexo'));
            $filme->imagem = $caminhoAnexo;
            $filme->save();

            return response()->json([
                'status' => true,
                'message' => 'Filme cadastrado com sucesso',
                'filme' => $filme
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao cadastrar filme',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $filme = Filme::findOrFail($id);
            $filme->fill($request->all());
            $filme->save();

            return response()->json([
                'status' => true,
                'message' => 'Filme atualizado com sucesso',
                'filme' => $filme
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar filme',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $filme = Filme::findOrFail($id);
            $filme->delete();

            return response()->json([
                'status' => true,
                'message' => 'Filme deletado com sucesso',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao deletar filme',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
