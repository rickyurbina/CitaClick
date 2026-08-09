<?php

namespace App\Livewire;

use App\Models\EmpresasModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AdminPanel extends Component
{
    public EmpresasModel $empresa;
    public string $seccionActiva = 'dashboard';

    // Login
    public string $email = '';
    public string $password = '';
    public bool $remember = false;
    public string $error = '';
    public string $info = '';
    public int $intentos = 0;

    #[Layout('components.layouts.auth')]
    public function mount(EmpresasModel $empresa)
    {
        $this->empresa = $empresa;
        
        if ($this->isAuthenticated) {
            $this->seccionActiva = 'dashboard';
        }
    }

    public function getIsAuthenticatedProperty()
    {
        return Auth::guard('web')->check() && 
               Auth::guard('web')->user()->empresa_id === $this->empresa->id;
    }

    public function getUsuarioActualProperty()
    {
        return Auth::guard('web')->user();
    }

    public function getEsAdminProperty()
    {
        return $this->usuarioActual && 
               in_array($this->usuarioActual->rol, ['empresa_admin', 'super_admin']);
    }

    public function getEsRecepcionistaProperty()
    {
        return $this->usuarioActual && $this->usuarioActual->rol === 'recepcionista';
    }

    public function getEsColaboradorProperty()
    {
        return $this->usuarioActual && $this->usuarioActual->rol === 'colaborador';
    }

    public function getPuedeGestionarCitasProperty()
    {
        return $this->esAdmin || $this->esRecepcionista || $this->esColaborador;
    }

    protected function rules()
    {
        return [
            'email' => 'required|email|max:150',
            'password' => 'required|min:6|max:100',
            'remember' => 'boolean',
        ];
    }

    protected function messages()
    {
        return [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingresa un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ];
    }

    public function updated($propertyName)
    {
        if (!$this->isAuthenticated) {
            $this->validateOnly($propertyName);
            if ($propertyName === 'email' || $propertyName === 'password') {
                $this->error = '';
                $this->info = '';
            }
        }
    }

    public function login()
    {
        $this->validate();

        $key = 'login_attempts_' . $this->email . '_' . $this->empresa->id;
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            $this->error = "Demasiados intentos. Espera {$seconds} segundos.";
            return;
        }

        $user = User::where('email', $this->email)
            ->where('empresa_id', $this->empresa->id)
            ->first();

        if (!$user) {
            RateLimiter::hit($key);
            $this->error = 'Usuario no encontrado en esta empresa.';
            $this->reset('password');
            return;
        }

        if (!$user->activo) {
            $this->error = 'Cuenta desactivada. Contacta al administrador.';
            $this->reset('password');
            return;
        }

        $success = Auth::guard('web')->attempt([
            'email' => $this->email,
            'password' => $this->password,
            'empresa_id' => $this->empresa->id,
        ], $this->remember);

        if ($success) {
            session()->regenerate();
            RateLimiter::clear($key);
            $this->reset(['password', 'error', 'info']);
            $this->seccionActiva = 'dashboard';
            $this->dispatch('login-success');
            return;
        }

        RateLimiter::hit($key);
        $this->intentos = RateLimiter::attempts($key);
        $this->error = "Credenciales incorrectas. Intento {$this->intentos} de 5.";
        $this->reset('password');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();
        
        $this->reset(['email', 'password', 'error', 'info']);
        $this->seccionActiva = 'login';
        $this->dispatch('logout-success');
    }

    public function cambiarSeccion($seccion)
    {
        $seccionesPermitidas = ['dashboard', 'citas'];
        
        if ($this->esAdmin) {
            $seccionesPermitidas = array_merge($seccionesPermitidas, [
                'colaboradores', 'servicios', 'comisiones'
            ]);
        }

        if (in_array($seccion, $seccionesPermitidas)) {
            $this->seccionActiva = $seccion;
            $this->dispatch('cambiar-seccion', seccion: $seccion);
        }
    }

    public function render()
    {
        return view('livewire.admin.admin-panel', [
            'isAuthenticated' => $this->isAuthenticated,
            'usuarioActual' => $this->usuarioActual,
            'esAdmin' => $this->esAdmin,
            'esRecepcionista' => $this->esRecepcionista,
            'esColaborador' => $this->esColaborador,
            'puedeGestionarCitas' => $this->puedeGestionarCitas,
        ]);
    }
}