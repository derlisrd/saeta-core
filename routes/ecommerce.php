<?php


use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return response()->json([
        'from' => 'ecommerce',
        'db'   => DB::connection()->getDatabaseName(),
    ]);
});


