<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\PasswordResetCode as PasswordResetCodeMail;
use App\Models\PasswordResetCode;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    // Enviar código de recuperación
    public function sendResetCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'No encontramos una cuenta con este correo electrónico.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $user = User::where('email', $request->email)->first();
            $resetCode = PasswordResetCode::generateCode($request->email);

            Mail::to($request->email)->send(
                new PasswordResetCodeMail($resetCode->code, $request->email)
            );

            return response()->json([
                'success' => true,
                'message' => 'Código de recuperación enviado a tu correo electrónico.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al enviar el correo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el correo. Inténtalo de nuevo.'
            ], 500);
        }
    }

    // Verificar código
    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'code' => 'required|string|size:4'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $resetCode = PasswordResetCode::verifyCode($request->email, $request->code);

        if (!$resetCode) {
            return response()->json([
                'success' => false,
                'message' => 'Código inválido o expirado.'
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Código verificado correctamente.',
            'token' => base64_encode($request->email . '|' . $request->code)
        ]);
    }

    // Restablecer contraseña
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            // Decodificar token
            $decoded = base64_decode($request->token);
            [$email, $code] = explode('|', $decoded);

            // Verificar código nuevamente
            $resetCode = PasswordResetCode::verifyCode($email, $code);

            if (!$resetCode) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token inválido o expirado.'
                ], 422);
            }

            // Actualizar contraseña
            $user = User::where('email', $email)->first();
            $user->password = Hash::make($request->password);
            $user->save();

            // Eliminar código usado
            $resetCode->delete();

            return response()->json([
                'success' => true,
                'message' => 'Contraseña restablecida exitosamente.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al restablecer la contraseña.'
            ], 500);
        }
    }
}
