<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Errores extends Model
{
    use HasFactory;
    protected $table='errores';
    protected $fillable = [
        'descripcion'
    ];
}
