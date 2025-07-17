<?php

namespace App\Livewire;

use App\Models\Admin\User as AdminUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Database\Seeders\ExampleSeeder;
use App\Models\Tenant;
use Livewire\Component;

class Register extends Component
{

    public $currentStep = 1;
    public $totalSteps = 3;

    public $name;
    public $email;
    public $password;

    public $domain;
    public $store;

    public $plan_seleccionado = 1;

    public $logo;


    public function mount()
    {
        $this->currentStep = 1;
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function goToStep($step)
    {
        if ($step <= $this->currentStep || $step == 1) {
            $this->currentStep = $step;
        }
    }

    public function nextStep()
    {

        $this->validateCurrentStep();

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function seleccionarPlan(int $plan)
    {
        $this->plan_seleccionado = $plan;
    }


    private function validateCurrentStep()
    {
        if ($this->currentStep == 1) {
            $this->validate(
                [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|string|min:6',
                ],
                [
                    'name.required' => 'El nombre es obligatorio',
                    'email.required' => 'El correo electrónico es obligatorio',
                    'email.email' => 'El correo electrónico debe ser válido',
                    'email.unique' => 'El correo electrónico ya está en uso',
                    'password.required' => 'La contraseña es obligatoria',
                    'password.min' => 'La contraseña debe tener al menos 6 caracteres',
                ]
            );
        } elseif ($this->currentStep == 2) {
            $this->validate(
                [
                    'store' => 'required|string|max:250',
                    'domain' => ['required', 'unique:tenants,id', 'regex:/^[a-zA-Z0-9]+$/'],
                ],
                [
                    'domain.required' => 'El dominio es obligatorio',
                    'domain.unique' => 'El dominio ya está en uso',
                    'domain.regex' => 'El dominio debe contener solo letras y números',
                    'store.required' => 'El nombre del sitio web es obligatorio',
                    'store.max' => 'El nombre del sitio web debe tener como máximo 250 caracteres',
                ]
            );
        } elseif ($this->currentStep == 3) {
            $this->validate([
                'plan_seleccionado' => 'required|in:1,2',
            ]);
        }
    }


    public function submitForm()
    {
        // Validar todos los pasos
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'store' => 'required|string|max:255',
            'domain' => ['required', 'unique:tenants,id', 'regex:/^[a-zA-Z0-9]+$/'],
            'plan_seleccionado' => 'required|in:1,2',
            'logo' => 'nullable|image|max:2048',
        ]);

        $key = 'register:' . request()->ip();
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
        $user = AdminUser::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
        RateLimiter::clear($key);


        $userAdmin = Auth::guard('admin')->login($user);
        // (Esto es útil si necesitas el token para el frontend o para otras APIs)
        $token = JWTAuth::fromUser($user); // Genera el token a partir del objeto User

        if (!$token) {
            return back()->with('error', 'No se pudo generar el token de autenticación. Por favor, inténtalo de nuevo.');
        }
        // Si quieres guardar el token en sesión para usarlo en frontend Blade:
        session(['jwt_token' => $token]);

        session()->flash('success', '¡Registro completado exitosamente!');
        $centralDomain = env('CENTRAL_DOMAIN');
        $domain = strtolower($this->domain);
        $fullDomain = $domain . '.' . $centralDomain;

        $tenantData = [
            'id' => $domain,
            'user_id' => $user->id,
        ];

        // 1. Crear el tenant con información del usuario propietario
        $tenant = Tenant::create($tenantData);

        // 2. Asignar el dominio
        $tenant->domains()->create([
            'domain' => $fullDomain,
            'plan_id' => 1,
            'user_id' => $user->id
        ]);

        // 3. Inicializar el contexto tenant
        tenancy()->initialize($tenant);
        // 4. Crear el enlace simbólico del storage para el tenant
        $this->createTenantStorageLink($tenant->id);
        // 4. Ejecutar el seeder
        (new ExampleSeeder)->run($user, $this->store);

        // 5. Finalizar el contexto tenant
        tenancy()->end();


        return redirect()->route('dashboard');
    }


    public function render()
    {
        return view('livewire.register');
    }
}
