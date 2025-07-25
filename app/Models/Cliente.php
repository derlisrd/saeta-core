<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    protected $fillable = [
        'doc',
        'nombres',
        'apellidos',
        'razon_social',
        'direccion',
        'telefono',
        'email',
        'nacimiento',
        'tipo',
        'extranjero',
        'juridica',
        'web',
        'deletable'
    ];
}
