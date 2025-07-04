<?php

namespace App\Http\Controllers\ViewsCentral;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Database\Seeders\ExampleSeeder;
use Illuminate\Http\Request;
use App\Models\Admin\User as AdminUser;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    public function create(){
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
            'domain' => 'required|unique:tenants,domain'
        ]);



        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
        $user = Auth::user();
        $domain = $request->input('domain');
        $tenant = Tenant::create([
            'id' => $domain,
        ]);
        
        // 2. Asignar el dominio
        $tenant->domains()->create([
            'domain' => $domain . '.saeta.uk',
            'user_id' => $user->id
        ]);
        
        // 3. Inicializar el contexto tenant
        tenancy()->initialize($tenant);
        
        // 4. Ejecutar el seeder
        (new ExampleSeeder)->run();
        
        // 5. Finalizar el contexto tenant
        tenancy()->end();

    

        } catch (\Exception $e) {
            Log::error('Error al crear la tienda: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un error al crear tu tienda. Por favor, inténtalo de nuevo.');
        }
    }

}


/* $tenant = Tenant::create([
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
tenancy()->end(); */