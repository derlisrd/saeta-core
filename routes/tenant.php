<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return response()->json([
        'from'      => 'tenant',
        'tenant_id' => tenant('id'),
        'db'        => DB::connection()->getDatabaseName(),
    ]);
});
