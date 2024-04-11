<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        //web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        //commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix:'/api'
    )
    ->withMiddleware(function (Middleware $middleware) {
        /* $middleware->alias([
            'xapikey'=> \App\Http\Middleware\EnsureTokenIsValid::class
        ]); */
        $middleware->use([
            \App\Http\Middleware\XapiKeyTokenIsValid::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        
        $exceptions->renderable(function (AuthenticationException $e){
            return response()->json([
                'success'=>false,
                'message'=>'No autorizado'
            ],401);
        });

        $exceptions->renderable(function (NotFoundHttpException $e){
            return response()->json([
                'success'=>false,
                'message'=>'Not found'
            ],404);
        });

    })->create();
