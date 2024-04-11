<?php


use Illuminate\Support\Facades\Route;

Route::any('/',function(){return response()->json(['success'=>false],404);});
Route::fallback(function () {return response()->json(['success'=>false],404);});