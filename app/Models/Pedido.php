<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    const ESTADOS = ['generado', 'impreso', 'rendido', 'entregado', 'cancelado'];
    const TIPOS = ['mostrador', 'presupuesto', 'ecommerce'];
    protected $fillable = [
        'cliente_id',
        'user_id',
        'moneda_id',
        'aplicar_impuesto',
        'tipo',
        'porcentaje_descuento',
        'descuento',
        'total',
        'importe_final',
        'estado'
    ];

    public function items()
    {
        return $this->hasMany(PedidoItems::class, 'pedido_id');
    }
    public function productos()
    {
        return $this->hasManyThrough(
            Producto::class,  // Modelo destino
            PedidoItems::class,      // Modelo intermedio
            'pedido_id',      // Clave foránea en la tabla intermedia (items) que apunta a pedidos
            'id',             // Clave primaria en la tabla destino (productos)
            'id',             // Clave primaria en la tabla origen (pedidos)
            'producto_id'     // Clave foránea en la tabla intermedia (items) que apunta a productos
        );
    }
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    public function formasPagoPedido()
    {
        return $this->hasMany(FormasPagoPedido::class, 'pedido_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function moneda()
    {
        return $this->belongsTo(Moneda::class, 'moneda_id');
    }
}
