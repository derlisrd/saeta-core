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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('doc')->unique();
            $table->string('nombres');
            $table->string('apellidos')->nullable();
            $table->string('razon_social');
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->date('nacimiento')->nullable();
            $table->boolean('tipo')->nullable()->default(0);
            $table->boolean('extranjero')->nullable()->default(0);
            $table->boolean('juridica')->nullable()->default(0);
            $table->boolean('web')->nullable()->default(0);
            $table->boolean('deletable')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
