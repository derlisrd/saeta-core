<?php

namespace App\Http\Controllers\ViewsCentral;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Database\Seeders\ExampleSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    public function create()
    {
        return view('central.storecreate', ['centralDomain' => env('CENTRAL_DOMAIN')]);
    }

    public function store(Request $request)
    {
        $centralDomain = env('CENTRAL_DOMAIN');

        // Verificar si CENTRAL_DOMAIN está configurado
        if (empty($centralDomain)) {
            Log::error('CENTRAL_DOMAIN no está configurado en el archivo .env');
            return redirect()->back()->with('error', 'Error de configuración: El dominio central no está definido.');
        }

        $validator = Validator::make($request->all(), [
            'domain' => 'required|unique:tenants,id'
        ]);

        Log::info('Validando dominio: ' . $request->domain);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Obtener el usuario autenticado
        Log::info('Intentando obtener usuario con guard admin. Autenticado: ' . Auth::guard('admin')->check());
        $user = Auth::guard('admin')->user();

        // Si por alguna razón el usuario no está autenticado, redirigir
        if (!$user) {
            Log::error('Usuario no autenticado en StoreController@store');
            return redirect()->route('signin')->with('error', 'Debes iniciar sesión para crear una tienda.');
        }

        // Obtener el ID del usuario autenticado
        $userId = $user->id;
        Log::info('Usuario autenticado ID: ' . $userId);
        Log::info('Usuario autenticado: ' . $user->name . ' (' . $user->email . ')');

        try {
            $domain = $request->input('domain');
            $fullDomain = $domain . '.' . $centralDomain;
            
            Log::info('Creando tienda para usuario ID: ' . $userId);
            
            // 1. Crear el tenant con información del usuario propietario
            $tenant = Tenant::create([
                'id' => $domain,
                // Puedes agregar campos adicionales si tu tabla tenants los tiene
                'user_id' => $userId,
                // 'name' => $request->input('store_name', $domain),
                // 'owner_email' => $user->email,
            ]);

            // 2. Asignar el dominio
            $tenant->domains()->create([
                'domain' => $fullDomain,
            ]);

            // 3. Inicializar el contexto tenant
            tenancy()->initialize($tenant);

            // 4. Ejecutar el seeder
            (new ExampleSeeder)->run();

            // 5. Finalizar el contexto tenant
            tenancy()->end();

            // Log de éxito
            Log::info('Tienda creada exitosamente: ' . $fullDomain . ' para usuario ID: ' . $userId);

            return redirect()->route('dashboard')->with('success', '¡Tu tienda "' . $fullDomain . '" ha sido creada exitosamente!');
            
        } catch (\Exception $e) {
            Log::error('Error al crear la tienda para usuario ID ' . $userId . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un error al crear tu tienda. Por favor, inténtalo de nuevo.');
        }
    }
}