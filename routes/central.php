<?php

use App\Models\Tenant;
use Database\Seeders\ExampleSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/aca-central', function () {
    return response()->json([
        'from' => 'central',
        'db'   => DB::connection()->getDatabaseName(),
    ]);
});


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