<?php

namespace App\Http\Controllers\ViewsCentral;

use App\Http\Controllers\Controller;
use App\Models\Admin\User as AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function signUpSubmit(Request $req)
    {
        $key = 'signup-attempt:' . $req->ip();
        $maxAttempts = 1;
        $decayMinutes = 2;

        // Verifica si la dirección IP ha excedido el número de intentos permitidos.
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            // Si hay demasiados intentos, calcula el tiempo restante hasta que se pueda reintentar.
            $retryAfter = RateLimiter::availableIn($key);

            // Redirige de vuelta con un mensaje de error y el tiempo de espera.
            return redirect()->back()
                             ->with('error', 'Has realizado demasiados intentos de registro. Por favor, inténtalo de nuevo en ' . $retryAfter . ' segundos.')
                             ->withInput(); // Mantiene los datos de entrada anteriores en el formulario
        }

        Log::error('iniciado');
        // El segundo argumento es el tiempo de decaimiento en segundos.
        RateLimiter::hit($key, $decayMinutes * 60);

        // Valida los datos de la solicitud entrante
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255', // El nombre es requerido, debe ser una cadena y no exceder 255 caracteres.
            'email' => 'required|string|email|max:255|unique:users', // El email es requerido, debe ser una cadena, un formato de email válido, no exceder 255 caracteres y ser único en la tabla 'users'.
            'password' => 'required|string|min:6|max:20', // La contraseña es requerida, debe ser una cadena, tener un mínimo de 8 y un máximo de 20 caracteres, y debe coincidir con el campo de confirmación (si lo tienes en el formulario).
        ]);

        // Comprueba si la validación falla
        if ($validator->fails()) {
            Log::error('Error en el formulario de registro: ' . $validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();          // Mantiene los valores de entrada antiguos
        }

        try {
            // Si la validación pasa, crea un nuevo usuario
            $user = AdminUser::create([
                'name' => $req->name,
                'email' => $req->email,
                'password' => Hash::make($req->password),
            ]);
            RateLimiter::clear($key);
            Log::info('RateLimiter limpiado'); // Cambiado a info

            // Autentica al usuario recién creado utilizando el guard 'admin'
            // Si el guard 'admin' está configurado con el driver 'jwt', esto generará un token
            // y lo asociará con la sesión (si usas JWT con sesiones) o lo hará disponible.
            Auth::guard('admin')->login($user); // Esto autentica al usuario con el guard 'admin'

            // Para obtener el token JWT explícitamente después del login
            // (Esto es útil si necesitas el token para el frontend o para otras APIs)
            $token = JWTAuth::fromUser($user); // Genera el token a partir del objeto User

            if (!$token) {
                Log::error('Error al generar token JWT después del registro para usuario: ' . $user->email);
                return back()->with('error', 'No se pudo generar el token de autenticación. Por favor, inténtalo de nuevo.');
            }

            // Si quieres guardar el token en sesión para usarlo en frontend Blade:
            session(['jwt_token' => $token]);

            Log::info('Token JWT generado y sesión creada para usuario: ' . $user->email); // Cambiado a info

            // Redirige a la página de creación de tienda
            return redirect()->route('store.create')->with('success', '¡Tu cuenta ha sido creada exitosamente! Ahora, registra el nombre de tu tienda.');



        } catch (\Exception $e) {
            // Captura cualquier otra excepción durante la creación del usuario (por ejemplo, errores de base de datos)
            // Registra el error para fines de depuración
            Log::error('Error durante el registro de usuario: ' . $e->getMessage());

            // Redirige de vuelta con un mensaje de error genérico
            return redirect()->back()->with('error', 'Hubo un error al crear tu cuenta. Por favor, inténtalo de nuevo.');
        }
    }



    public function signInSubmit(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Intentar autenticar con el guard 'admin'
        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            //return redirect()->intended(route('dashboard')); // Redirige a donde quería ir o al dashboard
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout(); // <-- Usar el guard 'admin' para cerrar sesión

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
