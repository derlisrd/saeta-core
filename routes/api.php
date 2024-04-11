<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Product\ProductsController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
Route::post('/login',[AuthController::class,'login']);




Route::middleware(Authenticate::using('sanctum'))->group(function(){

    Route::get('/products',[ProductsController::class,'index']);

});







Route::any('/',function(){return response()->json(['success'=>false],404);});
Route::fallback(function () {return response()->json(['success'=>false],404);});