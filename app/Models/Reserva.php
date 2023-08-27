<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reserva extends Model
{
    use SoftDeletes;

    protected $fillable = ['inicio', 'fim', 'status'];

    public function responsavel()
    {
        return $this->belongsTo(User::class);
    }

    public function solicitacao()
    {
        return $this->belongsTo(SolicitacaoReserva::class);
    }
}
