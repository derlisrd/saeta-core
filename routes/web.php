<?php

use App\Http\Controllers\ViewsCentral\AuthController;
use App\Http\Controllers\ViewsCentral\HomeController;
use App\Http\Controllers\ViewsCentral\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest:admin')->group(function () {
Route::get('/login', [HomeController::class, 'signIn'])->name('login');
Route::get('/signup', [HomeController::class, 'signUp'])->name('signup');
Route::post('/signup', [AuthController::class, 'signUpSubmit'])->name('signup_submit');
});

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/create-store', [StoreController::class, 'create'])->name('store.create');
    Route::post('/create-store', [StoreController::class, 'store'])->name('store.store');

    Route::post('/logout',[AuthController::class,'logout'])->name('logout');

    Route::view('/dashboard','central.dashboard')->name('dashboard');
    
});
