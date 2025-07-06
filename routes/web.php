<?php

use App\Http\Controllers\ViewsCentral\AuthController;
use App\Http\Controllers\ViewsCentral\HomeController;
use App\Http\Controllers\ViewsCentral\TiendaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest:admin')->group(function () {
    Route::get('/login', [HomeController::class, 'signIn'])->name('login');
    Route::post('/login', [HomeController::class, 'signIn'])->name('login_submit');
    Route::get('/register', [HomeController::class, 'registerView'])->name('register');
    Route::post('/register', [AuthController::class, 'registerSubmit'])->name('register_submit');
});

Route::middleware(['auth:admin'])->group(function () {
    Route::prefix('/tienda',function(){
        Route::get('/', [TiendaController::class, 'crearTiendaView'])->name('crear_tienda');
        Route::post('/', [TiendaController::class, 'guardarTienda'])->name('guardar_tienda');
    });

    Route::post('/logout',[AuthController::class,'logout'])->name('logout');

    Route::view('/dashboard','central.dashboard')->name('dashboard');
    
});
