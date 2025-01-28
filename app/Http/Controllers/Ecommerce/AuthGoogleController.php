<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthGoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'password' => bcrypt(Str::random(16)), // Generar una contraseña aleatoria
                ]
            );

            // Generar el token de autenticación
            $token = JWTAuth::fromUser($user);

            return response()->json([
                'success' => true,
                'results' => [
                    'token' => $token,
                    'user' => $user
                ],
                'message' => 'Autenticación con Google exitosa'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'results' => null,
                'message' => 'Error al autenticar con Google',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
