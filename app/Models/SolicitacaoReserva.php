<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolicitacaoReserva extends Model
{
    use SoftDeletes;
    protected $fillable = ['justificativa', 'nome', 'telefone', 'email', 'instituicao', 'publico_alvo'];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function solicitante()
    {
        return $this->belongsTo(User::class);
    }
}
