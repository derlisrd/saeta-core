<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoAtributoValor extends Model
{
    protected $table = 'producto_atributo_valores';
    protected $fillable = ['producto_id','atributo_id','atributo_valor_id'];
}
