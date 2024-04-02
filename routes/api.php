<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login',[UserController::class,'login']);

Route::any('/',function(){ 
    return response()->json(['success'=>false],404);
});
Route::fallback(function () {
    return response()->json(['success'=>false],404);
});