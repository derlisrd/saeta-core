<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'medida_id',
        'impuesto_id',
        'creado_por',
        'modificado_por',
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

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function stock()
    {
        return $this->hasMany(Stock::class, 'producto_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'producto_id');
    }
}
