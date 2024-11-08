<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;
    protected $table = 'cajas';
    protected $fillable = [
        'user_id',
        'nombre',
        'descripcion',
        'monto_inicial',
        'monto_efectivo',
        'monto_sin_efectivo',
        'estado',
    ];
}
