<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cobro extends Model
{
    protected $table = 'cobros';
    protected $fillable = [
        'user_id',
        'pedido_id',
        'credito_id',
        'cliente_id',
        'forma_pago_id',
        'monto',
    ];
}
