<?php

use App\Http\Controllers\ViewsCentral\AuthController;
use App\Http\Controllers\ViewsCentral\DashboardController;
use App\Http\Controllers\ViewsCentral\TiendaController;
use Illuminate\Support\Facades\Route;

Route::view('/','central.home')->name('home');

Route::middleware('guest:admin')->group(function () {
    Route::view('/login','central.login')->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login_submit');
    Route::view('/register','central.register')->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register_submit');
});

Route::view('/contacto','central.contacto')->name('contacto');
Route::view('/planes','central.planes')->name('planes');
Route::view('/politicas','central.politicas')->name('politicas');
Route::view('/terminos','central.terminos')->name('terminos');

Route::middleware(['auth:admin'])->group(function () {

        Route::get('/tienda', [TiendaController::class, 'crearTiendaView'])->name('crear_tienda');
        Route::post('/tienda', [TiendaController::class, 'guardarTienda'])->name('guardar_tienda');
    

    Route::get('/logout',[AuthController::class,'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
    
});
