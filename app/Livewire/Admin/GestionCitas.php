<?php

namespace App\Livewire\Admin;

use App\Models\EmpresasModel;
use App\Models\CitasModel;
use App\Models\ClientesModel;
use App\Models\ServiciosModel;
use App\Models\ComisionesModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class GestionCitas extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public EmpresasModel $empresa;

    // ==================== MODALES ====================
    public $mostrarModalCita = false;
    public $mostrarModalColaborador = false;
    public $mostrarModalServicio = false;
    public $mostrarModalPago = false;

    // ==================== FORMULARIO CITA ====================
    public $citaIdEditar = null;
    public $clienteId = '';
    public $servicioId = '';
    public $colaboradorId = '';
    public $fecha = '';
    public $horaInicio = '';
    public $estado = 'agendada';
    public $montoPagado = '';
    public $metodoPago = '';

    // ==================== FORMULARIO COLABORADOR ====================
    public $colaboradorIdEditar = null;
    public $colaboradorNombre = '';
    public $colaboradorEmail = '';
    public $colaboradorTelefono = '';
    public $colaboradorPassword = '';
    public $colaboradorComision = '';
    public $colaboradorHorarioInicio = '09:00';
    public $colaboradorHorarioFin = '18:00';
    public $colaboradorActivo = true;
    public $colaboradorServicios = [];

    // ==================== FORMULARIO SERVICIO ====================
    public $servicioIdEditar = null;
    public $servicioNombre = '';
    public $servicioDuracion = 30;
    public $servicioPrecio = '';
    public $servicioPuntos = 10;
    public $servicioActivo = true;

    // ==================== FORMULARIO PAGO ====================
    public $citaPagoId = null;
    public $citaPago = null;
    public $montoPago = '';
    public $metodoPagoSeleccionado = '';
    public $referenciaPago = '';

    // ==================== CALENDARIO DINÁMICO ====================
    public array $diasDisponibles = [];
    public array $horasDisponibles = [];
    public array $diasCalendario = [];
    public int $mesActual;
    public int $añoActual;
    public int $duracionServicio = 0;
    public bool $cargandoCalendario = false;

    // ==================== FILTROS ====================
    public $filtroFecha = '';
    public $filtroEstado = '';
    public $filtroColaborador = '';
    public $buscarCliente = '';

    public $cargando = false;

    // ==================== PROPIEDADES COMPUTADAS ====================

    public function getEsAdminProperty()
    {
        return in_array(Auth::guard('web')->user()->rol, ['empresa_admin', 'super_admin']);
    }

    public function getEsRecepcionistaProperty()
    {
        return Auth::guard('web')->user()->rol === 'recepcionista';
    }

    public function getEsColaboradorProperty()
    {
        return Auth::guard('web')->user()->rol === 'colaborador';
    }

    public function getPuedeGestionarProperty()
    {
        return $this->esAdmin || $this->esRecepcionista;
    }

    public function getPuedeCrearColaboradoresProperty()
    {
        return $this->esAdmin;
    }

    public function getPuedeCrearServiciosProperty()
    {
        return $this->esAdmin;
    }

    public function getUsuarioIdProperty()
    {
        return Auth::guard('web')->user()->id;
    }

    // ==================== CONSULTAS ====================

    protected function citasQuery()
    {
        $query = CitasModel::where('empresa_id', $this->empresa->id)
            ->with(['cliente:id,nombre,telefono',
                    'servicio:id,nombre,precio,duracion_minutos',
                    'colaborador:id,nombre,comision_porcentaje']);

        if ($this->esColaborador) {
            $query->where('colaborador_id', Auth::guard('web')->user()->id);
        }

        return $query;
    }

    public function getCitasHoyCountProperty()
    {
        return $this->citasQuery()->whereDate('fecha', Carbon::today())->count();
    }

    public function getIngresosHoyTotalProperty()
    {
        return $this->citasQuery()
            ->whereDate('fecha_pago', Carbon::today())
            ->where('pagado', 1)
            ->sum('monto_pagado');
    }

    public function getEfectivoHoyProperty()
    {
        if (!$this->puedeGestionar && !$this->esAdmin) {
            return 0;
        }
        return $this->citasQuery()
            ->whereDate('fecha_pago', Carbon::today())
            ->where('pagado', 1)
            ->where('metodo_pago', 'efectivo')
            ->sum('monto_pagado');
    }

    public function getTotalCitasColaboradorProperty()
    {
        if (!$this->esColaborador) {
            return 0;
        }
        return CitasModel::where('empresa_id', $this->empresa->id)
            ->where('colaborador_id', $this->usuarioId)
            ->whereDate('fecha', Carbon::today())
            ->count();
    }

    public function getCitasPendientesColaboradorProperty()
    {
        if (!$this->esColaborador) {
            return 0;
        }
        return CitasModel::where('empresa_id', $this->empresa->id)
            ->where('colaborador_id', $this->usuarioId)
            ->whereDate('fecha', Carbon::today())
            ->whereIn('estado', ['agendada', 'confirmada'])
            ->count();
    }

    public function getIngresoColaboradorProperty()
    {
        if (!$this->esColaborador) {
            return 0;
        }
        $colaborador = User::find($this->usuarioId);
        if (!$colaborador || !$colaborador->comision_porcentaje) {
            return 0;
        }
        $totalVentas = CitasModel::where('empresa_id', $this->empresa->id)
            ->where('colaborador_id', $this->usuarioId)
            ->where('pagado', 1)
            ->sum('monto_pagado');
        return $totalVentas * ($colaborador->comision_porcentaje / 100);
    }

    public function getCitasListProperty()
    {
        $query = $this->citasQuery();

        if ($this->filtroFecha) {
            $query->whereDate('fecha', $this->filtroFecha);
        }

        if ($this->filtroEstado) {
            $query->where('estado', $this->filtroEstado);
        }

        if ($this->filtroColaborador && !$this->esColaborador) {
            $query->where('colaborador_id', $this->filtroColaborador);
        }

        if ($this->buscarCliente) {
            $query->whereHas('cliente', function ($q) {
                $q->where('nombre', 'like', '%' . $this->buscarCliente . '%')
                  ->orWhere('telefono', 'like', '%' . $this->buscarCliente . '%');
            });
        }

        return $query
            ->orderByDesc('fecha')
            ->orderByDesc('hora_inicio')
            ->paginate(15);
    }

    public function getClientesListProperty()
    {
        return ClientesModel::where('empresa_id', $this->empresa->id)
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'telefono']);
    }

    public function getServiciosListProperty()
    {
        return ServiciosModel::where('empresa_id', $this->empresa->id)
            ->where('activo', 1)
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'precio', 'duracion_minutos']);
    }

    public function getServiciosAllProperty()
    {
        return ServiciosModel::where('empresa_id', $this->empresa->id)
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'precio', 'duracion_minutos', 'activo']);
    }

    public function getColaboradoresListProperty()
    {
        $query = User::where('empresa_id', $this->empresa->id)
            ->where('rol', 'colaborador')
            ->where('activo', 1);

        if ($this->servicioId) {
            $query->whereHas('servicios', function ($q) {
                $q->where('servicios.id', $this->servicioId);
            });
        }

        return $query->orderBy('nombre')->get(['id', 'nombre', 'comision_porcentaje']);
    }

    // ==================== CALENDARIO DINÁMICO ====================

    public function generarDiasCalendario()
    {
        $fecha = Carbon::create($this->añoActual, $this->mesActual, 1);
        $ultimoDia = $fecha->copy()->endOfMonth()->day;
        $primerDiaSemana = $fecha->dayOfWeek;
        $offset = $primerDiaSemana === 0 ? 6 : $primerDiaSemana - 1;

        $dias = [];
        for ($i = 0; $i < $offset; $i++) {
            $dias[] = null;
        }

        for ($i = 1; $i <= $ultimoDia; $i++) {
            $fechaDia = Carbon::create($this->añoActual, $this->mesActual, $i)->startOfDay();
            $fechaStr = $fechaDia->format('Y-m-d');

            $dias[] = [
                'dia' => $i,
                'fecha' => $fechaStr,
                'disponible' => true,
                'esHoy' => $fechaDia->isToday(),
                'esPasado' => false,
                'esSeleccionado' => $this->fecha === $fechaStr,
            ];
        }

        while (count($dias) < 42) {
            $dias[] = null;
        }

        $this->diasCalendario = $dias;
    }

    public function calcularDiasDisponibles()
    {
        $this->cargandoCalendario = true;

        try {
            if (!$this->colaboradorId || !$this->servicioId) {
                $this->diasDisponibles = [];
                $this->duracionServicio = 0;
                $this->generarDiasCalendario();
                $this->cargandoCalendario = false;
                return;
            }

            $servicio = ServiciosModel::find($this->servicioId);
            if (!$servicio) {
                $this->diasDisponibles = [];
                $this->duracionServicio = 0;
                $this->generarDiasCalendario();
                $this->cargandoCalendario = false;
                return;
            }

            $this->duracionServicio = $servicio->duracion_minutos;

            $colaborador = User::find($this->colaboradorId);
            if (!$colaborador) {
                $this->diasDisponibles = [];
                $this->generarDiasCalendario();
                $this->cargandoCalendario = false;
                return;
            }

            if ($this->duracionServicio <= 0) {
                $this->diasDisponibles = [];
                $this->generarDiasCalendario();
                $this->cargandoCalendario = false;
                return;
            }

            $horarioInicio = $colaborador->horario_inicio ?? '09:00';
            $horarioFin = $colaborador->horario_fin ?? '20:00';

            $diasRango = 30;
            $citasOcupadas = CitasModel::where('empresa_id', $this->empresa->id)
                ->where('colaborador_id', $this->colaboradorId)
                ->where('fecha', '>=', Carbon::today())
                ->where('fecha', '<=', Carbon::today()->addDays($diasRango))
                ->where('estado', '!=', 'cancelada')
                ->where('estado', '!=', 'no_asistio')
                ->get()
                ->groupBy('fecha');

            $diasDisponibles = [];

            for ($i = 0; $i <= $diasRango; $i++) {
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
            $this->generarDiasCalendario();

        } catch (\Exception $e) {
            $this->diasDisponibles = [];
            $this->generarDiasCalendario();
        }

        $this->cargandoCalendario = false;
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

        $colaborador = User::find($this->colaboradorId);
        if (!$colaborador) {
            $this->horasDisponibles = [];
            return;
        }

        $horarioInicio = $colaborador->horario_inicio ?? '09:00';
        $horarioFin = $colaborador->horario_fin ?? '20:00';
        $duracion = $servicio->duracion_minutos;

        $citasDelDia = CitasModel::where('empresa_id', $this->empresa->id)
            ->where('colaborador_id', $this->colaboradorId)
            ->where('fecha', $this->fecha)
            ->where('estado', '!=', 'cancelada')
            ->where('estado', '!=', 'no_asistio')
            ->get();

        $inicio = Carbon::parse($horarioInicio);
        $fin = Carbon::parse($horarioFin);
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

    public function seleccionarFecha($fecha)
    {
        if (!strtotime($fecha)) {
            return;
        }
        $this->fecha = $fecha;
        $this->cargarHorasDisponibles();
        $this->horaInicio = '';
        $this->generarDiasCalendario();
        $this->dispatch('limpiar-mensaje');
    }

    public function seleccionarHora($hora)
    {
        $this->horaInicio = $hora;
        $this->dispatch('limpiar-mensaje');
    }

    public function cambiarMes($direccion)
    {
        $fecha = Carbon::create($this->añoActual, $this->mesActual, 1)->addMonths($direccion);
        $this->mesActual = $fecha->month;
        $this->añoActual = $fecha->year;
        $this->generarDiasCalendario();
    }

    // ==================== WATCHERS ====================

    public function updatedServicioId()
    {
        $this->colaboradorId = '';
        $this->fecha = '';
        $this->horaInicio = '';
        $this->horasDisponibles = [];
        $this->diasDisponibles = [];
        $this->duracionServicio = 0;
        $this->generarDiasCalendario();
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

    // ==================== MÉTODOS PARA CERRAR MODALES ====================

    public function cerrarTodosLosModales()
    {
        $this->mostrarModalCita = false;
        $this->mostrarModalColaborador = false;
        $this->mostrarModalServicio = false;
        $this->mostrarModalPago = false;
    }

    // ==================== MÉTODOS CITA ====================

    public function abrirCrearCita()
    {
        if (!$this->puedeGestionar) {
            $this->dispatch('error', 'No tienes permiso.');
            return;
        }
        $this->cerrarTodosLosModales();
        $this->resetFormularioCita();
        $this->citaIdEditar = null;
        $this->mesActual = now()->month;
        $this->añoActual = now()->year;
        $this->diasDisponibles = [];
        $this->horasDisponibles = [];
        $this->diasCalendario = [];
        $this->generarDiasCalendario();
        $this->mostrarModalCita = true;
    }

    public function editarCita($id)
    {
        if (!$this->puedeGestionar) {
            $this->dispatch('error', 'No tienes permiso.');
            return;
        }
        $this->cerrarTodosLosModales();

        $cita = CitasModel::where('empresa_id', $this->empresa->id)->findOrFail($id);

        $this->citaIdEditar = $cita->id;
        $this->clienteId = $cita->cliente_id;
        $this->servicioId = $cita->servicio_id;
        $this->colaboradorId = $cita->colaborador_id;
        $this->fecha = $cita->fecha instanceof Carbon ? $cita->fecha->format('Y-m-d') : $cita->fecha;
        $this->horaInicio = substr($cita->hora_inicio, 0, 5);
        $this->estado = $cita->estado;
        $this->montoPagado = $cita->monto_pagado;
        $this->metodoPago = $cita->metodo_pago;

        $this->mesActual = Carbon::parse($this->fecha)->month;
        $this->añoActual = Carbon::parse($this->fecha)->year;
        $this->calcularDiasDisponibles();
        $this->cargarHorasDisponibles();

        $this->mostrarModalCita = true;
    }

    public function guardarCita()
    {
        $this->validate($this->rulesCita());

        $servicio = ServiciosModel::find($this->servicioId);
        $horaFin = Carbon::parse($this->horaInicio)->addMinutes($servicio->duracion_minutos)->format('H:i');

        $datos = [
            'empresa_id' => $this->empresa->id,
            'cliente_id' => $this->clienteId,
            'servicio_id' => $this->servicioId,
            'colaborador_id' => $this->colaboradorId,
            'fecha' => $this->fecha,
            'hora_inicio' => $this->horaInicio,
            'hora_fin' => $horaFin,
            'estado' => $this->estado,
            'monto_pagado' => $this->montoPagado ?: null,
            'metodo_pago' => $this->metodoPago ?: null,
        ];

        if ($this->citaIdEditar) {
            CitasModel::where('id', $this->citaIdEditar)
                ->where('empresa_id', $this->empresa->id)
                ->update($datos);
            $this->dispatch('success', 'Cita actualizada correctamente.');
        } else {
            CitasModel::create($datos);
            $this->dispatch('success', 'Cita creada correctamente.');
        }

        $this->cerrarModalCita();
        $this->resetPage();
    }

    public function eliminarCita($id)
    {
        if ($this->esColaborador) {
            $this->dispatch('error', 'No tienes permiso.');
            return;
        }
        CitasModel::where('id', $id)
            ->where('empresa_id', $this->empresa->id)
            ->delete();
        $this->dispatch('success', 'Cita eliminada.');
        $this->resetPage();
    }

    public function cambiarEstado($id, $nuevoEstado)
    {
        if ($this->esColaborador && !in_array($nuevoEstado, ['en_curso', 'atendida'])) {
            $this->dispatch('error', 'Solo puedes cambiar a "En curso" o "Atendida".');
            return;
        }
        $cita = CitasModel::where('empresa_id', $this->empresa->id)->findOrFail($id);
        $cita->estado = $nuevoEstado;
        $cita->save();
        $this->dispatch('success', 'Estado actualizado a "' . ucfirst($nuevoEstado) . '"');
    }

    protected function rulesCita()
    {
        return [
            'clienteId' => 'required|exists:clientes,id',
            'servicioId' => 'required|exists:servicios,id',
            'colaboradorId' => 'required|exists:users,id',
            'fecha' => 'required|date|after_or_equal:today',
            'horaInicio' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    $conflicto = CitasModel::where('empresa_id', $this->empresa->id)
                        ->where('colaborador_id', $this->colaboradorId)
                        ->where('fecha', $this->fecha)
                        ->where('hora_inicio', $value)
                        ->where('estado', '!=', 'cancelada')
                        ->where('estado', '!=', 'no_asistio')
                        ->when($this->citaIdEditar, function ($query) {
                            return $query->where('id', '!=', $this->citaIdEditar);
                        })
                        ->exists();
                    if ($conflicto) {
                        $fail('El colaborador ya tiene una cita en ese horario.');
                    }
                },
            ],
            'estado' => 'required|in:agendada,confirmada,en_curso,atendida,cancelada,no_asistio',
            'montoPagado' => 'nullable|numeric|min:0',
            'metodoPago' => 'nullable|in:efectivo,transferencia,tarjeta',
        ];
    }

    protected function resetFormularioCita()
    {
        $this->clienteId = '';
        $this->servicioId = '';
        $this->colaboradorId = '';
        $this->fecha = '';
        $this->horaInicio = '';
        $this->estado = 'agendada';
        $this->montoPagado = '';
        $this->metodoPago = '';
        $this->citaIdEditar = null;
        $this->diasDisponibles = [];
        $this->horasDisponibles = [];
        $this->diasCalendario = [];
        $this->duracionServicio = 0;
        $this->resetErrorBag();
    }

    public function cerrarModalCita()
    {
        $this->mostrarModalCita = false;
        $this->resetFormularioCita();
    }

    // ==================== MÉTODOS COLABORADOR ====================

    public function abrirCrearColaborador()
    {
        if (!$this->puedeCrearColaboradores) {
            $this->dispatch('error', 'No tienes permiso para crear colaboradores.');
            return;
        }
        $this->cerrarTodosLosModales();
        $this->resetFormularioColaborador();
        $this->colaboradorIdEditar = null;
        $this->colaboradorServicios = [];
        $this->mostrarModalColaborador = true;
    }

    public function editarColaborador($id)
    {
        if (!$this->puedeCrearColaboradores) {
            $this->dispatch('error', 'No tienes permiso.');
            return;
        }
        $this->cerrarTodosLosModales();

        $colaborador = User::where('empresa_id', $this->empresa->id)
            ->where('rol', 'colaborador')
            ->with('servicios')
            ->findOrFail($id);

        $this->colaboradorIdEditar = $colaborador->id;
        $this->colaboradorNombre = $colaborador->nombre;
        $this->colaboradorEmail = $colaborador->email;
        $this->colaboradorTelefono = $colaborador->telefono;
        $this->colaboradorComision = $colaborador->comision_porcentaje;
        $this->colaboradorHorarioInicio = $colaborador->horario_inicio ?? '09:00';
        $this->colaboradorHorarioFin = $colaborador->horario_fin ?? '18:00';
        $this->colaboradorActivo = (bool) $colaborador->activo;
        $this->colaboradorPassword = '';
        $this->colaboradorServicios = $colaborador->servicios->pluck('id')->toArray();

        $this->mostrarModalColaborador = true;
    }

    public function guardarColaborador()
    {
        $this->validate($this->rulesColaborador(), $this->messagesColaborador());

        $datos = [
            'empresa_id' => $this->empresa->id,
            'nombre' => $this->colaboradorNombre,
            'email' => $this->colaboradorEmail,
            'telefono' => $this->colaboradorTelefono,
            'rol' => 'colaborador',
            'comision_porcentaje' => $this->colaboradorComision ?: null,
            'horario_inicio' => $this->colaboradorHorarioInicio,
            'horario_fin' => $this->colaboradorHorarioFin,
            'activo' => $this->colaboradorActivo,
        ];

        if ($this->colaboradorPassword) {
            $datos['password'] = Hash::make($this->colaboradorPassword);
        }

        if ($this->colaboradorIdEditar) {
            $colaborador = User::where('id', $this->colaboradorIdEditar)
                ->where('empresa_id', $this->empresa->id)
                ->first();
            if ($colaborador) {
                $colaborador->update($datos);
                $colaborador->servicios()->sync($this->colaboradorServicios);
                $this->dispatch('success', 'Colaborador actualizado correctamente.');
            }
        } else {
            if (empty($datos['password'])) {
                $datos['password'] = Hash::make($this->colaboradorEmail);
            }
            $colaborador = User::create($datos);
            if (!empty($this->colaboradorServicios)) {
                $colaborador->servicios()->attach($this->colaboradorServicios);
            }
            $this->dispatch('success', 'Colaborador creado correctamente.');
        }

        $this->cerrarModalColaborador();
        $this->resetPage();
    }

    public function eliminarColaborador($id)
    {
        if (!$this->puedeCrearColaboradores) {
            $this->dispatch('error', 'No tienes permiso.');
            return;
        }
        $citasPendientes = CitasModel::where('empresa_id', $this->empresa->id)
            ->where('colaborador_id', $id)
            ->whereIn('estado', ['agendada', 'confirmada', 'en_curso'])
            ->count();
        if ($citasPendientes > 0) {
            $this->dispatch('error', 'No se puede eliminar. El colaborador tiene citas pendientes.');
            return;
        }
        $colaborador = User::where('id', $id)
            ->where('empresa_id', $this->empresa->id)
            ->first();
        if ($colaborador) {
            $colaborador->servicios()->detach();
            $colaborador->delete();
            $this->dispatch('success', 'Colaborador eliminado.');
        }
        $this->resetPage();
    }

    protected function rulesColaborador()
    {
        return [
            'colaboradorNombre' => 'required|string|max:100',
            'colaboradorEmail' => 'required|email|max:150|unique:users,email,' . ($this->colaboradorIdEditar ?? 'NULL'),
            'colaboradorTelefono' => 'nullable|string|max:20',
            'colaboradorPassword' => $this->colaboradorIdEditar ? 'nullable|min:6' : 'required|min:6',
            'colaboradorComision' => 'nullable|numeric|min:0|max:100',
            'colaboradorHorarioInicio' => 'required',
            'colaboradorHorarioFin' => 'required|after:colaboradorHorarioInicio',
            'colaboradorServicios' => 'required|array|min:1',
        ];
    }

    protected function messagesColaborador()
    {
        return [
            'colaboradorNombre.required' => 'El nombre es obligatorio.',
            'colaboradorEmail.required' => 'El correo es obligatorio.',
            'colaboradorEmail.email' => 'Ingresa un correo válido.',
            'colaboradorEmail.unique' => 'Este correo ya está registrado.',
            'colaboradorPassword.required' => 'La contraseña es obligatoria.',
            'colaboradorPassword.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'colaboradorComision.numeric' => 'La comisión debe ser un número.',
            'colaboradorComision.min' => 'La comisión no puede ser negativa.',
            'colaboradorComision.max' => 'La comisión no puede ser mayor a 100%.',
            'colaboradorHorarioFin.after' => 'La hora de fin debe ser después de la hora de inicio.',
            'colaboradorServicios.required' => 'Debes seleccionar al menos un servicio.',
            'colaboradorServicios.min' => 'Debes seleccionar al menos un servicio.',
        ];
    }

    protected function resetFormularioColaborador()
    {
        $this->colaboradorIdEditar = null;
        $this->colaboradorNombre = '';
        $this->colaboradorEmail = '';
        $this->colaboradorTelefono = '';
        $this->colaboradorPassword = '';
        $this->colaboradorComision = '';
        $this->colaboradorHorarioInicio = '09:00';
        $this->colaboradorHorarioFin = '18:00';
        $this->colaboradorActivo = true;
        $this->colaboradorServicios = [];
        $this->resetErrorBag();
    }

    public function cerrarModalColaborador()
    {
        $this->mostrarModalColaborador = false;
        $this->resetFormularioColaborador();
    }

    // ==================== MÉTODOS SERVICIO ====================

    public function abrirCrearServicio()
    {
        if (!$this->puedeCrearServicios) {
            $this->dispatch('error', 'No tienes permiso para crear servicios.');
            return;
        }
        $this->cerrarTodosLosModales();
        $this->resetFormularioServicio();
        $this->servicioIdEditar = null;
        $this->mostrarModalServicio = true;
    }

    public function editarServicio($id)
    {
        if (!$this->puedeCrearServicios) {
            $this->dispatch('error', 'No tienes permiso.');
            return;
        }
        $this->cerrarTodosLosModales();

        $servicio = ServiciosModel::where('empresa_id', $this->empresa->id)->findOrFail($id);

        $this->servicioIdEditar = $servicio->id;
        $this->servicioNombre = $servicio->nombre;
        $this->servicioDuracion = $servicio->duracion_minutos;
        $this->servicioPrecio = $servicio->precio;
        $this->servicioPuntos = $servicio->puntos_genera;
        $this->servicioActivo = (bool) $servicio->activo;

        $this->mostrarModalServicio = true;
    }

    public function guardarServicio()
    {
        $this->validate($this->rulesServicio(), $this->messagesServicio());

        $datos = [
            'empresa_id' => $this->empresa->id,
            'nombre' => $this->servicioNombre,
            'duracion_minutos' => $this->servicioDuracion,
            'precio' => $this->servicioPrecio,
            'puntos_genera' => $this->servicioPuntos ?: 0,
            'activo' => $this->servicioActivo,
        ];

        if ($this->servicioIdEditar) {
            ServiciosModel::where('id', $this->servicioIdEditar)
                ->where('empresa_id', $this->empresa->id)
                ->update($datos);
            $this->dispatch('success', 'Servicio actualizado correctamente.');
        } else {
            ServiciosModel::create($datos);
            $this->dispatch('success', 'Servicio creado correctamente.');
        }

        $this->cerrarModalServicio();
        $this->resetPage();
    }

    public function eliminarServicio($id)
    {
        if (!$this->puedeCrearServicios) {
            $this->dispatch('error', 'No tienes permiso.');
            return;
        }
        $citasAsociadas = CitasModel::where('empresa_id', $this->empresa->id)
            ->where('servicio_id', $id)
            ->count();
        if ($citasAsociadas > 0) {
            $this->dispatch('error', 'No se puede eliminar. El servicio tiene citas asociadas.');
            return;
        }
        ServiciosModel::where('id', $id)
            ->where('empresa_id', $this->empresa->id)
            ->delete();
        $this->dispatch('success', 'Servicio eliminado.');
        $this->resetPage();
    }

    protected function rulesServicio()
    {
        return [
            'servicioNombre' => 'required|string|max:100',
            'servicioDuracion' => 'required|integer|min:5',
            'servicioPrecio' => 'required|numeric|min:0',
            'servicioPuntos' => 'nullable|integer|min:0',
        ];
    }

    protected function messagesServicio()
    {
        return [
            'servicioNombre.required' => 'El nombre del servicio es obligatorio.',
            'servicioDuracion.required' => 'La duración es obligatoria.',
            'servicioDuracion.min' => 'La duración mínima es de 5 minutos.',
            'servicioPrecio.required' => 'El precio es obligatorio.',
            'servicioPrecio.min' => 'El precio no puede ser negativo.',
            'servicioPuntos.min' => 'Los puntos no pueden ser negativos.',
        ];
    }

    protected function resetFormularioServicio()
    {
        $this->servicioIdEditar = null;
        $this->servicioNombre = '';
        $this->servicioDuracion = 30;
        $this->servicioPrecio = '';
        $this->servicioPuntos = 10;
        $this->servicioActivo = true;
        $this->resetErrorBag();
    }

    public function cerrarModalServicio()
    {
        $this->mostrarModalServicio = false;
        $this->resetFormularioServicio();
    }

    // ==================== MÉTODOS PAGO ====================

    public function abrirModalPago($id)
    {
        if (!$this->puedeGestionar) {
            $this->dispatch('error', 'No tienes permiso.');
            return;
        }

        $cita = CitasModel::where('empresa_id', $this->empresa->id)
            ->with(['cliente', 'servicio'])
            ->find($id);

        if (!$cita) {
            $this->dispatch('error', 'Cita no encontrada.');
            return;
        }

        if ($cita->pagado) {
            $this->dispatch('error', 'Esta cita ya está pagada.');
            return;
        }

        if (!in_array($cita->estado, ['agendada', 'confirmada', 'en_curso', 'atendida'])) {
            $this->dispatch('error', 'Esta cita no se puede cobrar en su estado actual.');
            return;
        }

        $this->citaPagoId = $cita->id;
        $this->citaPago = $cita;
        $this->montoPago = $cita->monto_pagado ?? $cita->servicio?->precio ?? 0;
        $this->metodoPagoSeleccionado = '';
        $this->referenciaPago = '';
        $this->mostrarModalPago = true;
    }

    public function cerrarModalPago()
    {
        $this->mostrarModalPago = false;
        $this->citaPagoId = null;
        $this->citaPago = null;
        $this->montoPago = '';
        $this->metodoPagoSeleccionado = '';
        $this->referenciaPago = '';
        $this->resetErrorBag();
    }

    public function procesarPago()
    {
        $this->validate([
            'montoPago' => 'required|numeric|min:0.01',
            'metodoPagoSeleccionado' => 'required|in:efectivo,transferencia,tarjeta',
            'referenciaPago' => 'nullable|string|max:100',
        ]);

        try {
            DB::beginTransaction();

            $cita = CitasModel::where('empresa_id', $this->empresa->id)
                ->where('id', $this->citaPagoId)
                ->first();

            if (!$cita) {
                throw new \Exception('La cita no existe.');
            }

            if ($cita->pagado) {
                throw new \Exception('Esta cita ya está pagada.');
            }

            $cita->pagado = 1;
            $cita->monto_pagado = $this->montoPago;
            $cita->metodo_pago = $this->metodoPagoSeleccionado;
            $cita->fecha_pago = now();
            $cita->cobrado_por = Auth::id();

            if ($this->referenciaPago) {
                $cita->observaciones = ($cita->observaciones ? $cita->observaciones . "\n" : '')
                    . 'Pago ' . $this->metodoPagoSeleccionado . ' - Ref: ' . $this->referenciaPago;
            }

            $cita->save();

            if ($cita->colaborador_id && $cita->monto_pagado) {
                $colaborador = User::find($cita->colaborador_id);
                if ($colaborador && $colaborador->comision_porcentaje) {
                    $montoComision = $cita->monto_pagado * ($colaborador->comision_porcentaje / 100);
                    ComisionesModel::updateOrCreate(
                        ['cita_id' => $cita->id],
                        [
                            'empresa_id' => $cita->empresa_id,
                            'colaborador_id' => $cita->colaborador_id,
                            'monto' => $montoComision,
                            'estatus' => 'pendiente',
                        ]
                    );
                }
            }

            DB::commit();

            $this->cerrarModalPago();
            $this->resetPage();
            session()->flash('success', '✅ Pago completado: $' . number_format((float) $this->montoPago, 2));

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', '❌ Error al procesar el pago: ' . $e->getMessage());
        }
    }

    // ==================== CHECK IN / CHECK OUT ====================

    public function checkIn($id)
    {
        $cita = CitasModel::where('empresa_id', $this->empresa->id)->findOrFail($id);
        if ($this->esColaborador && $cita->colaborador_id !== $this->usuarioId) {
            $this->dispatch('error', 'No puedes modificar esta cita.');
            return;
        }
        if (!in_array($cita->estado, ['agendada', 'confirmada'])) {
            $this->dispatch('error', 'Esta cita no puede iniciar.');
            return;
        }
        $cita->estado = 'en_curso';
        $cita->checkin_time = now();
        $cita->save();
        $this->dispatch('success', 'Check-in realizado. Cliente en atención.');
        $this->resetPage();
    }

    public function checkOut($id)
    {
        $cita = CitasModel::where('empresa_id', $this->empresa->id)->findOrFail($id);
        if ($this->esColaborador && $cita->colaborador_id !== $this->usuarioId) {
            $this->dispatch('error', 'No puedes modificar esta cita.');
            return;
        }
        if ($cita->estado !== 'en_curso') {
            $this->dispatch('error', 'La cita debe estar en curso para finalizar.');
            return;
        }
        $cita->estado = 'atendida';
        $cita->checkout_time = now();
        $cita->save();
        $this->dispatch('success', 'Check-out realizado. Cita finalizada.');
        $this->resetPage();
    }

    // ==================== CANCELAR CITA (para colaborador) ====================

    public function cancelarCita($id)
    {
        $cita = CitasModel::where('empresa_id', $this->empresa->id)->findOrFail($id);
        $usuario = Auth::guard('web')->user();
        $rol = $usuario->rol;

        // Validar que la cita esté en estado cancelable
        if (!in_array($cita->estado, ['agendada', 'confirmada'])) {
            $this->dispatch('error', 'Esta cita ya no se puede cancelar.');
            return;
        }

        // Si es colaborador, verificar que la cita sea suya
        if ($rol === 'colaborador' && $cita->colaborador_id !== $usuario->id) {
            $this->dispatch('error', 'No puedes cancelar una cita que no es tuya.');
            return;
        }

        // Verificar regla de 24 horas
        if (!$cita->puedeCancelar($rol)) {
            $this->dispatch('error', 'No se puede cancelar. Solo se permite 24 horas antes de la cita.');
            return;
        }

        try {
            DB::beginTransaction();
            $motivo = "Cancelado por " . ucfirst($rol);
            $cita->cancelar($motivo, $rol);
            DB::commit();
            $this->dispatch('success', 'Cita cancelada correctamente.');
            $this->resetPage();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('error', 'Error al cancelar: ' . $e->getMessage());
        }
    }

    // ==================== FILTROS ====================

    public function limpiarFiltros()
    {
        $this->filtroFecha = '';
        $this->filtroEstado = '';
        $this->filtroColaborador = '';
        $this->buscarCliente = '';
        $this->resetPage();
    }

    // ==================== RENDER ====================

    public function render()
    {
        return view('livewire.admin.gestion-citas', [
            'citasHoy' => $this->citasHoyCount,
            'ingresosHoy' => $this->ingresosHoyTotal,
            'efectivoHoy' => $this->efectivoHoy,
            'citas' => $this->citasList,
            'clientes' => $this->clientesList,
            'servicios' => $this->serviciosList,
            'serviciosAll' => $this->serviciosAll,
            'colaboradores' => $this->colaboradoresList,
            'esAdmin' => $this->esAdmin,
            'esRecepcionista' => $this->esRecepcionista,
            'esColaborador' => $this->esColaborador,
            'puedeGestionar' => $this->puedeGestionar,
            'puedeCrearColaboradores' => $this->puedeCrearColaboradores,
            'puedeCrearServicios' => $this->puedeCrearServicios,
            'totalCitasColaborador' => $this->totalCitasColaborador,
            'citasPendientesColaborador' => $this->citasPendientesColaborador,
            'ingresoColaborador' => $this->ingresoColaborador,
        ]);
    }
}