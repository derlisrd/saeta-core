<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';
    protected $fillable = [
        'user_id',
        'credito_id',
        'cliente_id',
        'monto',
    ];
}
