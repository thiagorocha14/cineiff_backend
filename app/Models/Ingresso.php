<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingresso extends Model
{

    protected $fillable = [
        'reserva_id',
        'email',
        'documento',
    ];

    // boot
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->verificarDisponibilidade();
            $model->uuid = \Str::uuid();
        });
    }

    public function verificarDisponibilidade()
    {
        $ingressos = Ingresso::where('reserva_id', $this->reserva_id)->count();
        if ($ingressos >= env('QUANTIDADE_DE_INGRESSOS')) {
            throw new \Exception('Limite de ingressos atingido.');
        }
    }

    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }

}
