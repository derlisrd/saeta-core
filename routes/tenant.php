<?php


// routes/tenant.php
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return response()->json(['message' => 'E‑commerce de ' . tenant('id')]);
});