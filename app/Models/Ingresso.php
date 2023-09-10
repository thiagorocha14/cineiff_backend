<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingresso extends Model
{
    use SoftDeletes;

    protected $fillable = [];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
