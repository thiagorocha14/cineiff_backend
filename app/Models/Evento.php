<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model
{
    use SoftDeletes;
    protected $fillable = ['nome', 'descricao', 'anexo', 'inicio', 'fim'];

    public function filme()
    {
        return $this->belongsTo(Filme::class);
    }
}
