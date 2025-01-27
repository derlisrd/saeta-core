<?php

use App\Http\Controllers\Ecommerce\AuthController;
use App\Http\Controllers\Ecommerce\PedidosController;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authenticate;



Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);




Route::middleware(Authenticate::using('api'))->group(function(){


    Route::prefix('pedidos')->group(function(){
        Route::get('/',[PedidosController::class,'misPedidos']);
        Route::get('/items/{id}',[PedidosController::class,'itemsDeMiPedido']);

    });


    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
});

