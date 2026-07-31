<?php

namespace App\Livewire\Superadmin;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $seccion = 'inicio';

    public function cambiarSeccion($seccion)
    {
        $this->seccion = $seccion;
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();
    }

    public function render()
    {
        return view('livewire.superadmin.dashboard');
    }
}
