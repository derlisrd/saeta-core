<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Errores;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        try {
            $email = $request->user;
            $password = $request->password;
            $intento = filter_var($email, FILTER_VALIDATE_EMAIL) ?
            ['email' => $email, 'password' => $password, 'active' => 1] :
            ['username' => $email, 'password' => $password, 'active' => 1];
    
            if (Auth::attempt($intento)) {
                $user = User::where('email',$email)->orWhere('username',$email)->firstOrFail();

                if($user){
                    $token = $user->createToken('auth_token')->plainTextToken;

                    return response()->json([
                        'success'=>true,
                        'results'=>[
                            'username'=>$user->username,
                            'email'=>$user->email,
                            'token'=>$token,
                            'id'=>$user->id
                        ]
                    ]);
                }
            }

            return response()->json([
                'success'=>false,
                'message'=>"Error de credenciales"
            ],401);


        } catch (\Throwable $th) {
            Errores::create([
                'descripcion'=>'Error en el login'
            ]);
        }
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['success'=>true]);
    }
}
