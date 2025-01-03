<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = [
        'producto_id',
        'deposito_id',
        'cantidad'
    ];

    public function producto(){
        return $this->belongsTo(Producto::class);
    }
    public function deposito(){
        return $this->belongsTo(Deposito::class, 'deposito_id');
    }
}
