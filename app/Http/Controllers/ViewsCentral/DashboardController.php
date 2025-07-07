<?php

namespace App\Http\Controllers\ViewsCentral;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stancl\Tenancy\Database\Models\Domain;

class DashboardController extends Controller
{
    public function index(){
        $user = Auth::guard('admin')->user();

        // Si no hay un usuario autenticado, redirigir a la página de login.
        if (!$user) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder al dashboard.');
        }

        // Obtener la instancia del tenant actual.
        // Esto funcionará si la tenencia está inicializada (es decir, estás en un dominio de tenant).
        $domain = Domain::where('user_id', $user->id)->first();

        $storeUrl = 'https://' . $domain->domain;
        $adminUrl = 'https://' . $domain->domain . '/admin';


        // Retornar la vista del dashboard, pasando la información necesaria.
        return view('central.dashboard', [
            'userName' => $user->name,
            'userEmail' => $user->email,
            'storeUrl' => $storeUrl,
            'adminUrl' => $adminUrl,
        ]);
    }
}
