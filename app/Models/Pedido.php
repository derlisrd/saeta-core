<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $fillable = [
        'cliente_id',
        'formas_pago_id',
        'aplicar_impuesto',
        'tipo',
        'porcentaje_descuento',
        'descuento',
        'total'
    ];
}
