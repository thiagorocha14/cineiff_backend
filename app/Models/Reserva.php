<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reserva extends Model
{
    use SoftDeletes;

    protected $fillable = ['inicio', 'fim', 'status', 'user_id', 'solicitacao_reserva_id'];

    public function responsavel()
    {
        return $this->belongsTo(User::class);
    }

    public function solicitacao()
    {
        return $this->belongsTo(SolicitacaoReserva::class);
    }
}