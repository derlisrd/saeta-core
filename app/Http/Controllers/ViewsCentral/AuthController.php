<?php

namespace App\Http\Controllers\ViewsCentral;

use App\Http\Controllers\Controller;
use App\Models\Admin\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signUpSubmit(Request $req)
    {
        // Define una clave única para el limitador de velocidad basada en la dirección IP del usuario.
        // Esto asegura que cada IP tenga su propio contador de intentos.
        $key = 'signup-attempt:' . $req->ip();

        // Define el número máximo de intentos permitidos y el tiempo de decaimiento (en minutos).
        // En este caso, permitimos 1 intento cada 2 minutos.
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

        // Incrementa el contador de intentos para esta clave.
        // El segundo argumento es el tiempo de decaimiento en segundos.
        RateLimiter::hit($key, $decayMinutes * 60);

        // Valida los datos de la solicitud entrante
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255', // El nombre es requerido, debe ser una cadena y no exceder 255 caracteres.
            'email' => 'required|string|email|max:255|unique:users', // El email es requerido, debe ser una cadena, un formato de email válido, no exceder 255 caracteres y ser único en la tabla 'users'.
            'password' => 'required|string|min:6|max:20|confirmed', // La contraseña es requerida, debe ser una cadena, tener un mínimo de 8 y un máximo de 20 caracteres, y debe coincidir con el campo de confirmación (si lo tienes en el formulario).
        ]);

        // Comprueba si la validación falla
        if ($validator->fails()) {
            // Si la validación falla, redirige de vuelta con los datos de entrada y los errores.
            // Importante: No limpiamos el RateLimiter aquí, ya que un intento fallido de validación
            // aún cuenta como un intento para el limitador de velocidad.
            return redirect()->back()
                             ->withErrors($validator) // Pasa los errores de validación a la vista
                             ->withInput();          // Mantiene los valores de entrada antiguos
        }

        try {
            // Si la validación pasa, crea un nuevo usuario
            $user = User::create([
                'name' => $req->name,
                'email' => $req->email,
                'password' => Hash::make($req->password), // Hashea la contraseña antes de guardarla en la base de datos por seguridad
            ]);

            // Limpia el Rate Limiter para esta IP después de un registro exitoso.
            // Esto asegura que, una vez que un usuario se registra correctamente, su IP
            // no siga siendo penalizada por el limitador para futuros intentos de registro.

            Auth::login($user);

            RateLimiter::clear($key);

            // Inicia sesión al usuario inmediatamente después de un registro exitoso (opcional)
            

            // Redirige a una página de panel de control o a una página de éxito.
            // Podrías cambiar 'home' por una ruta específica para nuevos usuarios.
            return redirect()->route('store.create')->with('success', '¡Tu cuenta ha sido creada exitosamente! Ahora, registra el nombre de tu tienda.');


        } catch (\Exception $e) {
            // Captura cualquier otra excepción durante la creación del usuario (por ejemplo, errores de base de datos)
            // Registra el error para fines de depuración
            Log::error('Error durante el registro de usuario: ' . $e->getMessage());

            // Redirige de vuelta con un mensaje de error genérico
            return redirect()->back()->with('error', 'Hubo un error al crear tu cuenta. Por favor, inténtalo de nuevo.');
        }
    }
}
