<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoItems extends Model
{
    use HasFactory;
    protected $table ='pedidos_items';
    protected $fillable= [
        'pedido_id',
        'producto_id',
        'deposito_id',
        'stock_id',
        'impuesto_id',
        'cantidad',
        'precio',
        'descuento',
        'total'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id', 'id');
    }
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
    public function impuesto()
    {
        return $this->belongsTo(Impuesto::class, 'impuesto_id');
    }
    public function stock()
    {
        return $this->belongsTo(Stock::class, 'stock_id');
    }
}
