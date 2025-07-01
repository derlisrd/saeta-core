<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;

class ConfigurarController extends Controller
{
    public function verificar()
    {
        $empresa = Empresa::first();

        return response()->json([
            'success' => true,
            'results' => $empresa
        ]);
    }

    public function configurarPrimeraVez(Request $req)
    {
        $ip = $req->ip();
            $rateKey = "config:$ip";

            if (RateLimiter::tooManyAttempts($rateKey, 5)) {
                return response()->json(['success' => false, 'message' => 'Demasiadas peticiones. Espere 1 minuto.'], 429);
            }
            RateLimiter::hit($rateKey, 60);

        $validator = Validator::make($req->all(), [
            'nombre' => 'required|string|max:255',
            'ruc' => 'required|string|max:20|unique:empresa,ruc',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:500',
            'propietario' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'nombre.required' => 'El nombre de la empresa es obligatorio',
            'ruc.required' => 'El RUC es obligatorio',
            'ruc.unique' => 'Este RUC ya está registrado',
            'email.unique' => 'Este email ya está registrado',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        if ($validator->fails())
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);

        $empresaConfigurada = Empresa::where('configurado', true)->exists();
        if ($empresaConfigurada) {
            return response()->json([
                'success' => false,
                'message' => 'La empresa ya está configurada'
            ], 400);
        }
        try {

            DB::transaction(function () use ($req) {
                // Actualizar empresa
                Empresa::where('id', 1)->update([
                    'nombre' => $req->nombre,
                    'ruc' => $req->ruc,
                    'telefono' => $req->telefono,
                    'direccion' => $req->direccion,
                    'propietario' => $req->propietario,
                    'configurado' => true,
                    'licencia' => Carbon::now()->addDays(30)->format('Y-m-d')   
                ]);

                // Crear usuario administrador
                User::create([
                    'name' => $req->name,
                    'empresa_id' => 1,
                    'sucursal_id' => 1,
                    'username' => $req->email,
                    'email' => $req->email,
                    'password' => Hash::make($req->password),
                    'tipo' => 10,
                ]);
            });
            $empresa = Empresa::first();
            return response()->json([
                'success' => true,
                'message' => 'Empresa configurada correctamente',
                'results' => $empresa
            ], 201); // Código HTTP para creación exitosa

        } catch (\Exception $e) {
            // Log del error para debugging
            Log::error('Error configurando empresa: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }
}
