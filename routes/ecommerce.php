<?php

use App\Http\Controllers\Ecommerce\HomeController;
use App\Http\Controllers\Ecommerce\ProductosController;
//use App\Http\Controllers\ViewsCentral\TiendaController;
use Illuminate\Support\Facades\Route;

Route::get('/',[HomeController::class, 'index'])->name('e_inicio');
Route::get('/details/{id}',[HomeController::class,'details'])->name('e_details');

Route::get('/categorias',[ProductosController::class,'categorias'])->name('e_categorias');
Route::get('/productos',[ProductosController::class,'productos'])->name('e_productos');
Route::get('/contacto',[HomeController::class, 'contacto'])->name('e_contacto');

//Route::get('/reparar',[TiendaController::class,'ensureStorageLink']);