<?php

use App\Http\Controllers\ViewsCentral\AuthController;
use App\Http\Controllers\ViewsCentral\HomeController;
use App\Http\Controllers\ViewsCentral\StoreController;
//use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/signin', [HomeController::class, 'signIn'])->name('signin');
Route::get('/signup', [HomeController::class, 'signUp'])->name('signup');
Route::post('/signup', [AuthController::class, 'signUpSubmit'])->name('signup_submit');


Route::middleware(['admin'])->group(function () {
    Route::get('/create-store', [StoreController::class, 'create'])->name('store.create');
    Route::post('/create-store', [StoreController::class, 'store'])->name('store.store');

    Route::view('/dashboard','central.dashboard')->name('dashboard');
    // Agrega aquí cualquier otra ruta que solo deba ser accesible por un Admin\User
});




//Route::view('/', 'welcome');


/* Route::get('/crear/{domain}', function ($domain) {
    // 1. Crear el tenant

    $tenant = Tenant::create([
        'id' => $domain,
    ]);
    
    // 2. Asignar el dominio
    $tenant->domains()->create([
        'domain' => $domain . '.saeta.uk'
    ]);

    // 3. Inicializar el contexto tenant
    tenancy()->initialize($tenant);

    // 4. Ejecutar el seeder
    (new ExampleSeeder)->run();

    // 5. Finalizar el contexto tenant
    tenancy()->end();

    return response()->json(['message' => 'Tenant creado y seed ejecutado']);
});   */