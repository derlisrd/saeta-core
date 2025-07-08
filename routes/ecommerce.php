<?php

use App\Http\Controllers\Ecommerce\HomeController;
//use App\Http\Controllers\ViewsCentral\TiendaController;
use Illuminate\Support\Facades\Route;

Route::get('/',[HomeController::class, 'index'])->name('e_inicio');
Route::get('/details/{id}',[HomeController::class,'details'])->name('e_details');

//Route::get('/reparar',[TiendaController::class,'ensureStorageLink']);