<?php

namespace App\Livewire\Cliente;

use App\Models\EmpresasModel;
use App\Models\CitasModel;
use App\Models\ClientesModel;
use App\Models\ServiciosModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AgendarCita extends Component
{
    public EmpresasModel $empresa;
    public int $clienteId;
    public bool $mostrarFormulario = false;
    public bool $mostrarHistorial = true;

    public $cliente;
    public $citasAnteriores = [];
    public int $totalCitas = 0;

    // Formulario de cita
    public $servicioId = '';
    public $colaboradorId = '';
    public $fecha = '';
    public $horaInicio = '';
    public $nombreAcompanante = '';
    public $observaciones = '';

    public bool $cargando = false;

    // Datos para el calendario (se pasan a Alpine.js)
    public $diasDisponibles = [];
    public $horasDisponibles = [];
    public $duracionServicio = 0;

    protected $rules = [
        'servicioId' => 'required|exists:servicios,id',
        'colaboradorId' => 'required|exists:users,id',
        'fecha' => 'required|date|after_or_equal:today',
        'horaInicio' => 'required|date_format:H:i',
        'nombreAcompanante' => 'nullable|string|max:100',
        'observaciones' => 'nullable|string|max:255',
    ];

    protected $messages = [
        'servicioId.required' => 'Selecciona un servicio.',
        'servicioId.exists' => 'El servicio seleccionado no existe.',
        'colaboradorId.required' => 'Selecciona un colaborador.',
        'colaboradorId.exists' => 'El colaborador seleccionado no existe.',
        'fecha.required' => 'Selecciona una fecha.',
        'fecha.after_or_equal' => 'La fecha debe ser hoy o posterior.',
        'horaInicio.required' => 'Selecciona una hora.',
        'horaInicio.date_format' => 'Formato de hora inválido.',
        'nombreAcompanante.max' => 'El nombre del acompañante no puede exceder los 100 caracteres.',
        'observaciones.max' => 'Las observaciones no pueden exceder los 255 caracteres.',
    ];

    public function mount($clienteId)
    {
        $this->clienteId = $clienteId;
        
        $this->cliente = ClientesModel::with(['citas' => function($query) {
            $query->orderBy('fecha', 'desc')
                  ->orderBy('hora_inicio', 'desc')
                  ->limit(10);
        }])->findOrFail($clienteId);

        $this->totalCitas = CitasModel::where('cliente_id', $clienteId)->count();
        $this->citasAnteriores = $this->cliente->citas;

        if ($this->totalCitas === 0) {
            $this->mostrarFormulario = true;
            $this->mostrarHistorial = false;
        }
    }

    public function getServiciosProperty()
    {
        return ServiciosModel::where('empresa_id', $this->empresa->id)
            ->where('activo', 1)
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'precio', 'duracion_minutos']);
    }

    public function getColaboradoresProperty()
    {
        $query = User::where('empresa_id', $this->empresa->id)
            ->where('rol', 'colaborador')
            ->where('activo', 1);

        if ($this->servicioId) {
            $query->whereHas('servicios', function ($q) {
                $q->where('servicios.id', $this->servicioId);
            });
        }

        return $query->orderBy('nombre')->get(['id', 'nombre']);
    }

    public function getHorarioEmpresaProperty()
    {
        return [
            'inicio' => $this->empresa->config['horario_inicio'] ?? '09:00',
            'fin' => $this->empresa->config['horario_fin'] ?? '20:00',
        ];
    }

    // ==================== CALCULAR DÍAS DISPONIBLES ====================

    public function calcularDiasDisponibles()
    {
        if (!$this->colaboradorId || !$this->servicioId) {
            $this->diasDisponibles = [];
            return;
        }

        $servicio = ServiciosModel::find($this->servicioId);
        if (!$servicio) {
            $this->diasDisponibles = [];
            return;
        }

        $this->duracionServicio = $servicio->duracion_minutos;

        $colaborador = User::find($this->colaboradorId);
        $horarioInicio = $colaborador->horario_inicio ?? '09:00';
        $horarioFin = $colaborador->horario_fin ?? '20:00';

        $citasOcupadas = CitasModel::where('empresa_id', $this->empresa->id)
            ->where('colaborador_id', $this->colaboradorId)
            ->where('fecha', '>=', Carbon::today())
            ->where('fecha', '<=', Carbon::today()->addDays(60))
            ->where('estado', '!=', 'cancelada')
            ->where('estado', '!=', 'no_asistio')
            ->get()
            ->groupBy('fecha');

        $diasDisponibles = [];

        for ($i = 0; $i <= 60; $i++) {
            $fecha = Carbon::today()->addDays($i);
            $fechaStr = $fecha->format('Y-m-d');

            if ($fecha->isPast() && !$fecha->isToday()) {
                continue;
            }

            $citasDelDia = $citasOcupadas->get($fechaStr) ?? collect();
            $espacios = $this->calcularEspacios($horarioInicio, $horarioFin, $this->duracionServicio, $citasDelDia);

            if ($espacios > 0) {
                $diasDisponibles[] = [
                    'fecha' => $fechaStr,
                    'dia' => $fecha->day,
                    'mes' => $fecha->month,
                    'año' => $fecha->year,
                    'espacios' => $espacios,
                    'esHoy' => $fecha->isToday(),
                ];
            }
        }

        $this->diasDisponibles = $diasDisponibles;
    }

    private function calcularEspacios($inicio, $fin, $duracion, $citasDelDia)
    {
        $inicio = Carbon::parse($inicio);
        $fin = Carbon::parse($fin);

        $bloques = [];
        $horaActual = clone $inicio;

        while ($horaActual->addMinutes($duracion) <= $fin) {
            $inicioBloque = $horaActual->copy()->subMinutes($duracion);
            $finBloque = $horaActual->copy();
            
            $bloques[] = [
                'inicio' => $inicioBloque->format('H:i'),
                'fin' => $finBloque->format('H:i'),
            ];
        }

        $disponibles = 0;

        foreach ($bloques as $bloque) {
            $ocupado = false;
            $bloqueInicio = Carbon::parse($bloque['inicio']);
            $bloqueFin = Carbon::parse($bloque['fin']);

            foreach ($citasDelDia as $cita) {
                $citaInicio = Carbon::parse($cita->hora_inicio);
                $citaFin = Carbon::parse($cita->hora_fin);

                if ($bloqueInicio < $citaFin && $bloqueFin > $citaInicio) {
                    $ocupado = true;
                    break;
                }
            }

            if (!$ocupado) {
                $disponibles++;
            }
        }

        return $disponibles;
    }

    // ==================== CARGAR HORAS DISPONIBLES ====================

    public function cargarHorasDisponibles()
    {
        if (!$this->fecha || !$this->colaboradorId || !$this->servicioId) {
            $this->horasDisponibles = [];
            return;
        }

        $servicio = ServiciosModel::find($this->servicioId);
        if (!$servicio) {
            $this->horasDisponibles = [];
            return;
        }

        $colaborador = User::find($this->colaboradorId);
        $horarioInicio = $colaborador->horario_inicio ?? '09:00';
        $horarioFin = $colaborador->horario_fin ?? '20:00';

        $citasDelDia = CitasModel::where('empresa_id', $this->empresa->id)
            ->where('colaborador_id', $this->colaboradorId)
            ->where('fecha', $this->fecha)
            ->where('estado', '!=', 'cancelada')
            ->where('estado', '!=', 'no_asistio')
            ->get();

        $inicio = Carbon::parse($horarioInicio);
        $fin = Carbon::parse($horarioFin);
        $duracion = $servicio->duracion_minutos;

        $horas = [];
        $horaActual = clone $inicio;

        while ($horaActual->addMinutes($duracion) <= $fin) {
            $inicioBloque = $horaActual->copy()->subMinutes($duracion);
            $finBloque = $horaActual->copy();

            $ocupado = false;

            if ($this->fecha === Carbon::today()->format('Y-m-d')) {
                if ($inicioBloque <= Carbon::now()) {
                    $ocupado = true;
                }
            }

            if (!$ocupado) {
                foreach ($citasDelDia as $cita) {
                    $citaInicio = Carbon::parse($cita->hora_inicio);
                    $citaFin = Carbon::parse($cita->hora_fin);

                    if ($inicioBloque < $citaFin && $finBloque > $citaInicio) {
                        $ocupado = true;
                        break;
                    }
                }
            }

            $horas[] = [
                'inicio' => $inicioBloque->format('H:i'),
                'fin' => $finBloque->format('H:i'),
                'disponible' => !$ocupado,
            ];
        }

        $this->horasDisponibles = $horas;
    }

    // ==================== EVENTOS ====================

    public function updatedServicioId()
    {
        $this->colaboradorId = '';
        $this->fecha = '';
        $this->horaInicio = '';
        $this->horasDisponibles = [];
        $this->diasDisponibles = [];
        $this->dispatch('limpiar-mensaje');
    }

    public function updatedColaboradorId()
    {
        $this->fecha = '';
        $this->horaInicio = '';
        $this->horasDisponibles = [];
        $this->calcularDiasDisponibles();
        $this->dispatch('limpiar-mensaje');
    }

    public function seleccionarFecha($fecha)
    {
        $this->fecha = $fecha;
        $this->horaInicio = '';
        $this->cargarHorasDisponibles();
        $this->dispatch('limpiar-mensaje');
    }

    public function seleccionarHora($hora)
    {
        $this->horaInicio = $hora;
        $this->dispatch('limpiar-mensaje');
    }

    // ==================== VALIDACIÓN ====================

    public function validarClienteActivo(): bool
    {
        if ($this->cliente->estaBloqueado()) {
            $this->dispatch('mostrar-mensaje', 
                mensaje: 'No puedes agendar citas. Estás bloqueado hasta el ' . $this->cliente->bloqueado_hasta->format('d/m/Y'),
                tipo: 'error'
            );
            return false;
        }
        return true;
    }

    // ==================== NAVEGACIÓN ====================

    public function mostrarFormularioCita()
    {
        $this->mostrarFormulario = true;
        $this->mostrarHistorial = false;
        $this->dispatch('limpiar-mensaje');
    }

    public function verHistorial()
    {
        $this->mostrarHistorial = true;
        $this->mostrarFormulario = false;
        $this->dispatch('limpiar-mensaje');
    }

    public function volver()
    {
        $this->dispatch('volver-a-verificar');
    }

    // ==================== CANCELAR CITA ====================

    public function cancelarCita($citaId)
    {
        try {
            DB::beginTransaction();

            $cita = CitasModel::where('empresa_id', $this->empresa->id)
                ->where('id', $citaId)
                ->where('cliente_id', $this->clienteId)
                ->whereIn('estado', ['agendada', 'confirmada'])
                ->first();

            if (!$cita) {
                $this->dispatch('mostrar-mensaje', 
                    mensaje: 'No se puede cancelar esta cita.',
                    tipo: 'error'
                );
                DB::rollBack();
                return;
            }

            // ✅ VERIFICAR 24 HORAS ANTES
            if (!$cita->puedeCancelar('cliente')) {
                $this->dispatch('mostrar-mensaje', 
                    mensaje: 'Solo puedes cancelar 24 horas antes de la cita.',
                    tipo: 'error'
                );
                DB::rollBack();
                return;
            }

            $cita->cancelar('Cancelado por el cliente', 'cliente');

            $this->cliente = ClientesModel::find($this->clienteId);

            DB::commit();

            $this->citasAnteriores = CitasModel::where('cliente_id', $this->clienteId)
                ->orderBy('fecha', 'desc')
                ->orderBy('hora_inicio', 'desc')
                ->limit(10)
                ->get();

            $this->dispatch('mostrar-mensaje', 
                mensaje: 'Cita cancelada correctamente.',
                tipo: 'warning'
            );

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('mostrar-mensaje', 
                mensaje: 'Ocurrió un error al cancelar la cita. Intenta nuevamente.',
                tipo: 'error'
            );
        }
    }

    // ==================== AGENDAR CITA ====================

    public function agendarCita()
    {
        $this->validate();

        if (!$this->validarClienteActivo()) {
            return;
        }

        // Verificar disponibilidad
        $horaDisponible = false;
        foreach ($this->horasDisponibles as $hora) {
            if ($hora['inicio'] === $this->horaInicio && $hora['disponible']) {
                $horaDisponible = true;
                break;
            }
        }

        if (!$horaDisponible) {
            $this->addError('horaInicio', 'La hora seleccionada ya no está disponible.');
            return;
        }

        $this->cargando = true;

        try {
            DB::beginTransaction();

            $servicio = ServiciosModel::find($this->servicioId);
            $horaFin = Carbon::parse($this->horaInicio)->addMinutes($servicio->duracion_minutos)->format('H:i');

            $cita = CitasModel::create([
                'empresa_id' => $this->empresa->id,
                'cliente_id' => $this->clienteId,
                'servicio_id' => $this->servicioId,
                'colaborador_id' => $this->colaboradorId,
                'fecha' => $this->fecha,
                'hora_inicio' => $this->horaInicio,
                'hora_fin' => $horaFin,
                'nombre_acompanante' => $this->nombreAcompanante,
                'estado' => 'agendada',
                'monto_pagado' => $servicio->precio,
                'pagado' => false,
            ]);

            DB::commit();

            $this->dispatch('mostrar-mensaje', 
                mensaje: '¡Cita agendada correctamente! Te esperamos el ' . Carbon::parse($this->fecha)->format('d/m/Y') . ' a las ' . $this->horaInicio,
                tipo: 'success'
            );

            $this->reset(['servicioId', 'colaboradorId', 'horaInicio', 'nombreAcompanante', 'observaciones', 'fecha']);
            $this->diasDisponibles = [];
            $this->horasDisponibles = [];
            
            $this->totalCitas = CitasModel::where('cliente_id', $this->clienteId)->count();
            $this->citasAnteriores = CitasModel::where('cliente_id', $this->clienteId)
                ->orderBy('fecha', 'desc')
                ->orderBy('hora_inicio', 'desc')
                ->limit(10)
                ->get();

            $this->mostrarHistorial = true;
            $this->mostrarFormulario = false;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('mostrar-mensaje', 
                mensaje: 'Ocurrió un error al agendar la cita. Intenta nuevamente.',
                tipo: 'error'
            );
        }

        $this->cargando = false;
    }

    public function render()
    {
        return view('livewire.cliente.agendar-cita', [
            'cliente' => $this->cliente,
            'servicios' => $this->servicios,
            'colaboradores' => $this->colaboradores,
            'citasAnteriores' => $this->citasAnteriores,
            'totalCitas' => $this->totalCitas,
            'mostrarFormulario' => $this->mostrarFormulario,
            'mostrarHistorial' => $this->mostrarHistorial,
            'puntosMalos' => $this->cliente->puntos_malos ?? 0,
            'puntosBuenos' => $this->cliente->puntos_buenos ?? 0,
            'diasDisponibles' => $this->diasDisponibles,
            'horasDisponibles' => $this->horasDisponibles,
            'duracionServicio' => $this->duracionServicio,
        ]);
    }
}