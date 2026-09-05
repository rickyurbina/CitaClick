<?php

namespace App\Livewire\Cliente;

use App\Models\EmpresasModel;
use App\Models\CitasModel;
use App\Models\ClientesModel;
use App\Models\ServiciosModel;
use App\Models\User;
use App\Models\ColaboradorHorario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    // Reagendar
    public ?int $citaReagendarId = null;
    public ?CitasModel $citaReagendar = null;

    public $servicioId = '';
    public $colaboradorId = '';
    public $fecha = '';
    public $horaInicio = '';
    public $nombreAcompanante = '';
    public $observaciones = '';

    public bool $cargando = false;
    public bool $cargandoCalendario = false;

    public array $diasDisponibles = [];
    public array $horasDisponibles = [];
    public int $duracionServicio = 0;
    public int $diasRango = 30;

    public array $diasCalendario = [];

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

    public function mount($clienteId, $citaId = null)
    {
        $this->clienteId = $clienteId;
        $this->cliente = ClientesModel::with(['citas' => function ($query) {
            $query->orderBy('fecha', 'desc')
                ->orderBy('hora_inicio', 'desc')
                ->limit(10);
        }])->findOrFail($clienteId);

        // Si se pasa un ID de cita para reagendar (desde URL o evento)
        if ($citaId) {
            $this->cargarCitaParaReagendar($citaId);
        }

        $this->cargarHistorial();

        if ($this->totalCitas === 0 && !$citaId) {
            $this->mostrarFormulario = true;
            $this->mostrarHistorial = false;
        }

        if (!$this->fecha) {
            $this->fecha = '';
            $this->generarCalendario();
        }
    }

    // ==================== REAGENDAR DESDE EVENTO ====================

    public function cargarCitaParaReagendar($citaId)
    {
        $cita = CitasModel::where('empresa_id', $this->empresa->id)
            ->where('id', $citaId)
            ->where('cliente_id', $this->clienteId)
            ->whereIn('estado', ['agendada', 'confirmada'])
            ->first();

        if (!$cita) {
            $this->dispatch('mostrar-mensaje', mensaje: 'No se puede reagendar esta cita.', tipo: 'error');
            return;
        }

        // Validar que se pueda reagendar (misma regla que cancelar: 24 horas)
        if (!$cita->puedeCancelar('cliente')) {
            $this->dispatch('mostrar-mensaje', mensaje: 'Solo puedes reagendar 24 horas antes de la cita.', tipo: 'error');
            return;
        }

        $this->citaReagendarId = $cita->id;
        $this->citaReagendar = $cita;
        $this->servicioId = $cita->servicio_id;
        $this->colaboradorId = $cita->colaborador_id;
        $this->nombreAcompanante = $cita->nombre_acompanante;
        $this->observaciones = $cita->observaciones;
        $this->mostrarFormulario = true;
        $this->mostrarHistorial = false;

        // Obtener fecha y hora como string
        $fechaStr = $this->normalizarFecha($cita->fecha);
        $horaStr = $this->normalizarHora($cita->hora_inicio);
        $this->fecha = $fechaStr ?: '';
        $this->horaInicio = $horaStr ?: '';

        $this->calcularDiasDisponibles();
        $this->generarCalendario();
        $this->cargarHorasDisponibles();
    }

    // ==================== MÉTODOS AUXILIARES DE NORMALIZACIÓN ====================

    private function normalizarFecha($fecha): ?string
    {
        if (!$fecha) return null;
        if ($fecha instanceof \DateTime) return $fecha->format('Y-m-d');
        if (is_object($fecha) && method_exists($fecha, 'format')) return $fecha->format('Y-m-d');
        if (is_string($fecha) && strtotime($fecha)) return date('Y-m-d', strtotime($fecha));
        return null;
    }

    private function normalizarHora($hora): ?string
    {
        if (!$hora) return null;
        if ($hora instanceof \DateTime) return $hora->format('H:i');
        if (is_object($hora) && method_exists($hora, 'format')) return $hora->format('H:i');
        if (is_string($hora) && strtotime($hora)) return date('H:i', strtotime($hora));
        return null;
    }

    // ==================== RESTANTE DEL CÓDIGO (SIN CAMBIOS) ====================

    public function getServiciosProperty()
    {
        return ServiciosModel::where('empresa_id', $this->empresa->id)
            ->where('activo', 1)
            ->orderBy('nombre')
            ->get();
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

        return $query->orderBy('nombre')->get();
    }

    private function obtenerHorarioConfig($colaboradorId)
    {
        Log::info('obtenerHorarioConfig - Inicio', ['colaborador_id' => $colaboradorId]);

        $colaborador = User::with('horario')->find($colaboradorId);
        if (!$colaborador) {
            Log::warning('Colaborador no encontrado');
            return [];
        }

        if ($colaborador->horario) {
            return $colaborador->horario->configuracion;
        }

        $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
        $config = [];
        foreach ($dias as $dia) {
            $config[$dia] = [
                'activo' => true,
                'inicio' => '09:00',
                'fin' => '18:00',
            ];
        }

        try {
            $horario = ColaboradorHorario::create([
                'colaborador_id' => $colaboradorId,
                'configuracion' => $config,
            ]);
            Log::info('Horario por defecto creado');
            return $horario->configuracion;
        } catch (\Exception $e) {
            Log::error('Error al crear horario por defecto: ' . $e->getMessage());
            return [];
        }
    }

    private function getDiaSemana($fecha)
    {
        $timestamp = strtotime($fecha);
        $diaNumero = date('N', $timestamp);
        $dias = [
            1 => 'lunes', 2 => 'martes', 3 => 'miercoles',
            4 => 'jueves', 5 => 'viernes', 6 => 'sabado', 7 => 'domingo'
        ];
        return $dias[$diaNumero];
    }

    private function getNombreDia($fecha)
    {
        $dias = [
            'Monday' => 'lunes', 'Tuesday' => 'martes', 'Wednesday' => 'miercoles',
            'Thursday' => 'jueves', 'Friday' => 'viernes', 'Saturday' => 'sabado', 'Sunday' => 'domingo'
        ];
        $nombre = date('l', strtotime($fecha));
        return $dias[$nombre] ?? '';
    }

    public function generarCalendario()
    {
        $hoy = date('Y-m-d');
        $totalDias = $this->diasRango;

        $dias = [];
        for ($i = 0; $i < $totalDias; $i++) {
            $fecha = date('Y-m-d', strtotime($hoy . ' + ' . $i . ' days'));
            $diaNum = (int) date('j', strtotime($fecha));
            $nombreDia = $this->getNombreDia($fecha);

            $disponible = false;
            foreach ($this->diasDisponibles as $d) {
                if ($d['fecha'] === $fecha) {
                    $disponible = true;
                    break;
                }
            }

            $dias[] = [
                'dia' => $diaNum,
                'fecha' => $fecha,
                'nombreDia' => $nombreDia,
                'esHoy' => ($fecha === $hoy),
                'esSeleccionado' => ($this->fecha === $fecha),
                'disponible' => $disponible,
            ];
        }

        $primerDiaSemana = (int) date('w', strtotime($hoy));

        $semanas = [];
        $semanaActual = array_fill(0, 7, null);

        $indiceDia = 0;
        $posicion = $primerDiaSemana;
        while ($indiceDia < count($dias) && $posicion < 7) {
            $semanaActual[$posicion] = $dias[$indiceDia];
            $indiceDia++;
            $posicion++;
        }

        if ($posicion == 7 && $indiceDia < count($dias)) {
            $semanas[] = $semanaActual;
            $semanaActual = array_fill(0, 7, null);
        }

        while ($indiceDia < count($dias)) {
            for ($col = 0; $col < 7 && $indiceDia < count($dias); $col++) {
                $semanaActual[$col] = $dias[$indiceDia];
                $indiceDia++;
            }
            $semanas[] = $semanaActual;
            $semanaActual = array_fill(0, 7, null);
        }

        $this->diasCalendario = $semanas;
    }

    public function calcularDiasDisponibles()
    {
        Log::info('calcularDiasDisponibles - Inicio', [
            'colaboradorId' => $this->colaboradorId,
            'servicioId' => $this->servicioId
        ]);

        $this->cargandoCalendario = true;

        try {
            if (!$this->colaboradorId || !$this->servicioId) {
                $this->diasDisponibles = [];
                $this->duracionServicio = 0;
                $this->generarCalendario();
                $this->cargandoCalendario = false;
                return;
            }

            $servicio = ServiciosModel::find($this->servicioId);
            if (!$servicio) {
                $this->diasDisponibles = [];
                $this->duracionServicio = 0;
                $this->generarCalendario();
                $this->cargandoCalendario = false;
                return;
            }

            $this->duracionServicio = $servicio->duracion_minutos;
            $horarioConfig = $this->obtenerHorarioConfig($this->colaboradorId);

            if (empty($horarioConfig)) {
                $this->diasDisponibles = [];
                $this->generarCalendario();
                $this->cargandoCalendario = false;
                return;
            }

            $hoy = date('Y-m-d');
            $fechaFin = date('Y-m-d', strtotime($hoy . ' + ' . ($this->diasRango - 1) . ' days'));

            $citasOcupadas = CitasModel::where('empresa_id', $this->empresa->id)
                ->where('colaborador_id', $this->colaboradorId)
                ->whereDate('fecha', '>=', $hoy)
                ->whereDate('fecha', '<=', $fechaFin)
                ->where('estado', '!=', 'cancelada')
                ->where('estado', '!=', 'no_asistio')
                ->get();

            $citasPorFecha = [];
            foreach ($citasOcupadas as $cita) {
                $fechaCita = $this->normalizarFecha($cita->fecha);
                if (!isset($citasPorFecha[$fechaCita])) {
                    $citasPorFecha[$fechaCita] = [];
                }
                $citasPorFecha[$fechaCita][] = $cita;
            }

            $diasDisponibles = [];

            for ($i = 0; $i < $this->diasRango; $i++) {
                $fecha = date('Y-m-d', strtotime($hoy . ' + ' . $i . ' days'));

                if ($fecha < $hoy) continue;

                $diaSemana = $this->getDiaSemana($fecha);
                $infoDia = $horarioConfig[$diaSemana] ?? null;

                if (!$infoDia || !$infoDia['activo']) continue;

                $horarioInicio = $infoDia['inicio'] ?? '09:00';
                $horarioFin = $infoDia['fin'] ?? '18:00';

                $citasDelDia = $citasPorFecha[$fecha] ?? [];

                $espacios = $this->calcularEspacios($horarioInicio, $horarioFin, $this->duracionServicio, $citasDelDia, $fecha);

                if ($espacios > 0) {
                    $diasDisponibles[] = [
                        'fecha' => $fecha,
                        'dia' => (int) date('j', strtotime($fecha)),
                        'mes' => (int) date('n', strtotime($fecha)),
                        'año' => (int) date('Y', strtotime($fecha)),
                        'espacios' => $espacios,
                        'esHoy' => ($fecha === $hoy),
                    ];
                }
            }

            $this->diasDisponibles = $diasDisponibles;
            $this->generarCalendario();

        } catch (\Exception $e) {
            Log::error('Error en calcularDiasDisponibles', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->diasDisponibles = [];
            $this->generarCalendario();
        }

        $this->cargandoCalendario = false;
    }

    private function calcularEspacios($inicio, $fin, $duracion, $citasDelDia, $fecha)
    {
        $inicioMinutos = $this->horaToMinutos($inicio);
        $finMinutos = $this->horaToMinutos($fin);

        $bloques = [];
        $horaActual = $inicioMinutos;

        $ahoraMinutos = null;
        if ($fecha === date('Y-m-d')) {
            $ahoraMinutos = $this->horaToMinutos(date('H:i'));
        }

        while ($horaActual + $duracion <= $finMinutos) {
            if ($ahoraMinutos !== null && $horaActual < $ahoraMinutos + 120) {
                $horaActual += $duracion;
                continue;
            }

            $bloques[] = [
                'inicio' => $this->minutosToHora($horaActual),
                'fin' => $this->minutosToHora($horaActual + $duracion),
                'inicioMinutos' => $horaActual,
                'finMinutos' => $horaActual + $duracion,
            ];
            $horaActual += $duracion;
        }

        $disponibles = 0;
        foreach ($bloques as $bloque) {
            $ocupado = false;
            foreach ($citasDelDia as $cita) {
                $horaInicioCita = $this->normalizarHora($cita->hora_inicio);
                $horaFinCita = $this->normalizarHora($cita->hora_fin);

                $citaInicio = $this->horaToMinutos($horaInicioCita);
                $citaFin = $this->horaToMinutos($horaFinCita);
                if ($bloque['inicioMinutos'] < $citaFin && $bloque['finMinutos'] > $citaInicio) {
                    $ocupado = true;
                    break;
                }
            }
            if (!$ocupado) $disponibles++;
        }
        return $disponibles;
    }

    private function horaToMinutos($hora)
    {
        list($h, $m) = explode(':', $hora);
        return (int)$h * 60 + (int)$m;
    }

    private function minutosToHora($minutos)
    {
        $h = floor($minutos / 60);
        $m = $minutos % 60;
        return str_pad($h, 2, '0', STR_PAD_LEFT) . ':' . str_pad($m, 2, '0', STR_PAD_LEFT);
    }

    public function cargarHorasDisponibles()
    {
        if (!$this->fecha || !strtotime($this->fecha)) {
            $this->horasDisponibles = [];
            return;
        }

        if (!$this->colaboradorId || !$this->servicioId) {
            $this->horasDisponibles = [];
            return;
        }

        $servicio = ServiciosModel::find($this->servicioId);
        if (!$servicio) {
            $this->horasDisponibles = [];
            return;
        }

        $horarioConfig = $this->obtenerHorarioConfig($this->colaboradorId);
        $diaSemana = $this->getDiaSemana($this->fecha);
        $infoDia = $horarioConfig[$diaSemana] ?? null;

        if (!$infoDia || !$infoDia['activo']) {
            $this->horasDisponibles = [];
            return;
        }

        $horarioInicio = $infoDia['inicio'] ?? '09:00';
        $horarioFin = $infoDia['fin'] ?? '18:00';
        $duracion = $servicio->duracion_minutos;

        $citasDelDia = CitasModel::where('empresa_id', $this->empresa->id)
            ->where('colaborador_id', $this->colaboradorId)
            ->whereDate('fecha', $this->fecha)
            ->where('estado', '!=', 'cancelada')
            ->where('estado', '!=', 'no_asistio')
            ->get();

        $inicioMinutos = $this->horaToMinutos($horarioInicio);
        $finMinutos = $this->horaToMinutos($horarioFin);
        $horas = [];
        $horaActual = $inicioMinutos;
        $hoy = date('Y-m-d');
        $ahoraMinutos = null;
        if ($this->fecha === $hoy) {
            $ahoraMinutos = $this->horaToMinutos(date('H:i'));
        }

        while ($horaActual + $duracion <= $finMinutos) {
            $inicioBloque = $horaActual;
            $finBloque = $horaActual + $duracion;
            $ocupado = false;

            if ($ahoraMinutos !== null && $inicioBloque < $ahoraMinutos + 120) {
                $ocupado = true;
            }

            if (!$ocupado) {
                foreach ($citasDelDia as $cita) {
                    $horaInicioCita = $this->normalizarHora($cita->hora_inicio);
                    $horaFinCita = $this->normalizarHora($cita->hora_fin);

                    $citaInicio = $this->horaToMinutos($horaInicioCita);
                    $citaFin = $this->horaToMinutos($horaFinCita);
                    if ($inicioBloque < $citaFin && $finBloque > $citaInicio) {
                        $ocupado = true;
                        break;
                    }
                }
            }

            $horas[] = [
                'inicio' => $this->minutosToHora($inicioBloque),
                'fin' => $this->minutosToHora($finBloque),
                'disponible' => !$ocupado,
            ];

            $horaActual += $duracion;
        }

        $this->horasDisponibles = $horas;
    }

    public function seleccionarFecha($fecha)
    {
        if (!strtotime($fecha)) return;
        $this->fecha = $fecha;
        $this->cargarHorasDisponibles();
        $this->horaInicio = '';
        $this->generarCalendario();
        $this->dispatch('limpiar-mensaje');
    }

    public function seleccionarHora($hora)
    {
        $this->horaInicio = $hora;
        $this->dispatch('limpiar-mensaje');
    }

    public function updatedServicioId()
    {
        if ($this->colaboradorId) {
            $this->colaboradorId = '';
            $this->fecha = '';
            $this->horaInicio = '';
            $this->horasDisponibles = [];
            $this->diasDisponibles = [];
            $this->duracionServicio = 0;
            $this->generarCalendario();
        }
        $this->dispatch('limpiar-mensaje');
    }

    public function updatedColaboradorId()
    {
        if ($this->colaboradorId) {
            $this->fecha = '';
            $this->horaInicio = '';
            $this->horasDisponibles = [];
            $this->calcularDiasDisponibles();
            $this->dispatch('limpiar-mensaje');
        }
    }

    public function mostrarFormularioCita()
    {
        if ($this->citaReagendarId) {
            $this->dispatch('mostrar-mensaje', mensaje: 'Para reagendar solo puedes cambiar la fecha y hora.', tipo: 'info');
            return;
        }
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

    private function cargarHistorial()
    {
        $this->citasAnteriores = CitasModel::where('cliente_id', $this->clienteId)
            ->orderByRaw("CASE 
                WHEN estado IN ('agendada', 'confirmada', 'en_curso') THEN 0 
                WHEN estado IN ('atendida', 'cancelada', 'no_asistio') THEN 1 
                ELSE 2 
            END")
            ->orderBy('fecha', 'asc')
            ->orderBy('hora_inicio', 'asc')
            ->limit(10)
            ->get();

        $this->totalCitas = CitasModel::where('cliente_id', $this->clienteId)->count();
    }

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
                $this->dispatch('mostrar-mensaje', mensaje: 'No se puede cancelar esta cita.', tipo: 'error');
                DB::rollBack();
                return;
            }

            if (!$cita->puedeCancelar('cliente')) {
                $this->dispatch('mostrar-mensaje', mensaje: 'Solo puedes cancelar 24 horas antes de la cita.', tipo: 'error');
                DB::rollBack();
                return;
            }

            $cita->cancelar('Cancelado por el cliente', 'cliente');
            DB::commit();

            $this->cargarHistorial();
            $this->dispatch('mostrar-mensaje', mensaje: 'Cita cancelada correctamente.', tipo: 'warning');

            if ($this->fecha) {
                $this->cargarHorasDisponibles();
                $this->generarCalendario();
            }

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('mostrar-mensaje', mensaje: 'Ocurrió un error al cancelar la cita. Intenta nuevamente.', tipo: 'error');
        }
    }

    // ==================== REAGENDAR (NUEVO MÉTODO) ====================

    public function reagendarCita($citaId)
    {
        $this->cargarCitaParaReagendar($citaId);
        // No redirigir, solo actualizar el estado del componente
    }

    public function agendarCita()
    {
        $this->validate();

        if (!$this->validarClienteActivo()) return;

        // Verificar que la hora aún esté disponible
        $horaDisponible = false;
        foreach ($this->horasDisponibles as $hora) {
            if ($hora['inicio'] === $this->horaInicio && $hora['disponible']) {
                $horaDisponible = true;
                break;
            }
        }

        if (!$horaDisponible) {
            $this->addError('horaInicio', 'La hora seleccionada ya no está disponible.');
            $this->cargarHorasDisponibles();
            return;
        }

        $this->cargando = true;

        try {
            DB::beginTransaction();
            $servicio = ServiciosModel::find($this->servicioId);
            $horaFin = $this->sumarMinutos($this->horaInicio, $servicio->duracion_minutos);

            $datos = [
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
            ];

            if ($this->citaReagendarId) {
                $cita = CitasModel::where('empresa_id', $this->empresa->id)
                    ->where('id', $this->citaReagendarId)
                    ->where('cliente_id', $this->clienteId)
                    ->first();

                if (!$cita) {
                    throw new \Exception('Cita no encontrada para reagendar.');
                }

                $cita->update([
                    'fecha' => $this->fecha,
                    'hora_inicio' => $this->horaInicio,
                    'hora_fin' => $horaFin,
                    'nombre_acompanante' => $this->nombreAcompanante,
                    'estado' => 'agendada',
                ]);

                $mensaje = '¡Cita reagendada correctamente! Nueva fecha: ' . date('d/m/Y', strtotime($this->fecha)) . ' a las ' . $this->horaInicio;

            } else {
                $cita = CitasModel::create($datos);
                $mensaje = '¡Cita agendada correctamente! Te esperamos el ' . date('d/m/Y', strtotime($this->fecha)) . ' a las ' . $this->horaInicio;
            }

            DB::commit();

            $this->cargarHistorial();

            // Resetear formulario
            $this->reset([
                'servicioId',
                'colaboradorId',
                'horaInicio',
                'nombreAcompanante',
                'observaciones',
                'fecha',
                'citaReagendarId',
                'citaReagendar',
            ]);
            $this->horasDisponibles = [];
            $this->diasDisponibles = [];
            $this->duracionServicio = 0;
            $this->generarCalendario();

            $this->mostrarHistorial = true;
            $this->mostrarFormulario = false;

            $this->dispatch('mostrar-mensaje', mensaje: $mensaje, tipo: 'success');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('mostrar-mensaje', mensaje: 'Ocurrió un error al procesar la cita. Intenta nuevamente.', tipo: 'error');
        }

        $this->cargando = false;
    }

    private function sumarMinutos($hora, $minutos)
    {
        $timestamp = strtotime($hora);
        $nuevoTimestamp = strtotime("+{$minutos} minutes", $timestamp);
        return date('H:i', $nuevoTimestamp);
    }

    public function validarClienteActivo(): bool
    {
        if ($this->cliente->estaBloqueado()) {
            $this->dispatch('mostrar-mensaje', mensaje: 'No puedes agendar citas. Estás bloqueado hasta el ' . date('d/m/Y', strtotime($this->cliente->bloqueado_hasta)), tipo: 'error');
            return false;
        }
        return true;
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
            'diasCalendario' => $this->diasCalendario,
            'cargandoCalendario' => $this->cargandoCalendario,
            'citaReagendar' => $this->citaReagendar,
        ]);
    }
}