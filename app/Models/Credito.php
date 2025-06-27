<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credito extends Model
{
    protected $table = 'creditos';
    protected $fillable = [
        'pedido_id',
        'cliente_id',
        'monto',
        'monto_abonado',
        'cuotas',
        'interes',
        'descuento',
        'pagado',
        'fecha_vencimiento',
    ];

    public function pedido(){
        return $this->belongsTo(Pedido::class);
    }
    public function cobros(){
        return $this->hasMany(Cobro::class);
    }
}
