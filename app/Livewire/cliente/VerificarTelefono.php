<?php

namespace App\Livewire\Cliente;

use App\Models\EmpresasModel;
use App\Models\ClientesModel;
use Livewire\Component;

class VerificarTelefono extends Component
{
    public EmpresasModel $empresa;
    public string $telefono = '';
    public bool $cargando = false;

    protected $rules = [
        'telefono' => 'required|string|min:8|max:20',
    ];

    protected $messages = [
        'telefono.required' => 'El número de teléfono es obligatorio.',
        'telefono.min' => 'El teléfono debe tener al menos 8 dígitos.',
        'telefono.max' => 'El teléfono no puede tener más de 20 dígitos.',
    ];

    public function verificar()
    {
        $this->validate();

        // Limpiar el teléfono (solo dígitos)
        $telefonoLimpio = preg_replace('/[^0-9]/', '', $this->telefono);

        $this->cargando = true;

        try {
            $cliente = ClientesModel::where('empresa_id', $this->empresa->id)
                ->where(function ($query) use ($telefonoLimpio) {
                    $query->where('telefono', $telefonoLimpio)
                        ->orWhere('telefono', 'like', '%' . $telefonoLimpio . '%');
                })
                ->first();

            if ($cliente) {
                // Verificar si el cliente está bloqueado
                if ($cliente->estaBloqueado()) {
                    $this->dispatch('mostrar-mensaje', 
                        mensaje: 'Este cliente está bloqueado hasta el ' . $cliente->bloqueado_hasta->format('d/m/Y') . '. Contacta a la administración.',
                        tipo: 'error'
                    );
                    $this->cargando = false;
                    return;
                }

                $this->dispatch('telefono-verificado', 
                    clienteId: $cliente->id, 
                    telefono: $telefonoLimpio
                );
            } else {
                $this->dispatch('telefono-no-encontrado', 
                    telefono: $telefonoLimpio
                );
            }
        } catch (\Exception $e) {
            $this->dispatch('mostrar-mensaje', 
                mensaje: 'Ocurrió un error al verificar el teléfono. Intenta nuevamente.',
                tipo: 'error'
            );
        }

        $this->cargando = false;
    }

    public function render()
    {
        return view('livewire.cliente.verificar-telefono');
    }
}