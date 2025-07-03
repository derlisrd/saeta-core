<?php

use App\Http\Middleware\VerificarPermiso;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Illuminate\Auth\AuthenticationException;
use App\Http\Middleware\XapiKeyTokenIsValid;
use Illuminate\Database\QueryException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/central.php',
        //api: __DIR__.'/../routes/api.php',
        //commands: __DIR__.'/../routes/console.php',
        //health: '/up',
        //apiPrefix:'/api',
        then: function () {
            // Rutas tenant
            Route::middleware([
                'web',
                \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class,
                \Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class,
            ])->group(base_path('routes/tenant.php'));

            // API para tenants
            Route::prefix('api')
                ->middleware([
                    'api',
                    \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class,
                    \Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class,
                ])
                ->group(base_path('routes/api.php'));
        }
    )->withMiddleware(function (Middleware $mw) {
        $mw->api(prepend: [
            \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class,
            \Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class,
        ]);
        // (dejamos tu middleware XapiKeyTokenIsValid como estaba)
        $mw->api(append: [
            XapiKeyTokenIsValid::class,
        ]);
        // alias que ya tenías …
        $mw->alias([
            'x-api-key' => XapiKeyTokenIsValid::class,
            'permiso'   => VerificarPermiso::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (AuthenticationException $e){
            return response()->json([
                'success'=>false,
                'message'=> 'Sesión inválida. Inicie sesión.' //$e->getMessage(),
            ],401);
        });

        $exceptions->render(function (AuthenticationException $e) {
            if (request()->is('api/*')) {
                return response()->json([
                    'success'=>false,
                    'message' =>'Sesión inválida. Inicie sesión.'// $e->getMessage(),
                ], 401);
            }
        });

        $exceptions->renderable(function (NotFoundHttpException $e){
            if (request()->is('api/*')) {
                return response()->json([
                    'success'=>false,
                    'message' =>'Route not found. ' //. $e->getMessage()
                ], 404);
            }
            return response()->json([
                'success'=>false,
                'message'=> 'No encontrado.', // . $e->getMessage(),
                'route' =>[
                    'url_current' => url()->current(),
                    'req_url' => request()->url(),
                    'req_path' => request()->path(),
                    'req_method' => request()->method(),
                ]
            ],404);
        });
        $exceptions->renderable(function (RouteNotFoundException $e){
            if (request()->is('api/*')) {
                return response()->json([
                    'success'=>false,
                    'message' =>'Route not found. ' // . $e->getMessage(),
                ], 404);
            }
            return response()->json([
                'success'=>false,
                'message'=>'Not found. ' // . $e->getMessage(),
            ],404);
        });
        $exceptions->renderable(function (MethodNotAllowedHttpException $e){
            return response()->json([
                'success'=>false,
                'message'=> $e->getMessage(),
            ],405);
        });
        $exceptions->renderable(function (ConnectionException $e){
            return response()->json([
                'success'=>false,
                'message'=> "Hubo un error con la conexion error de servidor."
            ],500);
        });
        $exceptions->renderable(function (QueryException $e){
            return response()->json([
                'success'=>false,
                'message'=> 'Error de consulta en base de datos.'
            ],500);
        });
        $exceptions->renderable(function (PDOException $e){
            return response()->json([
                'success'=>false,
                'message'=> 'Error al insertar los datos en la base de datos.'
            ],500);
        });
        $exceptions->renderable(function (BadMethodCallException $e){
            return response()->json([
                'success'=>false,
                'message'=> 'Error de servidor metodo invalido',
            ],500);
        });
        $exceptions->renderable(function (ErrorException $e){
            return response()->json([
                'success'=>false,
                'message'=> 'Error de servidor',
            ],500);
        });

    })->create();
