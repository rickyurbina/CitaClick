<?php

namespace App\Livewire;

use App\Models\ClientesModel;
use App\Models\EmpresasModel;
use Livewire\Component;

class VerificarTelefono extends Component
{
    public EmpresasModel $empresa;
    public $telefono = '';

    public function verificar()
    {
        $this->validate(['telefono' => 'required|digits:10']);

        $cliente = ClientesModel::where('telefono', $this->telefono)
            ->where('empresa_id', $this->empresa->id)
            ->first();

        if ($cliente) {
            session(['cliente_id' => $cliente->id]);
            $this->dispatch('telefono-verificado', clienteId: $cliente->id);
        } else {
            // Manda el teléfono al componente de registro antes de cambiar de pantalla
            $this->dispatch('telefono-no-encontrado', telefono: $this->telefono);
        }
    }

    public function render()
    {
        return view('livewire.verificar-telefono');
    }
}