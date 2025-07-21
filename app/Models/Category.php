<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = [
        'nombre',
        'descripcion',
        'publicado'
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'category_id');
    }
}
