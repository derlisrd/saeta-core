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
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('empresa_id')->after('id')->unsigned()->nullable();
            $table->foreign('empresa_id')->references('id')->on('empresa');
            $table->bigInteger('sucursal_id')->after('id')->unsigned()->nullable();
            $table->foreign('sucursal_id')->references('id')->on('sucursales');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('empresa_id');
            $table->dropColumn('sucursal_id');
        });
    }
};
