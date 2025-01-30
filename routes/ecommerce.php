<?php

use App\Http\Controllers\Ecommerce\AuthController;
use App\Http\Controllers\Ecommerce\AuthGoogleController;
use App\Http\Controllers\Ecommerce\PedidosController;
use App\Http\Controllers\Ecommerce\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authenticate;



Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('/redirect-google', [AuthGoogleController::class, 'redirectToGoogle']);
Route::get('/callback-google', [AuthGoogleController::class, 'handleGoogleCallback']);



Route::middleware(Authenticate::using('api'))->group(function(){


    Route::prefix('pedidos')->group(function(){
        Route::get('/',[PedidosController::class,'misPedidos']);
        Route::get('/items/{id}',[PedidosController::class,'itemsDeMiPedido']);
        Route::post('/',[PedidosController::class,'crearPedido']);
    });

    Route::prefix('cliente')->group(function(){
        Route::post('/',[UserController::class,'store']);
    });

    Route::prefix('user')->group(function(){
        Route::put('/',[UserController::class,'update']);
        Route::get('me', [UserController::class, 'me']);
    });

    Route::post('logout', [AuthController::class, 'logout']);
});

