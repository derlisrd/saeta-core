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
    public function crearTiendaView()
    {
        return view('central.creartienda', ['centralDomain' => env('CENTRAL_DOMAIN')]);
    }

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
                'plan_id' => 1
            ]);

            // 3. Inicializar el contexto tenant
            tenancy()->initialize($tenant);

            // 4. Ejecutar el seeder
            (new ExampleSeeder)->run();

            // 5. Finalizar el contexto tenant
            tenancy()->end();

            return redirect()->route('dashboard')->with('success', '¡Tu tienda "' . $fullDomain . '" ha sido creada exitosamente!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hubo un error al crear tu tienda. Por favor, inténtalo de nuevo.');
        }
    }
}
