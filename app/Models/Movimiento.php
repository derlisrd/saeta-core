<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    public const FORMA_EFECTIVO = 1;
    public const FORMA_DIGITAL_BANCO = 2;
    public const TIPO_INGRESO = 1;
    public const TIPO_EGRESO = 0;
    public const TIPO_NEUTRO = 2;

    protected $fillable =[
        'user_id',
        'pedido_id',
        'caja_id',
        'descripcion',
        'valor',
        'forma_transaccion',
        'tipo'
    ];
}
