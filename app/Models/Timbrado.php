<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timbrado extends Model
{
    use HasFactory;
    protected $fillable = [
        'empresa_id',
        'inicio_vigencia',
        'fin_vigencia',
        'numero_timbrado',
        'descripcion',
        'autoimpresor',
        'descripcion_autoimpresor'
    ];
}
