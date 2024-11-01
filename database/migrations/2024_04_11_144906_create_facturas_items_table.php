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
        Schema::create('facturas_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('factura_id')->unsigned();
            $table->bigInteger('producto_id')->unsigned();
            $table->bigInteger('impuesto_id')->unsigned();
            $table->float('cantidad');
            $table->float('precio');
            $table->float('descuento');
            $table->float('total_sin_descuento');
            $table->float('total_impuesto');
            $table->float('total');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('factura_id')->references('id')->on('facturas');
            $table->foreign('impuesto_id')->references('id')->on('impuestos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factura_items');
    }
};
