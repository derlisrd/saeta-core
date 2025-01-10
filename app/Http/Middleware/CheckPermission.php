<?php

namespace App\Http\Middleware;

use App\Models\Permiso;
use App\Models\PermisosOtorgado;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, int $requiredPermissionId): Response
    {
        $user = auth()->user();

        // Verificar si el usuario está autenticado
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'No autenticado.',
            ], 401);
        }

        // Permitir acceso total a super administradores
        if ($user->esSuperAdmin) {
            return $next($request);
        }
        // Verificar si el permiso con el ID especificado existe
        $permiso = Permiso::find($requiredPermissionId);

        if (!$permiso) {
            return response()->json([
                'success' => false,
                'message' => 'Permiso no encontrado.',
            ], 404);
        }

        // Verificar si el usuario tiene el permiso otorgado
        $permisoOtorgado = PermisosOtorgado::where('user_id', $user->id)
            ->where('permiso_id', $permiso->id)
            ->where('otorgado', true)
            ->exists();

        if (!$permisoOtorgado) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para acceder a este recurso.',
            ], 403);
        }

        return $next($request);
    }
}
