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

    protected $listeners = [
        'telefono-verificado' => 'irAAgendar',
        'telefono-no-encontrado' => 'irARegistro',
        'cliente-registrado' => 'clienteRegistrado',
        'volver-a-verificar' => 'irAVerificar',
        'mostrar-mensaje' => 'mostrarMensaje',
        'limpiar-mensaje' => 'limpiarMensaje',
    ];

    #[On('telefono-verificado')]
    public function irAAgendar($clienteId, $telefono = null)
    {
        $this->clienteId = $clienteId;
        $this->telefono = $telefono;
        $this->step = 'agendar';
        $this->limpiarMensaje();
    }

    #[On('telefono-no-encontrado')]
    public function irARegistro($telefono = null)
    {
        $this->telefono = $telefono;
        $this->step = 'registro';
        $this->limpiarMensaje();
    }

    #[On('cliente-registrado')]
    public function clienteRegistrado($clienteId, $telefono = null)
    {
        $this->clienteId = $clienteId;
        $this->telefono = $telefono;
        $this->step = 'agendar';
        $this->mostrarMensaje('Cliente registrado correctamente.', 'success');
    }

    #[On('volver-a-verificar')]
    public function irAVerificar()
    {
        $this->step = 'verificar';
        $this->clienteId = null;
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

    public function mostrarMensaje($mensaje, $tipo = 'info')
    {
        $this->mensaje = $mensaje;
        $this->tipoMensaje = $tipo;
    }

    public function limpiarMensaje()
    {
        $this->mensaje = null;
        $this->tipoMensaje = 'info';
    }

    public function render()
    {
        return view('livewire.cliente.buscar-cliente', [
            'step' => $this->step,
            'clienteId' => $this->clienteId,
            'telefono' => $this->telefono,
            'mensaje' => $this->mensaje,
            'tipoMensaje' => $this->tipoMensaje,
        ]);
    }
}