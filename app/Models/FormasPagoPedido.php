<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormasPagoPedido extends Model
{
    use HasFactory;
    protected $table = 'formas_pago_pedidos';
    protected $fillable = [
        'pedido_id',
        'abreviatura',
        'forma_pago_id',
        'monto',
        'detalles'
    ];
}
