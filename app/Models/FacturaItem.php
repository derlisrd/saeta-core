<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturaItem extends Model
{
    use HasFactory;
    protected $table = 'facturas_items';
    protected $fillable = [
        'factura_id',
        'producto_id',
        'impuesto_id',
        'cantidad',
        'precio',
        'descuento',
        'total'
    ];
}
