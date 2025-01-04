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
        'nombre_fantasia',
        'direccion',
        'telefono',
        'email',
        'nacimiento',
        'tipo',
        'extranjero'
    ];
}
