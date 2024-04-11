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
        Schema::create('factura_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('factura_id')->unsigned();
            $table->bigInteger('producto_id')->unsigned();
            
            $table->float('precio_vendido')->default(0);
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('factura_id')->references('id')->on('facturas');
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
