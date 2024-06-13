<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CajasArqueo extends Model
{
    use HasFactory;
    protected $table = 'cajas_arqueos';
    protected $fillable = [
        'cerrado_por',
        'inicial',
        'efectivo',
        'digital',
        'sobrantes',
        'faltantes',
        'ventas',
        'pagos',
        'otros',
        'total',
        'descripcion',
        'caja_id'
    ];
}
