<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposito extends Model
{
    use HasFactory;
    protected $table = 'depositos';
    protected $fillable = [
        'sucursal_id',
        'nombre',
        'descripcion',
        'activo'
    ];

    public function stock(){
        return $this->hasMany(Stock::class);
    }
    
}
