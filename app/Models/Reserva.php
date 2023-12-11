<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reserva extends Model
{
    use SoftDeletes;

    protected $fillable = ['inicio', 'fim', 'status', 'user_id', 'solicitacao_reserva_id'];
    protected $with = ['responsavel', 'solicitacao_reserva'];
    protected $appends = ['lugares_disponiveis'];

    //when model calls update all reserva status if fim is less than current date
    public static function boot()
    {
        parent::boot();
        static::retrieved(function ($model) {
            self::updateStatusReservas();
        });
    }

    public function responsavel()
    {
        return $this->belongsTo(User::class);
    }

    public function ingressos()
    {
        return $this->hasMany(Ingresso::class);
    }

    public function solicitacao_reserva()
    {
        return $this->belongsTo(SolicitacaoReserva::class);
    }

    public static function updateStatusReservas()
    {
        $reservas = Reserva::where('status', 'agendado')->where('fim', '<', date('Y-m-d H:i:s'));
        $reservas->update(['status' => 'concluido']);
    }

    public function getLugaresDisponiveisAttribute()
    {
        return env('QUANTIDADE_DE_INGRESSOS') - $this->ingressos()->count();
    }
}
