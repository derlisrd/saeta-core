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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('caja_id')->unsigned()->nullable();
            $table->text('descripcion');
            $table->float('valor');
            $table->tinyInteger('forma_transaccion')->default(1);
            $table->tinyInteger('tipo')->default(0);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('caja_id')->references('id')->on('cajas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
