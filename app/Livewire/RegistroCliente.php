<?php

namespace App\Livewire;

use App\Models\ClientesModel;
use App\Models\EmpresasModel;
use Livewire\Attributes\On;
use Livewire\Component;

class RegistroCliente extends Component
{
    public EmpresasModel $empresa;
    public $telefono = '';
    public $nombre = '';
    public $email = '';
    public $fecha_nacimiento = '';

    #[On('telefono-no-encontrado')]
    public function precargarTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function registrar()
    {
        $this->validate([
            'telefono' => 'required|digits:10',
            'nombre' => 'required|min:3',
            'email' => 'nullable|email',
            'fecha_nacimiento' => 'required|date|before:today',
        ]);

        $cliente = ClientesModel::create([
            'empresa_id' => $this->empresa->id,
            'telefono' => $this->telefono,
            'nombre' => $this->nombre,
            'email' => $this->email,
            'fecha_nacimiento' => $this->fecha_nacimiento,
        ]);

        session(['cliente_id' => $cliente->id]);
        $this->dispatch('cliente-registrado', clienteId: $cliente->id);
    }

    public function volver()
    {
        $this->dispatch('volver-a-verificar');
    }

    public function render()
    {
        return view('livewire.registro-cliente');
    }
}