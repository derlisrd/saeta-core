<?php

//declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return response()->json([
        'message' => 'Bienvenido a Saeta. Desde aquí se crean nuevas tiendas.'
    ]);
});


Route::get('/status', function () {
    return ['status' => 'central ok', 'db' => DB::connection()->getDatabaseName()];
});