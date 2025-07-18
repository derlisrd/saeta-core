<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $table = 'empresa';
    protected $fillable = [
        'nombre',
        'ruc',
        'telefono',
        'direccion',
        'propietario',
        'licencia',
        'configurado'
    ];
    
}
