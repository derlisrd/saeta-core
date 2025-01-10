<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\Errores;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
//use PHPOpenSourceSaver\JWTAuth\JWT;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 400);
            }
            $username = $request->username;
            $password = $request->password;
            $credentials = filter_var($username, FILTER_VALIDATE_EMAIL) ?
                ['email' => $username, 'password' => $password] :
                ['username' => $username, 'password' => $password];

            $token = auth('api')->attempt($credentials);

            if ($token) {
                $user = User::where('email', $username)->orWhere('username', $username)->firstOrFail();
                if(!$user->activo){
                    return response()->json([
                        'success' => false,
                        'message' => "Usuario inactivo"
                    ], 401);
                }
                if ($user) {
                    //$token = $user->createToken('auth_token')->plainTextToken;
                    $user->sucursal;
                    $empresa = Empresa::find($user->sucursal->empresa_id);

                    return response()->json([
                        'success' => true,
                        'results' => [
                            'user' => $user->load(['sucursal', 'permisos']),
                            'tokenRaw' => $token,
                            'token' => 'Bearer ' . $token,
                            'refresh_token' => JWTAuth::claims(['type' => 'refresh'])->fromUser($user),
                            'empresa' => $empresa
                        ]
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => "Error de credenciales"
            ], 401);
        } catch (\Throwable $th) {
            Log::error($th);
            Errores::create(['descripcion' => 'Error en el login']);
            return response()->json([
                'success' => false,
                'message' => "Error de servidor"
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        //$request->user()->currentAccessToken()->delete();   
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['success' => true], 500);
        }
    }

    public function check(Request $request)
    {
        try {
            $user = auth('api')->user();
            if ($user) {
                return response()->json(['success' => true, 'user' => $user]);
            } else {
                return response()->json(['success' => false, 'message' => 'Token inválido']);
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'message' => 'Error de servidor'], 500);
        }
    }

    public function refreshToken()
    {
        try {
            $user = auth('api')->user();
            $token = JWTAuth::refresh(JWTAuth::getToken());
            return response()->json(['success' => true, 'results' => [
                'tokenRaw' => $token,
                'token' => 'Bearer ' . $token,
                'refresh_token' => JWTAuth::claims(['type' => 'refresh'])->fromUser($user),
            ]]);
            
        } catch (\Throwable $th) {
            throw $th;
            return response()->json(['success' => false, 'results' => null, 'message' => 'Error de refresh'], 500);
        }
    }

    
}
