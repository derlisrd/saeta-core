<?php

use App\Http\Controllers\ViewsCentral\HomeController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/signin', [HomeController::class, 'signIn'])->name('signin');
Route::get('/signup', [HomeController::class, 'signUp'])->name('signup');


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