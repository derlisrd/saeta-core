<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisosOtorgado extends Model
{
    use HasFactory;
    protected $table ='permisos_otorgados';
    protected $fillable = [
        'user_id',
        'permiso_id',
        'otorgado'
    ];
}
