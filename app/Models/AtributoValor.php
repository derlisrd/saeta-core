<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtributoValor extends Model
{
    protected $table = 'atributos_valores';
    protected $fillable = ['atributo_id', 'valor'];
}
