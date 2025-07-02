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
        Schema::create('formas_pago_pedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pedido_id');
            $table->unsignedBigInteger('forma_pago_id');
            $table->string('abreviatura');
            $table->decimal('monto', 10, 2);
            $table->string('detalles')->nullable();
            $table->foreign('pedido_id')->references('id')->on('pedidos');
            $table->foreign('forma_pago_id')->references('id')->on('formas_pagos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formas_pago_pedidos');
    }
};
