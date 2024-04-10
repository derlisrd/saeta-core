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
            $user = $request->user;
            $password = $request->password;

            if (Auth::attempt(['username' => $user, 'password' => $password])) {
                //$user = User::where('username',$user)->first();
                $results = [
                    'token'=> 'a'
                ];
                return response()->json([
                    'success'=>true,
                    'results'=>$results
                ]);
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
