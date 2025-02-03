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
        'formas_pago_id',
        'moneda_id',
        'aplicar_impuesto',
        'tipo',
        'porcentaje_descuento',
        'descuento',
        'total',
        'estado'
    ];

    public function items()
    {
        return $this->hasMany(PedidoItems::class, 'pedido_id');
    }
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    public function formaPago()
    {
        return $this->belongsTo(FormasPago::class, 'formas_pago_id');
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
