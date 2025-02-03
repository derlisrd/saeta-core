<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;
    protected $fillable = [
       'cliente_id',
       'empresa_id',
       'timbrado_id',
       'sucursal_id',
       'moneda_id',
       'caja_id',
       'codido_control',
       'descripcion',
       'numero',
       'descuento',
       'total_con_descuento',
       'total_con_impuestos',
       'total_de_impuestos',
       'total_sin_impuestos',
       'total',
       'codicion_venta',
       'aplicar_impuestos',
       'estado'
    ];

    public function items(){
        return $this->hasMany(FacturaItem::class);
    }
}
