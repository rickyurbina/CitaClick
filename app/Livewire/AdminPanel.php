<?php

namespace App\Livewire;

use App\Models\EmpresasModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
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

    public function mount(EmpresasModel $empresa)
    {
        $this->empresa = $empresa;

        if (!$this->empresaActiva) {
            $this->seccionActiva = 'inactiva';
            return;
        }

        if ($this->isAuthenticated) {
            if ($this->esRecepcionista || $this->esColaborador) {
                $this->seccionActiva = 'citas';
            } else {
                $this->seccionActiva = 'dashboard';
            }
        }
    }

    public function getEmpresaActivaProperty()
    {
        return $this->empresa->estatus === 'activo';
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

    // Se elimina validación en tiempo real: solo limpiamos errores
    public function updated($propertyName)
    {
        if ($propertyName === 'email' || $propertyName === 'password') {
            $this->error = '';
            $this->info = '';
        }
    }

    public function login()
    {
        if (!$this->empresaActiva) {
            $this->error = 'Esta empresa no está activa. Contacta al administrador.';
            return;
        }

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

            if ($this->esRecepcionista || $this->esColaborador) {
                $this->seccionActiva = 'citas';
            } else {
                $this->seccionActiva = 'dashboard';
            }

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
        if (!$this->empresaActiva) {
            return;
        }

        if ($this->esColaborador || $this->esRecepcionista) {
            if ($seccion !== 'citas') {
                $this->dispatch('error', 'No tienes permiso para acceder a esta sección.');
                return;
            }
            $this->seccionActiva = 'citas';
            return;
        }

        if ($this->esAdmin) {
            $seccionesPermitidas = ['dashboard', 'citas', 'colaboradores', 'servicios'];
            if (in_array($seccion, $seccionesPermitidas)) {
                $this->seccionActiva = $seccion;
                $this->dispatch('cambiar-seccion', seccion: $seccion);
            }
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
            'empresaActiva' => $this->empresaActiva,
        ]);
    }
}