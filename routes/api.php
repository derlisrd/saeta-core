<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login',[AuthController::class,'login']);

Route::any('/',function(){return response()->json(['success'=>false],404);});

Route::fallback(function () {return response()->json(['success'=>false],404);});