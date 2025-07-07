<?php

namespace App\Http\Controllers\ViewsCentral;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Tenant;
use Database\Seeders\ExampleSeeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TiendaController extends Controller
{


    public function guardarTienda(Request $request)
    {
        $centralDomain = env('CENTRAL_DOMAIN');
        // Verificar si CENTRAL_DOMAIN está configurado
        if (empty($centralDomain)) {
            return redirect()->back()->with('error', 'Error de configuración: El dominio central no está definido.');
        }

        $validator = Validator::make($request->all(), [
            'domain' => 'required|unique:tenants,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Auth::guard('admin')->user();

        // Si por alguna razón el usuario no está autenticado, redirigir
        if (!$user) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para crear una tienda.');
        }

        try {
            $domain = $request->domain;
            $fullDomain = $domain . '.' . $centralDomain;

            $tenantData = [
                'id' => $domain,
                'user_id' => $user->id,
            ];

            // 1. Crear el tenant con información del usuario propietario
            $tenant = Tenant::create($tenantData);

            // 2. Asignar el dominio
            $tenant->domains()->create([
                'domain' => $fullDomain,
                'plan_id' => 1,
                'user_id' => $user->id
            ]);

            // 3. Inicializar el contexto tenant
            tenancy()->initialize($tenant);
            // 4. Crear el enlace simbólico del storage para el tenant
            $this->createTenantStorageLink($tenant->id);
            // 4. Ejecutar el seeder
            (new ExampleSeeder)->run($user);

            // 5. Finalizar el contexto tenant
            tenancy()->end();

            return redirect()->route('dashboard')->with('success', '¡Tu tienda "' . $fullDomain . '" ha sido creada exitosamente!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hubo un error al crear tu tienda. Por favor, inténtalo de nuevo.');
        }
    }


    private function createTenantStorageLink(string $tenantId): void
    {
        try {
            // Rutas del storage del tenant
            $tenantStoragePath = storage_path("app/public");
            $tenantPublicPath = public_path('storage');

            // Verificar que el directorio de storage existe
            if (!file_exists($tenantStoragePath)) {
                mkdir($tenantStoragePath, 0755, true);
            }

            // Crear el enlace simbólico si no existe
            if (!file_exists($tenantPublicPath)) {
                if (symlink($tenantStoragePath, $tenantPublicPath)) {
                    Log::info("Enlace simbólico creado para tenant: {$tenantId}");
                } else {
                    Log::warning("No se pudo crear el enlace simbólico para tenant: {$tenantId}");
                }
            } else {
                // Verificar que el enlace existente apunta al lugar correcto
                if (is_link($tenantPublicPath)) {
                    $currentTarget = readlink($tenantPublicPath);
                    if ($currentTarget !== $tenantStoragePath) {
                        // El enlace existe pero apunta a otro lugar, recrearlo
                        unlink($tenantPublicPath);
                        symlink($tenantStoragePath, $tenantPublicPath);
                        Log::info("Enlace simbólico actualizado para tenant: {$tenantId}");
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error("Error al crear enlace simbólico para tenant {$tenantId}: " . $e->getMessage());
            // No lanzar excepción aquí para no interrumpir la creación del tenant
        }
    }

    /**
     * Verifica y repara el enlace simbólico del storage para el tenant actual
     */
    public function ensureStorageLink(): void
    {
        $tenant = tenant();

        if (!$tenant) {
            return; // No hay tenant activo
        }

        $this->createTenantStorageLink($tenant->id);
    }
}
