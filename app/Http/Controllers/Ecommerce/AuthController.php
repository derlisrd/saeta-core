<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function login(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
            return response()->json([
                'success' => false,
                'results' => null,
                'message' => $validator->errors()->first()
            ], 400);
        $credentials = [
            'email' => $req->email,
            'password' => $req->password
        ];
        $token = auth('api')->attempt($credentials);
        if ($token) {
            $user = User::where('email', $credentials['email'])->firstOrFail();
            if (!$user->activo) {
                return response()->json([
                    'success' => false,
                    'results' => null,
                    'message' => "Usuario inactivo"
                ], 401);
            }
            $userData = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'username' => $user->username,
                'cliente_id' => $user->cliente_id
            ];
            if ($user) {
                return response()->json([
                    'success' => true,
                    'results' => [
                        'user' => $userData,
                        'tokenRaw' => $token,
                        'token' => 'Bearer ' . $token,
                        'refresh_token' => JWTAuth::claims(['type' => 'refresh'])->fromUser($user),
                    ]
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'results' => null,
            'message' => "Error de credenciales"
        ], 401);
    }


    public function register(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'nombres' => 'required|string',
            'apellidos' => 'required|string',
            'doc' => 'required|string|unique:clientes,doc',
            'direccion' => 'nullable',
            'telefono' => 'nullable',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
            return response()->json([
                'success' => false,
                'results' => null,
                'message' => $validator->errors()->first()
            ], 400);

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
            'tipo' => 0,
            'extranjero' => false,
            'juridica' => false,
            'web' => true
        ]);
        $user = User::create([
            'name' => $razonSocial,
            'email' => $req->email,
            'username' => $req->email,
            'password' => bcrypt($req->password),
            'cliente_id' => $cliente->id,
            'tipo' => 0,
            'activo' => 1,
            'cambiar_password' => 1
        ]);
        $token = JWTAuth::fromUser($user);

        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'username' => $user->username,
            'cliente_id' => $user->cliente_id
        ];
        return response()->json([
            'success' => true,
            'results' => [
                'user' => $userData,
                'tokenRaw' => $token,
                'token' => 'Bearer ' . $token,
            ],
            'message' => 'User registered successfully'
        ], 201);
    }

    public function logout(Request $req){
        auth('api')->logout();
        return response()->json([
            'success' => true,
            'results' => null,
            'message' => 'User logged out successfully'
        ]);
    }

    public function me(Request $req){
        $user = auth('api')->user();

        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'username' => $user->username,
            'cliente_id' => $user->cliente_id
        ];

        return response()->json([
            'success' => true,
            'results' => $userData,
            'message' => 'User data'
        ]);

    }
}
