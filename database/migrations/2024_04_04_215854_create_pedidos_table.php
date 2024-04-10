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
            $table->bigInteger('cliente_id')->unsigned() ->nullable();
            $table->bigInteger('formas_pago_id')->unsigned() ->nullable();
            $table->tinyInteger('tipo')->default(1); // 1 venta normal 2 presupuesto
            $table->float('total',20,2);
            $table->timestamps();
            $table->foreign('formas_pago_id')->references('id')->on('formas_pagos');
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
