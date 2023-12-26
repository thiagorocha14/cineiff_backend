<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolicitacaoReserva extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'nome_evento',
        'justificativa',
        'instituicao',
        'publico_alvo',
        'inicio',
        'fim',
        'anexo',
        'nome_solicitante',
        'documento',
        'telefone',
        'email',
        'descricao',
        'filme_id',
        'justificativa_indeferimento',
    ];

    public function filme()
    {
        return $this->belongsTo(Filme::class);
    }

    public function reserva()
    {
        return $this->hasOne(Reserva::class);
    }
}
