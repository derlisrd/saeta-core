<?php

//declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return response()->json([
        'message' => 'Bienvenido a Saeta. Desde aquí se crean nuevas tiendas.'
    ]);
});


Route::get('/status', function () {
    return ['status' => 'central ok', 'db' => DB::connection()->getDatabaseName()];
});

/* Route::get('/', function () {
    // 1. Crear el tenant
    $tenant = Tenant::create([
        'id' => 'stock',
    ]);
    
    // 2. Asignar el dominio
    $tenant->domains()->create([
        'domain' => 'stock.saeta.uk'
    ]);

    // 3. Inicializar el contexto tenant
    tenancy()->initialize($tenant);

    // 4. Ejecutar el seeder
    (new ExampleSeeder)->run();

    // 5. Finalizar el contexto tenant
    tenancy()->end();

    return response()->json(['message' => 'Tenant creado y seed ejecutado']);
});  */