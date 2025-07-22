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
        Schema::create('pedidos_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pedido_id')->unsigned();
            $table->bigInteger('producto_id')->unsigned();
            $table->bigInteger('impuesto_id')->unsigned();
            $table->foreignId('deposito_id')->constrained('depositos');
            $table->float('cantidad');
            $table->float('precio');
            $table->float('comision')->nullable();
            $table->float('descuento');
            $table->float('total');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('pedido_id')->references('id')->on('pedidos');
            $table->foreign('impuesto_id')->references('id')->on('impuestos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_items');
    }
};
