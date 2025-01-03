<?php


use Illuminate\Support\Facades\Route;

Route::any('/',function(){return response()->json(['success'=>false,'message'=>'Not found'],404);});
Route::fallback(function () {return response()->json(['success'=>false,'message'=>'Not found route.'],404);});