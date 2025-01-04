<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Cliente\ClientesController;
use App\Http\Controllers\Factura\FacturasController;
use App\Http\Controllers\Factura\ImpuestosController;
use App\Http\Controllers\Pedido\PedidosController;
use App\Http\Controllers\Producto\CategoriasController;
use App\Http\Controllers\Producto\DepositosController;
use App\Http\Controllers\Producto\MedidasController;
use App\Http\Controllers\Producto\ProductosController;
use App\Http\Controllers\Producto\StockController;
use App\Http\Controllers\User\UserController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;



Route::post('login',[AuthController::class,'login']);


Route::middleware(Authenticate::using('api'))->group(function(){
   
    Route::prefix('/categorias')->group(function(){
        Route::get('/',[CategoriasController::class,'index']);
    });

    Route::prefix('productos')->group(function(){
        Route::get('/',[ProductosController::class,'index']);
        Route::get('/{id}',[ProductosController::class,'find']);
        Route::post('/',[ProductosController::class,'store']);
        Route::put('/{id}',[ProductosController::class,'update']);
        Route::delete('/{id}',[ProductosController::class,'destroy']);
    });

    Route::prefix('medidas')->group(function(){
        Route::get('/',[MedidasController::class,'index']);
    });

    Route::prefix('stock')->group(function(){
        Route::post('/',[StockController::class,'add']);
    });

    Route::prefix('depositos')->group(function(){
        Route::get('/',[DepositosController::class,'index']);
        Route::post('/',[DepositosController::class,'addDeposito']);
        Route::put('/{id}',[DepositosController::class,'update']);
        Route::get('/productos',[DepositosController::class,'productosPorDeposito']);
    });
    
    Route::prefix('facturas')->group(function(){
        Route::get('/',[FacturasController::class,'index']);
        Route::get('/{id}',[FacturasController::class,'find']);
        Route::post('/',[FacturasController::class,'store']);
        Route::put('/{id}',[FacturasController::class,'update']);
        Route::delete('/{id}',[FacturasController::class,'destroy']);
    });

    Route::prefix('clientes')->group(function(){
        Route::get('/',[ClientesController::class,'index']);
        Route::post('/',[ClientesController::class,'store']);
    });

    Route::get('/impuestos',[ImpuestosController::class,'index']);
    
    Route::prefix('pedidos')->group(function(){
        Route::get('/',[PedidosController::class,'index']);
        Route::get('/{id}',[PedidosController::class,'find']);
        Route::post('/',[PedidosController::class,'store']);
        Route::put('/cambiar-estado/{id}',[PedidosController::class,'cambiarEstado']);
    });

    Route::get('/refresh-token',[AuthController::class,'refreshToken']);

    Route::get('/me',[UserController::class,'me']);
});

Route::get('/recuperar',[UserController::class,'recuperar']);

Route::fallback(function () {return response()->json(['success'=>false,'message'=>'Not found route.'],404);});