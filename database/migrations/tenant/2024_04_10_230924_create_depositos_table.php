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
        Schema::create('depositos', function (Blueprint $table) {
            $table->id();
            // $table->bigInteger('sucursal_id')->unsigned();
            $table->foreignId('sucursal_id')->nullable()->constrained('sucursales');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(0);
            $table->timestamps();
            // $table->foreign('sucursal_id')->references('id')->on('sucursales');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depositos');
    }
};
