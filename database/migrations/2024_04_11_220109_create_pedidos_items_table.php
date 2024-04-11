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
            $table->float('precio_vendido');
            
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('pedido_id')->references('id')->on('pedidos');
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
