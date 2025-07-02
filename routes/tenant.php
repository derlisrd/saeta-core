<?php

//declare(strict_types=1);

use App\Models\Tenant;
use Database\Seeders\ExampleSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/
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

Route::middleware([
    'api', // middleware para API
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/tenant-info', fn () => response()->json([
        'tenant_id' => tenant('id'),
        'domain' => request()->getHost(),
    ]));
});

Route::get('/debug-db', function () {
    return [
        'db' => DB::connection()->getDatabaseName(),
        'tenant_id' => tenant('id'),
    ];
});