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
        Schema::create('cajas_arqueos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cerrado_por')->unsigned()->nullable();
            $table->bigInteger('caja_id')->unsigned();
            $table->float('inicial')->default(0);
            $table->float('efectivo',2)->default(0);
            $table->float('digital',2)->default(0);
            $table->float('sobrantes',2)->default(0);
            $table->float('faltantes',2)->default(0);
            $table->float('ventas',2)->default(0);
            $table->float('pagos',2)->default(0);
            $table->float('otros',2)->default(0);
            $table->float('total')->default(0);
            $table->text('descripcion')->nullable();
            $table->foreign('caja_id')->references('id')->on('cajas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cajas_arqueos');
    }
};
