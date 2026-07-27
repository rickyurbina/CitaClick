<?php

namespace App\Livewire;

use App\Models\ClientesModel;
use App\Models\EmpresasModel;
use Livewire\Component;

class BuscarCliente extends Component
{
    public EmpresasModel $empresa;

    // Controla qué pantalla se muestra: 'verificar', 'registro', 'agendar'
    public $step = 'verificar';

    // Verificación de teléfono
    public $telefono = '';

    // Registro
    public $nombre = '';
    public $email = '';

    // Cliente ya identificado (una vez que existe o se crea)
    public $clienteId = null;

    protected function rules()
    {
        return match ($this->step) {
            'verificar' => ['telefono' => 'required|digits:10'],
            'registro' => [
                'telefono' => 'required|digits:10',
                'nombre' => 'required|min:3',
                'email' => 'nullable|email',
            ],
            default => [],
        };
    }

    public function verificar()
    {
        $this->validate(['telefono' => 'required|digits:10']);

        $cliente = ClientesModel::where('telefono', $this->telefono)
            ->where('empresa_id', $this->empresa->id)
            ->first();

        if ($cliente) {
            $this->clienteId = $cliente->id;
            session(['cliente_id' => $cliente->id]);
            $this->step = 'agendar';
        } else {
            $this->step = 'registro'; // ya trae $this->telefono precargado
        }
    }

    public function registrar()
    {
        $this->validate();

        $cliente = ClientesModel::create([
            'empresa_id' => $this->empresa->id,
            'telefono' => $this->telefono,
            'nombre' => $this->nombre,
            'email' => $this->email,
        ]);

        $this->clienteId = $cliente->id;
        session(['cliente_id' => $cliente->id]);
        $this->step = 'agendar';
    }

    public function volver()
    {
        $this->step = 'verificar';
        $this->reset(['nombre', 'email']);
    }

    public function render()
    {
        return view('livewire.cliente-flow');
    }
}
