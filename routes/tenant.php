<?php


// routes/tenant.php
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return response()->json([
        'message' => 'tenant ok'
    ]);
});