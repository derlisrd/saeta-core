<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\Errores;
use App\Models\Permiso;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request){
        try {

            $username = $request->username;
            $password = $request->password;
            $credentials = filter_var($username, FILTER_VALIDATE_EMAIL) ?
            ['email' => $username, 'password' => $password] :
            ['username' => $username, 'password' => $password];
        
            $token = auth('api')->attempt($credentials);
            
            if ($token) {
                $user = User::where('email',$username)->orWhere('username',$username)->firstOrFail();

                if($user){
                    //$token = $user->createToken('auth_token')->plainTextToken;
                    //$user->sucursal;
                    $empresa = null;//Empresa::find($user->sucursal->empresa_id);
                    
                    return response()->json([
                        'success'=>true,
                        'results'=>[
                            'user'=>$user,
                            'token'=>$token,
                            'empresa'=>$empresa
                        ]
                    ]);
                } 
            }
            
            return response()->json([
                'success'=>false,
                'message'=>"Error de credenciales"
            ],401);


        } catch (\Throwable $th) {
            Log::error($th);
            Errores::create(['descripcion'=>'Error en el login']);
            return response()->json([
                'success'=>false,
                'message'=>"Error de servidor"
            ],500);
        }
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['success'=>true]);
    }
}
