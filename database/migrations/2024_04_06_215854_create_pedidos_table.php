<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cliente_id')->unsigned()->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->bigInteger('sucursal_id')->unsigned()->nullable();
            $table->boolean('aplicar_impuesto')->default(1);
            $table->string('obs')->nullable();
            $table->tinyInteger('tipo')->default(1); // 1 venta normal 2 presupuesto 3 ecommerce
            $table->tinyInteger('condicion')->default(0); // 0 contado 1 credito
            $table->float('porcentaje_descuento')->default(0);
            $table->float('descuento')->default(0);
            $table->tinyInteger('estado')->default(1); // 1 pendiente 2 pagado 3 entregado 4 cancelado
            $table->float('total_sin_impuesto',20,2)->nullable();
            $table->float('total',20,2);
            $table->float('importe_final',20,2);
            $table->timestamps();
            $table->foreign('sucursal_id')->references('id')->on('sucursales');
            $table->foreign('cliente_id')->references('id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
