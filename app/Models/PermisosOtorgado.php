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

    protected $hidden = [
        'created_at',
        'user_id',
        'updated_at'
    ];

    public function permiso(){
        return $this->belongsTo(Permiso::class);
    }

}
