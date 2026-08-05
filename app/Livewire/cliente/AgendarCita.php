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

    // Datos del cliente
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

    // Estados
    public bool $cargando = false;

    /**
     * Reglas de validación - Solo reglas simples
     */
    protected $rules = [
        'servicioId' => 'required|exists:servicios,id',
        'colaboradorId' => 'required|exists:users,id',
        'fecha' => 'required|date|after_or_equal:today',
        'horaInicio' => 'required|date_format:H:i',
        'nombreAcompanante' => 'nullable|string|max:100',
        'observaciones' => 'nullable|string|max:255',
    ];

    /**
     * Mensajes de validación personalizados
     */
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

        // Si no tiene citas anteriores, mostrar el formulario directamente
        if ($this->totalCitas === 0) {
            $this->mostrarFormulario = true;
            $this->mostrarHistorial = false;
        }
    }

    /**
     * Obtener servicios activos de la empresa
     */
    public function getServiciosProperty()
    {
        return ServiciosModel::where('empresa_id', $this->empresa->id)
            ->where('activo', 1)
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'precio', 'duracion_minutos']);
    }

    /**
     * Obtener colaboradores disponibles
     */
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

    // ==================== VALIDACIÓN PERSONALIZADA ====================

    /**
     * Validar que el horario esté disponible
     * ✅ Reutilizable
     * ✅ Testeable
     * ✅ Acceso completo a $this
     */
    public function validarHorarioDisponible(): bool
    {
        // Si falta información, no validar
        if (!$this->colaboradorId || !$this->fecha || !$this->horaInicio || !$this->servicioId) {
            return true;
        }

        $servicio = ServiciosModel::find($this->servicioId);
        if (!$servicio) {
            return true;
        }

        // Calcular hora de fin
        $horaFin = Carbon::parse($this->horaInicio)->addMinutes($servicio->duracion_minutos);

        // Verificar conflicto de horario
        $conflicto = CitasModel::where('empresa_id', $this->empresa->id)
            ->where('colaborador_id', $this->colaboradorId)
            ->where('fecha', $this->fecha)
            ->where('estado', '!=', 'cancelada')
            ->where('estado', '!=', 'no_asistio')
            ->where(function ($query) use ($horaFin) {
                $query->whereBetween('hora_inicio', [$this->horaInicio, $horaFin->format('H:i')])
                    ->orWhereBetween('hora_fin', [$this->horaInicio, $horaFin->format('H:i')])
                    ->orWhere(function ($q) use ($horaFin) {
                        $q->where('hora_inicio', '<=', $this->horaInicio)
                          ->where('hora_fin', '>=', $horaFin->format('H:i'));
                    });
            })
            ->exists();

        if ($conflicto) {
            $this->addError('horaInicio', 'El colaborador ya tiene una cita en ese horario.');
            return false;
        }

        // ✅ Agregar más validaciones fácilmente:
        // - Verificar horario laboral del colaborador
        // - Verificar días de descanso
        // - Verificar límite de citas por día
        // - Verificar tiempo mínimo entre citas

        return true;
    }

    /**
     * Validar que el cliente no esté bloqueado
     */
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

    // ==================== EVENTOS EN TIEMPO REAL ====================

    public function updatedServicioId()
    {
        $this->colaboradorId = '';
        $this->dispatch('limpiar-mensaje');
    }

    public function updatedFecha()
    {
        $this->dispatch('limpiar-mensaje');
        // ✅ Validar en tiempo real
        if ($this->horaInicio) {
            $this->validarHorarioDisponible();
        }
    }

    public function updatedHoraInicio()
    {
        $this->dispatch('limpiar-mensaje');
        // ✅ Validar en tiempo real cuando el usuario cambia la hora
        $this->validarHorarioDisponible();
    }

    public function updatedColaboradorId()
    {
        $this->dispatch('limpiar-mensaje');
        // ✅ Validar en tiempo real cuando el usuario cambia el colaborador
        if ($this->horaInicio && $this->fecha) {
            $this->validarHorarioDisponible();
        }
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

    // ==================== AGENDAR CITA ====================

    public function agendarCita()
    {
        // 1. Validar reglas básicas
        $this->validate();

        // 2. ✅ Validar disponibilidad de horario
        if (!$this->validarHorarioDisponible()) {
            return;
        }

        // 3. ✅ Validar que el cliente esté activo
        if (!$this->validarClienteActivo()) {
            return;
        }

        $this->cargando = true;

        try {
            DB::beginTransaction();

            $servicio = ServiciosModel::find($this->servicioId);
            $horaFin = Carbon::parse($this->horaInicio)->addMinutes($servicio->duracion_minutos)->format('H:i');

            // Crear la cita
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

            // Mensaje de éxito
            $this->dispatch('mostrar-mensaje', 
                mensaje: '¡Cita agendada correctamente! Te esperamos el ' . Carbon::parse($this->fecha)->format('d/m/Y') . ' a las ' . $this->horaInicio,
                tipo: 'success'
            );

            // Resetear formulario
            $this->reset(['servicioId', 'colaboradorId', 'horaInicio', 'nombreAcompanante', 'observaciones']);
            
            // Actualizar historial
            $this->totalCitas = CitasModel::where('cliente_id', $this->clienteId)->count();
            $this->citasAnteriores = CitasModel::where('cliente_id', $this->clienteId)
                ->orderBy('fecha', 'desc')
                ->orderBy('hora_inicio', 'desc')
                ->limit(10)
                ->get();

            // Mostrar historial después de agendar
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

            // Cancelar cita
            $cita->estado = 'cancelada';
            $cita->motivo_cancelacion = 'Cancelado por el cliente';
            $cita->cancelada_por = 'cliente';
            $cita->save();

            // Sumar puntos negativos
            $this->cliente->sumarPuntosMalos(2);

            // Bloquear si acumula 5 puntos negativos
            if ($this->cliente->puntos_malos >= 5) {
                $this->cliente->bloquear(15);
                $this->dispatch('mostrar-mensaje', 
                    mensaje: 'Has acumulado 5 puntos negativos. Serás bloqueado por 15 días.',
                    tipo: 'warning'
                );
            }

            // Recargar cliente actualizado
            $this->cliente = ClientesModel::find($this->clienteId);

            DB::commit();

            // Actualizar historial
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

    // ==================== RENDER ====================

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
        ]);
    }
}