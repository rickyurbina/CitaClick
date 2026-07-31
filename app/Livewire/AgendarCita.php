<?php

namespace App\Livewire;

use App\Models\EmpresasModel;
use App\Models\ServiciosModel;
use App\Models\CitasModel;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class AgendarCita extends Component
{
    public EmpresasModel $empresa;
    public $clienteId;

    public $servicioId = null;
    public $colaboradorId = null;
    public $fecha = '';
    public $horaInicio = '';
    public $nombreAcompanante = '';

    public $confirmado = false;
    public $error = '';

    protected function rules()
    {
        return [
            'servicioId' => 'required|exists:servicios,id',
            'colaboradorId' => 'required|exists:users,id',
            'fecha' => 'required|date|after_or_equal:today',
            'horaInicio' => 'required',
        ];
    }

    public function mount(EmpresasModel $empresa, $clienteId = null)
    {
        $this->empresa = $empresa;
        $this->clienteId = $clienteId ?? session('cliente_id');
    }

    // Servicios activos de esta empresa
    public function getServiciosProperty()
    {
        return ServiciosModel::where('empresa_id', $this->empresa->id)
            ->where('activo', 1)
            ->get();
    }

    // Colaboradores que saben hacer el servicio seleccionado
    public function getColaboradoresProperty()
    {
        if (!$this->servicioId) {
            return collect();
        }

        return User::where('empresa_id', $this->empresa->id)
            ->where('rol', 'colaborador')
            ->where('activo', 1)
            ->whereHas('servicios', function ($query) {
                $query->where('servicios.id', $this->servicioId);
            })
            ->get();
    }

    // Horarios libres del colaborador elegido, en la fecha elegida
    public function getHorariosDisponiblesProperty()
    {
        if (!$this->colaboradorId || !$this->fecha || !$this->servicioId) {
            return [];
        }

        $colaborador = User::find($this->colaboradorId);
        $servicio = ServiciosModel::find($this->servicioId);

        if (!$colaborador || !$servicio || !$colaborador->horario_inicio || !$colaborador->horario_fin) {
            return [];
        }

        $duracion = $servicio->duracion_minutos;

        $inicio = Carbon::parse($this->fecha . ' ' . $colaborador->horario_inicio);
        $fin = Carbon::parse($this->fecha . ' ' . $colaborador->horario_fin);

        $citasOcupadas = CitasModel::where('colaborador_id', $this->colaboradorId)
            ->where('fecha', $this->fecha)
            ->whereIn('estado', ['agendada', 'confirmada', 'en_curso'])
            ->get(['hora_inicio', 'hora_fin']);

        $slots = [];

        while ($inicio->copy()->addMinutes($duracion)->lte($fin)) {
            $slotFin = $inicio->copy()->addMinutes($duracion);

            $ocupado = $citasOcupadas->contains(function ($cita) use ($inicio, $slotFin) {
                $citaInicio = Carbon::parse($this->fecha . ' ' . $cita->hora_inicio);
                $citaFin = Carbon::parse($this->fecha . ' ' . $cita->hora_fin);

                return $inicio->lt($citaFin) && $slotFin->gt($citaInicio);
            });

            if (!$ocupado) {
                $slots[] = $inicio->format('H:i');
            }

            $inicio->addMinutes($duracion);
        }

        return $slots;
    }

    public function seleccionarServicio($id)
    {
        $this->servicioId = $id;
        $this->colaboradorId = null;
        $this->fecha = '';
        $this->horaInicio = '';
    }

    public function seleccionarColaborador($id)
    {
        $this->colaboradorId = $id;
        $this->horaInicio = '';
    }

    public function seleccionarHorario($hora)
    {
        $this->horaInicio = $hora;
    }

    public function confirmarCita()
    {
        $this->validate();

        if (!$this->clienteId) {
            $this->error = 'No se pudo identificar al cliente. Intenta de nuevo.';
            return;
        }

        $servicio = ServiciosModel::find($this->servicioId);
        $horaFin = Carbon::parse($this->horaInicio)->addMinutes($servicio->duracion_minutos)->format('H:i');

        CitasModel::create([
            'empresa_id' => $this->empresa->id,
            'cliente_id' => $this->clienteId,
            'colaborador_id' => $this->colaboradorId,
            'servicio_id' => $this->servicioId,
            'fecha' => $this->fecha,
            'hora_inicio' => $this->horaInicio,
            'hora_fin' => $horaFin,
            'nombre_acompanante' => $this->nombreAcompanante ?: null,
            'estado' => 'agendada',
        ]);

        $this->confirmado = true;
    }

    public function render()
    {
        return view('livewire.agendar-cita', [
            'servicios' => $this->servicios,
            'colaboradores' => $this->colaboradores,
            'horariosDisponibles' => $this->horariosDisponibles,
        ]);
    }
}