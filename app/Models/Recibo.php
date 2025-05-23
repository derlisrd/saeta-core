<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    use HasFactory;
    protected $table = 'recibos';
    protected $fillable = [
        'cliente_id',
        'factura_id',
        'numero',
        'monto',
        'descripcion'
    ];
}
