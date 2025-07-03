<?php


// routes/tenant.php
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::get('/', function () {
    return response()->json(['message' => 'E‑commerce de ' . tenant('id')]);
});

Route::domain('{tenant}.saeta.uk')                 // <── sólo subdominios
     ->middleware([
         'web',
         InitializeTenancyByDomain::class,
         PreventAccessFromCentralDomains::class,
     ])
     ->group(function () {
         Route::get('/', function () {
             return response()->json([
                 'message' => 'home tienda de ' . tenant('id'),
             ]);
         });

         // …todas las demás rutas públicas del ecommerce
     });