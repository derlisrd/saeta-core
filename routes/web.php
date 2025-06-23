<?php

use App\Http\Controllers\Pedido\PedidosController;
use Illuminate\Support\Facades\Route;

/* Route::any('/',function(){return response()->json(['success'=>false,'message'=>'Not found'],404);});
Route::fallback(function () {return response()->json(['success'=>false,'message'=>'Not found route.'],404);}); */

Route::view('/',['welcome']);

Route::get('/recibo/{id}', [PedidosController::class, 'sendEmailRecibo']);
