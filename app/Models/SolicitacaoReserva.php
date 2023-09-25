<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolicitacaoReserva extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nome_evento', 'justificativa', 'instituicao', 'publico_alvo', 'inicio', 'fim',
        'anexo', 'nome_solicitante', 'documento', 'telefone', 'email', 'descricao', 'filme_id'
    ];

    public function filme()
    {
        return $this->belongsTo(Filme::class);
    }
}
