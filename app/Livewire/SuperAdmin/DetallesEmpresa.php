<?php

namespace App\Livewire\SuperAdmin;

use App\Models\EmpresasModel;
use Livewire\Component;

class DetallesEmpresa extends Component
{
    public $mostrarModal = false;
    public $empresaId = null;
    public $empresa = null;

    protected $listeners = [
        'ver-detalles-empresa' => 'abrirDetalles',
        'cerrar-detalles-empresa' => 'cerrarModal',
    ];

    public function abrirDetalles($id)
    {
        $this->empresaId = $id;
        $this->empresa = EmpresasModel::with(['users', 'clientes', 'citas'])->findOrFail($id);
        $this->mostrarModal = true;
        $this->dispatch('modal-abierto');
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
        $this->empresaId = null;
        $this->empresa = null;
        $this->dispatch('modal-cerrado');
    }

    public function render()
    {
        return view('livewire.superadmin.detalles-empresa');
    }
}