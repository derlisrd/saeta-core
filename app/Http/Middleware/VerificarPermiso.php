<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarPermiso
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $modulo, $accion): Response
    {
        $user = $request->user();
        if ((!$user || !$user->tienePermiso($modulo, $accion)) && !$user->tipo === 10) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para ' . $accion . ' en el módulo ' . $modulo
            ], 403);
        }

        return $next($request);
    }
}
