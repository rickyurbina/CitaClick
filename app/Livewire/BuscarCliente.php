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
    public string $step = 'verificar';
    public ?int $clienteId = null;
    public ?string $telefono = null;
    public ?string $mensaje = null;
    public string $tipoMensaje = 'info';

    public int $vistaKey = 1;

    private function irAPaso(string $step): void
    {
        $this->step = $step;
        $this->vistaKey++;
    }

    public function getEmpresaActivaProperty()
    {
        return $this->empresa->estatus === 'activo';
    }

    #[On('telefono-verificado')]
    public function irAAgendar($clienteId, $telefono = null)
    {
        $this->clienteId = (int) $clienteId;
        $this->telefono = $telefono;
        $this->irAPaso('agendar');
        $this->limpiarMensaje();
    }

    #[On('telefono-no-encontrado')]
    public function irARegistro($telefono = null)
    {
        $this->telefono = $telefono;
        $this->clienteId = null;
        $this->irAPaso('registro');
        $this->limpiarMensaje();
    }

    #[On('cliente-registrado')]
    public function clienteRegistrado($clienteId, $telefono = null)
    {
        $this->clienteId = (int) $clienteId;
        $this->telefono = $telefono;
        $this->irAPaso('agendar');
        $this->mostrarMensaje('Cliente registrado correctamente.', 'success');
    }

    #[On('volver-a-verificar')]
    public function irAVerificar()
    {
        $this->clienteId = null;
        $this->telefono = null;
        $this->irAPaso('verificar');
        $this->limpiarMensaje();
    }

    #[On('cita-cancelada')]
    public function onCitaCancelada($mensaje = null)
    {
        $this->mostrarMensaje($mensaje ?? 'Cita cancelada correctamente.', 'warning');
    }

    #[On('cita-agendada')]
    public function onCitaAgendada($mensaje = null)
    {
        $this->mostrarMensaje($mensaje ?? 'Cita agendada correctamente.', 'success');
    }

    #[On('mostrar-mensaje')]
    public function mostrarMensaje($mensaje = null, $tipo = 'info')
    {
        if (is_array($mensaje)) {
            $this->mensaje = $mensaje['mensaje'] ?? '';
            $this->tipoMensaje = $mensaje['tipo'] ?? 'info';
            return;
        }

        $this->mensaje = $mensaje;
        $this->tipoMensaje = $tipo ?? 'info';
    }

    #[On('limpiar-mensaje')]
    public function limpiarMensaje()
    {
        $this->mensaje = null;
        $this->tipoMensaje = 'info';
    }

    public function getPasoComponentProperty(): ?string
    {
        return match ($this->step) {
            'verificar' => 'cliente.verificar-telefono',
            'registro' => 'cliente.registro-cliente',
            'agendar' => $this->clienteId ? 'cliente.agendar-cita' : null,
            default => null,
        };
    }

    public function getPasoParamsProperty(): array
    {
        return match ($this->step) {
            'verificar' => [
                'empresa' => $this->empresa,
            ],
            'registro' => [
                'empresa' => $this->empresa,
                'telefono' => $this->telefono,
            ],
            'agendar' => [
                'empresa' => $this->empresa,
                'clienteId' => $this->clienteId,
            ],
            default => [],
        };
    }

    public function render()
    {
        $this->empresa->refresh();

        return view('livewire.cliente.buscar-cliente', [
            'pasoComponent' => $this->pasoComponent,
            'pasoParams' => $this->pasoParams,
            'empresaActiva' => $this->empresaActiva,
        ]);
    }
}