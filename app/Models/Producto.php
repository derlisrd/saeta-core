<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'creado_por',
        'modificado_por',
        'medida_id',
        'codigo',
        'nombre',
        'descripcion',
        'costo',
        'modo_comision',
        'porcentaje_comision',
        'valor_comision',
        'precio_normal',
        'precio_descuento',
        'precio_minimo',
        'porcentaje_impuesto',
        'disponible',
        'tipo',
        'preguntar_precio',
        'notificar_minimo',
        'cantidad_minima'
    ];
}
