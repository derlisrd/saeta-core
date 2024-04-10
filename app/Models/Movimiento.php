<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;
    protected $fillable =[
        'user_id',
        'caja_id',
        'descripcion',
        'valor',
        'forma_transaccion',
        'tipo'
    ];
}
