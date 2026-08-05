<?php

namespace App\Livewire;

use App\Models\EmpresasModel;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class BuscarCliente extends Component
{
    public EmpresasModel $empresa;
    public $step = 'verificar';
    public $clienteId = null;

    #[On('telefono-verificado')]
    public function irAAgendar($clienteId)
    {
        $this->clienteId = $clienteId;
        $this->step = 'agendar';
    }

    #[On('telefono-no-encontrado')]
    public function irARegistro()
    {
        $this->step = 'registro';
    }

    #[On('cliente-registrado')]
    public function clienteRegistrado($clienteId)
    {
        $this->clienteId = $clienteId;
        $this->step = 'agendar';
    }

    #[On('volver-a-verificar')]
    public function irAVerificar()
    {
        $this->step = 'verificar';
    }

    public function render()
    {
        return view('livewire.buscar-cliente');
    }
}