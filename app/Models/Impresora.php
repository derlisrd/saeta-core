<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Impresora extends Model
{
    protected $fillable = [
        'sucursal_id',
        'nombre',
        'modelo',
        'mm',
        'activo',
    ];
}
