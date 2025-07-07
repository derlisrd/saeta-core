<?php

use App\Http\Controllers\Ecommerce\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/',[HomeController::class, 'index']);


