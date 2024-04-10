<?php


use Illuminate\Support\Facades\Route;

Route::get('/',function(){return response()->json(['success'=>false],404);});
Route::fallback(function () {return response()->json(['success'=>false],404);});