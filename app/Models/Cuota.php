<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
    protected $table = 'cuotas';
    protected $fillable = ['user_id','credito_id','pedido_id','cliente_id','monto','obs'];
}
