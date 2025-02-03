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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constraint('users');
            $table->foreignId('moneda_id')->nullable()->constraint('monedas');
            $table->foreignId('product_id')->nullable()->constraint('products');
            $table->integer('cantidad')->default(1);
            $table->decimal('precio', 10, 2);
            $table->decimal('total', 10, 2);
            $table->boolean('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
