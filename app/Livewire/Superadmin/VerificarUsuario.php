<?php

namespace App\Livewire\Superadmin;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VerificarUsuario extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;
    public $error = '';

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $success = Auth::guard('web')->attempt([
            'email' => $this->email,
            'password' => $this->password,
            'rol' => 'super_admin',
        ], $this->remember);

        if ($success) {
            session()->regenerate();
            $this->reset('password');
            return;
        }

        $this->error = 'Correo o contraseña incorrectos, o no tienes permisos de administrador.';
        $this->reset('password');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();
    }

    public function render()
    {
        return view('livewire.super-admin.super-admin-flow');
    }
}
