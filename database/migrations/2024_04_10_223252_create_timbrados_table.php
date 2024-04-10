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
        Schema::create('timbrados', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id');
            $table->date('inicio_vigencia');
            $table->date('fin_figencia')->nullable();
            $table->text('numero_timbrado');
            $table->text('descripcion')->nullable();
            $table->boolean('autoimpresor')->default(0);
            $table->text('descripcion_autoimpresor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timbrados');
    }
};
