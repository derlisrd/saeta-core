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
        Schema::create('creditos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->nullable()->constraint('pedidos');
            $table->foreignId('cliente_id')->nullable()->constraint('clientes');
            $table->float('monto');
            $table->float('monto_abonado')->default(0);
            $table->integer('cuotas')->default(1);
            $table->float('interes')->default(0);
            $table->float('descuento')->default(0);
            $table->boolean('pagado')->default(false);
            $table->date('fecha_vencimiento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creditos');
    }
};
