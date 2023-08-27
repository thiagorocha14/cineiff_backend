<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Filme extends Model
{
    use SoftDeletes;
    protected $fillable = ['nome', 'classificacao_indicativa', 'sinopse', 'imagem', 'duracao_minutos'];
}
