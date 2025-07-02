<?php

//declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/status', function () {
    return ['status' => 'central ok', 'db' => DB::connection()->getDatabaseName()];
});