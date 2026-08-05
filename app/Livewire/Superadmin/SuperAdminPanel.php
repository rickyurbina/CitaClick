<?php

namespace App\Livewire\SuperAdmin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class SuperAdminPanel extends Component
{
    public string $seccionActiva = 'dashboard';

    public string $email = '';
    public string $password = '';
    public bool $remember = false;
    public string $error = '';
    public string $info = '';
    public int $intentos = 0;

    public function mount()
    {
        if ($this->isAuthenticated) {
            $this->seccionActiva = 'dashboard';
        }
    }

    public function getIsAuthenticatedProperty()
    {
        return Auth::guard('web')->check() && 
               Auth::guard('web')->user()->rol === 'super_admin';
    }

    public function getUsuarioActualProperty()
    {
        return Auth::guard('web')->user();
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

        $key = 'superadmin_login_' . $this->email;
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            $this->error = "Demasiados intentos. Espera {$seconds} segundos.";
            return;
        }

        $user = User::where('email', $this->email)
            ->where('rol', 'super_admin')
            ->first();

        if (!$user) {
            RateLimiter::hit($key);
            $this->error = 'Usuario SuperAdmin no encontrado.';
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

    public function render()
    {
        return view('livewire.superadmin.super-admin-panel', [
            'isAuthenticated' => $this->isAuthenticated,
            'usuarioActual' => $this->usuarioActual,
        ]);
    }
}