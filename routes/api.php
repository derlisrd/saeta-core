<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Producto\ProductosController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::post('login',[AuthController::class,'login']);

Route::middleware(Authenticate::using('api'))->group(function(){
   
    Route::prefix('productos')->group(function(){
        Route::get('/',[ProductosController::class,'index']);
        Route::get('/{id}',[ProductosController::class,'find']);
        Route::post('/',[ProductosController::class,'store']);
        Route::put('/{id}',[ProductosController::class,'update']);
        Route::delete('/{id}',[ProductosController::class,'destroy']);
    });

    
    Route::get('/refresh-token',[AuthController::class,'refreshToken']);
});


Route::get('/products/public',[ProductosController::class,'index']);
