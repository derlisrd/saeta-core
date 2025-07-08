<?php

use App\Http\Controllers\Ecommerce\HomeController;
use App\Http\Controllers\ViewsCentral\TiendaController;
use Illuminate\Support\Facades\Route;

Route::get('/',[HomeController::class, 'index']);


Route::get('/reparar',[TiendaController::class,'ensureStorageLink']);