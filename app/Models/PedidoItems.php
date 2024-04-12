<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoItem extends Model
{
    use HasFactory;
    protected $table ='pedidos_items';
    protected $fillable= [
        'pedido_id',
        'producto_id',
        'impuesto_id',
        'cantidad',
        'precio',
        'descuento',
        'total'
    ];
}
