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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cliente_id')->unsigned();
            $table->bigInteger('empresa_id')->unsigned();
            $table->bigInteger('timbrado_id')->unsigned();
            $table->bigInteger('sucursal_id')->unsigned();
            $table->bigInteger('caja_id')->unsigned()->nullable();
            $table->text('codido_control')->nullable(); // electronico
            $table->text('descripcion')->nullable(); // electronico
            $table->bigInteger('numero');
            $table->bigInteger('descuento')->default(0);
            $table->bigInteger('total_con_descuento')->default(0);
            $table->float('total_de_impuestos');
            $table->float('total_sin_impuestos');
            $table->float('total');
            $table->tinyInteger('condicion_venta')->default(1);
            $table->tinyInteger('estado')->default(1);
            $table->boolean('aplicar_impuestos')->default(1);
            $table->timestamps();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->foreign('sucursal_id')->references('id')->on('sucursales');
            $table->foreign('cliente_id')->references('id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
