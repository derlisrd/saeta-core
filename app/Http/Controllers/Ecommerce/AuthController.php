<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function login(Request $req)
    {
        // Validar las credenciales del usuario
        $validator = Validator::make($req->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'results' => null,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $credentials = $req->only('email', 'password');

        // Intentar autenticar al usuario con las credenciales proporcionadas
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'results' => null,
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        $user = User::where('email', $credentials['email'])->firstOrFail();

        // Verificar si el usuario está activo
        if (!$user->activo) {
            return response()->json([
                'success' => false,
                'results' => null,
                'message' => 'Usuario inactivo'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'results' => [
                'token' => $token,
                'user' => $user
            ],
            'message' => 'Inicio de sesión exitoso'
        ]);
    }


    public function register(Request $req)
    {
        // Validar los datos de entrada
        $validator = Validator::make($req->all(), [
            'nombres' => 'required|string',
            'apellidos' => 'required|string',
            'doc' => 'required|string|unique:clientes,doc',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'results' => null,
                'message' => $validator->errors()->first()
            ], 400);
        }

        // Crear un nuevo cliente
        $razonSocial = $req->nombres . ' ' . $req->apellidos;
        $cliente = Cliente::create([
            'doc' => $req->doc,
            'nombres' => $req->nombres,
            'apellidos' => $req->apellidos,
            'razon_social' => $razonSocial,
            'direccion' => $req->direccion,
            'telefono' => $req->telefono,
            'email' => $req->email,
            'nacimiento' => $req->nacimiento,
        ]);

        // Crear un nuevo usuario asociado al cliente
        $user = User::create([
            'name' => $razonSocial,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'cliente_id' => $cliente->id,
        ]);

        // Generar un token JWT para el nuevo usuario
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'success' => true,
            'results' => [
                'token' => $token,
                'user' => $user
            ],
            'message' => 'Registro exitoso'
        ]);
    }

    public function logout(Request $req){
        auth('api')->logout();
        return response()->json([
            'success' => true,
            'results' => null,
            'message' => 'User logged out successfully'
        ]);
    }

    
}
