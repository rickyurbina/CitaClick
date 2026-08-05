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
    public $pagado = false;

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
    public $colaboradorServicios = [];  // 👈 NUEVO: Array de IDs de servicios seleccionados

    // ==================== FORMULARIO SERVICIO ====================
    public $servicioIdEditar = null;
    public $servicioNombre = '';
    public $servicioDuracion = 30;
    public $servicioPrecio = '';
    public $servicioPuntos = 10;
    public $servicioActivo = true;

    // ==================== FILTROS ====================
    public $filtroFecha = '';
    public $filtroEstado = '';
    public $filtroColaborador = '';
    public $buscarCliente = '';

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
            ->whereDate('fecha', Carbon::today())
            ->where('pagado', 1)
            ->sum('monto_pagado');
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

        if ($this->filtroColaborador) {
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

    // ==================== MÉTODOS PARA CERRAR MODALES ====================
    public function cerrarTodosLosModales()
    {
        $this->mostrarModalCita = false;
        $this->mostrarModalColaborador = false;
        $this->mostrarModalServicio = false;
    }

    // ==================== MÉTODOS CITA ====================
    public function updatedServicioId($value)
    {
        if ($value) {
            $servicio = ServiciosModel::find($value);
            if ($servicio) {
                $this->montoPagado = $servicio->precio;
            }
        }
    }

    public function updatedClienteId($value)
    {
        if ($value) {
            $cliente = ClientesModel::find($value);
            if ($cliente && $cliente->bloqueado_hasta && $cliente->bloqueado_hasta >= today()) {
                $this->addError('clienteId', 'Cliente bloqueado hasta ' . $cliente->bloqueado_hasta->format('d/m/Y'));
            }
        }
    }

    public function abrirCrearCita()
    {
        if (!$this->puedeGestionar) {
            $this->dispatch('error', 'No tienes permiso.');
            return;
        }

        $this->cerrarTodosLosModales();
        $this->resetFormularioCita();
        $this->citaIdEditar = null;
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
        $this->pagado = (bool) $cita->pagado;

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
            'pagado' => $this->pagado,
        ];

        if ($this->pagado && !$this->citaIdEditar) {
            $datos['fecha_pago'] = now();
            if (Auth::check()) {
                $datos['cobrado_por'] = Auth::id();
            }
        }

        if ($this->citaIdEditar) {
            CitasModel::where('id', $this->citaIdEditar)
                ->where('empresa_id', $this->empresa->id)
                ->update($datos);

            $cita = CitasModel::find($this->citaIdEditar);
            
            if ($this->pagado) {
                $this->generarComision($cita);
            }

            $this->dispatch('success', 'Cita actualizada correctamente.');
        } else {
            $cita = CitasModel::create($datos);
            
            if ($this->pagado) {
                $this->generarComision($cita);
            }

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

        if ($nuevoEstado === 'atendida' && $cita->pagado) {
            $this->generarComision($cita);
        }

        $cita->save();
        $this->dispatch('success', 'Estado actualizado a "' . ucfirst($nuevoEstado) . '"');
    }

    protected function generarComision($cita)
    {
        if (!$cita->pagado || !$cita->colaborador_id || !$cita->monto_pagado) {
            return;
        }

        $colaborador = User::find($cita->colaborador_id);
        if (!$colaborador || !$colaborador->comision_porcentaje) {
            return;
        }

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
        $this->pagado = false;
        $this->citaIdEditar = null;
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
        $this->colaboradorServicios = [];  // 👈 Resetear servicios seleccionados
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
            ->with('servicios')  // 👈 Cargar los servicios
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
        
        // 👈 Obtener los IDs de los servicios del colaborador
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
            // Actualizar colaborador
            $colaborador = User::where('id', $this->colaboradorIdEditar)
                ->where('empresa_id', $this->empresa->id)
                ->first();
            
            if ($colaborador) {
                $colaborador->update($datos);
                
                // 👈 Sincronizar servicios (relación muchos a muchos)
                $colaborador->servicios()->sync($this->colaboradorServicios);
                
                $this->dispatch('success', 'Colaborador actualizado correctamente.');
            }
        } else {
            // Crear colaborador
            if (empty($datos['password'])) {
                $datos['password'] = Hash::make($this->colaboradorEmail);
            }
            
            $colaborador = User::create($datos);
            
            // 👈 Asignar servicios al nuevo colaborador
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
            // 👈 Eliminar relaciones con servicios
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
            'colaboradorServicios' => 'required|array|min:1',  // 👈 Validación: al menos un servicio
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
        $this->colaboradorServicios = [];  // 👈 Resetear servicios
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
            'citas' => $this->citasList,
            'clientes' => $this->clientesList,
            'servicios' => $this->serviciosList,
            'serviciosAll' => $this->serviciosAll,  // 👈 Todos los servicios para seleccionar
            'colaboradores' => $this->colaboradoresList,
            'esAdmin' => $this->esAdmin,
            'esRecepcionista' => $this->esRecepcionista,
            'esColaborador' => $this->esColaborador,
            'puedeGestionar' => $this->puedeGestionar,
            'puedeCrearColaboradores' => $this->puedeCrearColaboradores,
            'puedeCrearServicios' => $this->puedeCrearServicios,
        ]);
    }
}