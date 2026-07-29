<?php

namespace App\Livewire;

use App\Models\EmpresasModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VerificarUsuario extends Component
{
    public EmpresasModel $empresa;

    // Login
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
            'empresa_id' => $this->empresa->id,
        ], $this->remember);

        if ($success) {
            session()->regenerate();
            $this->reset('password'); // limpiar aunque ya no se muestre
            return;
        }

        $this->error = 'Correo o contraseña incorrectos, o no perteneces a esta empresa.';
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
        return view('livewire.admin.admin-flow');
    }
}
