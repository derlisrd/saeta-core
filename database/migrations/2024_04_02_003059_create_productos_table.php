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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->bigInteger('creado_por')->unsigned();
            $table->bigInteger('modificado_por')->unsigned();
            $table->bigInteger('medida_id')->unsigned()->nullable();
            $table->string('codigo')->unique();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->float('costo',20,2)->default(0);
            $table->boolean('modo_comision')->default(0);
            $table->float('porcentaje_comision',2,2)->default(0);
            $table->float('valor_comision',20,2)->default(0);
            $table->float('precio_normal',20,2)->default(0);
            $table->float('precio_descuento',20,2)->default(0);
            $table->float('precio_minimo',20,2)->default(0);
            $table->float('porcentaje_impuesto',2,1);
            $table->boolean('disponible')->default(1);
            $table->boolean('tipo')->default('1');
            $table->boolean('preguntar_precio')->default(0);
            $table->boolean('notificar_minimo')->default(0);
            $table->float('cantidad_minima',20,1);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('medida_id')->references('id')->on('medidas');
            $table->foreign('modificado_por')->references('id')->on('users');
            $table->foreign('creado_por')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
