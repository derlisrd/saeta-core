<?php

namespace App\Http\Controllers\ViewsCentral;

use App\Http\Controllers\Controller;
use App\Models\Admin\User as AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $req)
    {
        $key = 'register:' . $req->ip();
        $maxAttempts = 1;
        $decayMinutes = 2;
        // Verifica si la dirección IP ha excedido el número de intentos permitidos.
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            // Si hay demasiados intentos, calcula el tiempo restante hasta que se pueda reintentar.
            $retryAfter = RateLimiter::availableIn($key);
            // Redirige de vuelta con un mensaje de error y el tiempo de espera.
            return redirect()->back()->with('error', 'Has realizado demasiados intentos de registro. Por favor, inténtalo de nuevo en ' . $retryAfter . ' segundos.')->withInput();
        }
        // El segundo argumento es el tiempo de decaimiento en segundos.
        RateLimiter::hit($key, $decayMinutes * 60);

        // Valida los datos de la solicitud entrante
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', 
            'password' => 'required|string|min:6|max:20', 
        ]);

        // Comprueba si la validación falla
        if ($validator->fails()) {
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

            $userAdmin = Auth::guard('admin')->login($user); 
            // (Esto es útil si necesitas el token para el frontend o para otras APIs)
            $token = JWTAuth::fromUser($user); // Genera el token a partir del objeto User

            if (!$token) {
                return back()->with('error', 'No se pudo generar el token de autenticación. Por favor, inténtalo de nuevo.');
            }
            Log::info("Usuario registrado: " . $userAdmin);
            // Si quieres guardar el token en sesión para usarlo en frontend Blade:
            session(['jwt_token' => $token]);

            // Redirige a la página de creación de tienda
            return redirect()->route('crear_tienda')->with('success', '¡Tu cuenta ha sido creada exitosamente! Ahora, registra el nombre de tu tienda.');

        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Hubo un error al crear tu cuenta. Por favor, inténtalo de nuevo.');
        }
    }



    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Intentar autenticar con el guard 'admin'
        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard')); // Redirige a donde quería ir o al dashboard
        }

        return back()->withErrors(['email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        try {
            Auth::guard('admin')->logout(); 

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/');
        } catch (\Throwable $th) {
            return redirect('/');
        }
    }
}
