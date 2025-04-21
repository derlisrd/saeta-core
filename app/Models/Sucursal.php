<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;
    protected $table = 'sucursales';
    protected $fillable = [
        'empresa_id',
        'nombre',
        'descripcion',
        'direccion',
        'telefono',
        'numero'
    ];

    public function impresoras(){
        return $this->hasMany(Impresora::class);
    }
}
