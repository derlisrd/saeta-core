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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('deposito_id')->unsigned();
            $table->bigInteger('medida_id')->unsigned();
            $table->float('cantidad',20.3);
            $table->timestamps();
            $table->foreign('medida_id')->references('id')->on('medidas');
            $table->foreign('deposito_id')->references('id')->on('depositos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
