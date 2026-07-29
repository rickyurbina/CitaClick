<?php

namespace App\Livewire;

use App\Models\EmpresasModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public EmpresasModel $empresa;

    public $seccion = 'inicio'; // sección activa por defecto

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
        return view('livewire.admin.dashboard');
    }
}
