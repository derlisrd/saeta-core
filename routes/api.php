<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Producto\ProductosController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::post('/login',[AuthController::class,'login']);




Route::middleware(Authenticate::using('sanctum'))->group(function(){

    Route::get('/products',[ProductosController::class,'index']);

});



Route::get('/products/public',[ProductosController::class,'index']);



Route::any('/',function(){return response()->json(['success'=>false,'message'=>'Not found'],404);});
Route::fallback(function () {return response()->json(['success'=>false],404);});