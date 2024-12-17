<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Factura\FacturasController;
use App\Http\Controllers\Producto\ProductosController;
use App\Http\Controllers\User\UserController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::post('login',[AuthController::class,'login']);

Route::middleware([])->get('/', function () {
    return response()->json([
        'success' => true
    ]);
});
Route::middleware(Authenticate::using('api'))->group(function(){
   
    Route::prefix('productos')->group(function(){
        Route::get('/',[ProductosController::class,'index']);
        Route::get('/{id}',[ProductosController::class,'find']);
        Route::post('/',[ProductosController::class,'store']);
        Route::put('/{id}',[ProductosController::class,'update']);
        Route::delete('/{id}',[ProductosController::class,'destroy']);
    });
    
    Route::prefix('facturas')->group(function(){
        Route::get('/',[FacturasController::class,'index']);
        Route::get('/{id}',[FacturasController::class,'find']);
        Route::post('/',[FacturasController::class,'store']);
        Route::put('/{id}',[FacturasController::class,'update']);
        Route::delete('/{id}',[FacturasController::class,'destroy']);
    });

    Route::get('/refresh-token',[AuthController::class,'refreshToken']);

    Route::get('/me',[UserController::class,'me']);
});

Route::get('/recuperar',[UserController::class,'recuperar']);