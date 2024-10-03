<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Producto\ProductosController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::post('login',[AuthController::class,'login']);

Route::middleware(Authenticate::using('api'))->group(function(){
    Route::get('products',[ProductosController::class,'index']);
    Route::get('producto',[ProductosController::class,'store']);
    
    
    Route::get('/refresh-token',[AuthController::class,'refreshToken']);

});


Route::get('/products/public',[ProductosController::class,'index']);
