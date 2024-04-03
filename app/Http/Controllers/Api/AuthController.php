<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Errores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        try {
            $user = $request->user;
            $pass = $request->password;

            if (Auth::attempt([])) {
                
                return response()->json([
                    'success'=>true,
                    'results'=>[]
                ]);
            }

            return response()->json([
                'success'=>false
            ],401);


        } catch (\Throwable $th) {
            Errores::create([
                'descripcion'=>'Error en el login'
            ]);
        }
    }
}
