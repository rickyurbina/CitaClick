<?php

namespace App\Livewire\Admin;

use App\Models\EmpresasModel;
use App\Models\User;
use App\Models\ServiciosModel;
use App\Models\ColaboradorHorario;
use App\Models\CitasModel;
use App\Models\ComisionesModel;
use App\Models\AuditoriaCitasModel;
use App\Models\RedencionesPromocionModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class GestionColaboradores extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'tailwind';

    public EmpresasModel $empresa;

    public $mensaje = null;
    public $tipoMensaje = 'info';

    public $mostrarModal = false;

    public $mostrarModalEliminar = false;
    public $eliminarId = null;
    public $eliminarDetalles = [];

    public $colaboradorIdEditar = null;
    public $nombre = '';
    public $email = '';
    public $telefono = '';
    public $password = '';
    public $comision = '';
    public $activo = true;
    public $serviciosSeleccionados = [];
    public $fotoFile = null;
    public $fotoExistente = null;

    public $diasHorario = [];

    public $cargando = false;

    public $filtroBuscar = '';
    public $filtroActivo = '';

    protected $listeners = [
        'cambiar-seccion' => 'resetearEstado',
    ];

    private $diasSemana = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];

    public function resetearEstado()
    {
        $this->resetPage();
    }

    public function getEsAdminProperty()
    {
        return in_array(Auth::guard('web')->user()->rol, ['empresa_admin', 'super_admin']);
    }

    public function getColaboradoresProperty()
    {
        $query = User::where('empresa_id', $this->empresa->id)
            ->where('rol', 'colaborador');

        if ($this->filtroBuscar) {
            $query->where(function ($q) {
                $q->where('nombre', 'like', '%' . $this->filtroBuscar . '%')
                  ->orWhere('email', 'like', '%' . $this->filtroBuscar . '%')
                  ->orWhere('telefono', 'like', '%' . $this->filtroBuscar . '%');
            });
        }

        if ($this->filtroActivo !== '') {
            $query->where('activo', $this->filtroActivo);
        }

        return $query->orderBy('nombre')->paginate(10);
    }

    public function getServiciosDisponiblesProperty()
    {
        return ServiciosModel::where('empresa_id', $this->empresa->id)
            ->where('activo', 1)
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'precio']);
    }

    public function getTotalColaboradoresProperty()
    {
        return User::where('empresa_id', $this->empresa->id)
            ->where('rol', 'colaborador')
            ->count();
    }

    public function getColaboradoresActivosProperty()
    {
        return User::where('empresa_id', $this->empresa->id)
            ->where('rol', 'colaborador')
            ->where('activo', 1)
            ->count();
    }

    public function getFotoPreviewUrlProperty(): ?string
    {
        if ($this->fotoFile) {
            try {
                return $this->fotoFile->temporaryUrl();
            } catch (\Throwable $e) {
                return null;
            }
        }

        return \App\Support\StorageHelper::url($this->fotoExistente);
    }

    protected function rules()
    {
        $uniqueRule = $this->colaboradorIdEditar
            ? 'unique:users,email,' . $this->colaboradorIdEditar
            : 'unique:users,email';

        return [
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|max:150|' . $uniqueRule,
            'telefono' => 'nullable|string|max:20',
            'password' => $this->colaboradorIdEditar ? 'nullable|min:6' : 'required|min:6',
            'comision' => 'nullable|numeric|min:0|max:100',
            'activo' => 'boolean',
            'serviciosSeleccionados' => 'required|array|min:1',
            'fotoFile' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif,svg,webp',
            'diasHorario.*.activo' => 'boolean',
            'diasHorario.*.inicio' => 'nullable|required_if:diasHorario.*.activo,true|date_format:H:i',
            'diasHorario.*.fin' => 'nullable|required_if:diasHorario.*.activo,true|date_format:H:i|after:diasHorario.*.inicio',
        ];
    }

    protected function messages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Ingresa un email válido.',
            'email.unique' => 'Este email ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'comision.numeric' => 'La comisión debe ser un número.',
            'comision.min' => 'La comisión no puede ser negativa.',
            'comision.max' => 'La comisión no puede ser mayor a 100%.',
            'serviciosSeleccionados.required' => 'Debes seleccionar al menos un servicio.',
            'serviciosSeleccionados.min' => 'Debes seleccionar al menos un servicio.',
            'fotoFile.image' => 'El archivo debe ser una imagen.',
            'fotoFile.max' => 'La imagen no puede pesar más de 2MB.',
            'fotoFile.mimes' => 'La imagen debe ser jpeg, png, jpg, gif, svg o webp.',
            'diasHorario.*.inicio.required_if' => 'La hora de inicio es obligatoria para los días activos.',
            'diasHorario.*.fin.required_if' => 'La hora de fin es obligatoria para los días activos.',
            'diasHorario.*.fin.after' => 'La hora de fin debe ser posterior a la hora de inicio.',
        ];
    }

    public function abrirCrear()
    {
        if (!$this->esAdmin) {
            $this->mensaje = 'No tienes permiso.';
            $this->tipoMensaje = 'error';
            return;
        }
        $this->resetFormulario();
        $this->colaboradorIdEditar = null;
        $this->inicializarDiasHorario();
        $this->mostrarModal = true;
    }

    public function abrirEditar($id)
    {
        if (!$this->esAdmin) {
            $this->mensaje = 'No tienes permiso.';
            $this->tipoMensaje = 'error';
            return;
        }

        $colaborador = User::where('empresa_id', $this->empresa->id)
            ->where('rol', 'colaborador')
            ->with('servicios', 'horario')
            ->findOrFail($id);

        $this->colaboradorIdEditar = $colaborador->id;
        $this->nombre = $colaborador->nombre;
        $this->email = $colaborador->email;
        $this->telefono = $colaborador->telefono;
        $this->comision = $colaborador->comision_porcentaje;
        $this->activo = (bool) $colaborador->activo;
        $this->password = '';
        $this->serviciosSeleccionados = $colaborador->servicios->pluck('id')->toArray();
        $this->fotoExistente = $colaborador->getRawOriginal('foto_url');
        $this->fotoFile = null;

        $this->inicializarDiasHorario();
        if ($colaborador->horario) {
            $config = $colaborador->horario->configuracion;
            foreach ($this->diasSemana as $dia) {
                if (isset($config[$dia])) {
                    $this->diasHorario[$dia] = [
                        'activo' => $config[$dia]['activo'] ?? false,
                        'inicio' => $config[$dia]['inicio'] ?? '09:00',
                        'fin'    => $config[$dia]['fin'] ?? '18:00',
                    ];
                }
            }
        }

        $this->mostrarModal = true;
    }

    public function guardar()
    {
        $this->validate();
        $this->cargando = true;

        try {
            DB::beginTransaction();

            $datos = [
                'empresa_id' => $this->empresa->id,
                'nombre' => $this->nombre,
                'email' => $this->email,
                'telefono' => $this->telefono,
                'rol' => 'colaborador',
                'comision_porcentaje' => $this->comision ?: null,
                'activo' => $this->activo,
            ];

            if ($this->password) {
                $datos['password'] = Hash::make($this->password);
            }

            if ($this->fotoFile) {
                if ($this->fotoExistente) {
                    $this->eliminarFoto(\App\Support\StorageHelper::path($this->fotoExistente));
                }
                $datos['foto_url'] = $this->guardarFoto($this->fotoFile);
            } elseif ($this->colaboradorIdEditar) {
                $datos['foto_url'] = \App\Support\StorageHelper::path($this->fotoExistente);
            }

            if ($this->colaboradorIdEditar) {
                $colaborador = User::where('id', $this->colaboradorIdEditar)
                    ->where('empresa_id', $this->empresa->id)
                    ->first();
                if ($colaborador) {
                    $colaborador->update($datos);
                    $colaborador->servicios()->sync($this->serviciosSeleccionados);
                    $this->guardarHorario($colaborador);
                    $this->mensaje = 'Colaborador actualizado correctamente.';
                    $this->tipoMensaje = 'success';
                }
            } else {
                if (empty($datos['password'])) {
                    $datos['password'] = Hash::make($this->email);
                }
                $colaborador = User::create($datos);
                $colaborador->servicios()->attach($this->serviciosSeleccionados);
                $this->guardarHorario($colaborador);
                $this->mensaje = 'Colaborador creado correctamente.';
                $this->tipoMensaje = 'success';
            }

            DB::commit();
            $this->cerrarModal();
            $this->resetPage();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al guardar colaborador', ['error' => $e->getMessage()]);
            $this->mensaje = 'Ocurrió un error: ' . $e->getMessage();
            $this->tipoMensaje = 'error';
        }
        $this->cargando = false;
    }

    private function guardarHorario(User $colaborador)
    {
        $config = [];
        foreach ($this->diasSemana as $dia) {
            $data = $this->diasHorario[$dia] ?? ['activo' => false, 'inicio' => '09:00', 'fin' => '18:00'];
            $config[$dia] = [
                'activo' => (bool) ($data['activo'] ?? false),
                'inicio' => $data['inicio'] ?? '09:00',
                'fin'    => $data['fin'] ?? '18:00',
            ];
        }

        $horario = $colaborador->horario;
        if ($horario) {
            $horario->configuracion = $config;
            $horario->save();
        } else {
            ColaboradorHorario::create([
                'colaborador_id' => $colaborador->id,
                'configuracion' => $config,
            ]);
        }
    }

    private function inicializarDiasHorario()
    {
        $this->diasHorario = [];
        foreach ($this->diasSemana as $dia) {
            $this->diasHorario[$dia] = [
                'activo' => true,
                'inicio' => '09:00',
                'fin' => '18:00',
            ];
        }
    }

    public function eliminar($id)
    {
        if (!$this->esAdmin) {
            $this->mensaje = 'No tienes permiso.';
            $this->tipoMensaje = 'error';
            return;
        }

        $colaborador = User::where('empresa_id', $this->empresa->id)
            ->where('rol', 'colaborador')
            ->find($id);

        if (!$colaborador) {
            $this->mensaje = 'Colaborador no encontrado.';
            $this->tipoMensaje = 'error';
            return;
        }

        $citaIds = CitasModel::where('colaborador_id', $colaborador->id)->pluck('id');

        $this->eliminarId = $colaborador->id;
        $this->eliminarDetalles = [
            'nombre'         => $colaborador->nombre,
            'email'          => $colaborador->email,
            'citas'          => $citaIds->count(),
            'citas_cobradas' => CitasModel::where('cobrado_por', $colaborador->id)->count(),
            'comisiones'     => ComisionesModel::where('colaborador_id', $colaborador->id)->count(),
            'auditorias'     => AuditoriaCitasModel::where('usuario_id', $colaborador->id)->count(),
            'redenciones'    => $citaIds->isNotEmpty()
                                    ? RedencionesPromocionModel::whereIn('cita_id', $citaIds)->count()
                                    : 0,
            'horario'        => $colaborador->horario ? 1 : 0,
            'servicios'      => $colaborador->servicios()->count(),
            'tiene_foto'     => $colaborador->getRawOriginal('foto_url') ? 1 : 0,
        ];

        $this->mostrarModalEliminar = true;
    }

    public function cancelarEliminacion()
    {
        $this->mostrarModalEliminar = false;
        $this->eliminarId = null;
        $this->eliminarDetalles = [];
    }

    public function ejecutarEliminacion()
    {
        if (!$this->esAdmin) {
            $this->mensaje = 'No tienes permiso.';
            $this->tipoMensaje = 'error';
            return;
        }

        if (!$this->eliminarId) {
            $this->mensaje = 'No hay colaborador seleccionado.';
            $this->tipoMensaje = 'error';
            return;
        }

        try {
            DB::beginTransaction();

            $colaborador = User::where('id', $this->eliminarId)
                ->where('empresa_id', $this->empresa->id)
                ->where('rol', 'colaborador')
                ->first();

            if (!$colaborador) {
                throw new \Exception('Colaborador no encontrado.');
            }

            $citaIds = CitasModel::where('colaborador_id', $colaborador->id)->pluck('id');

            if ($citaIds->isNotEmpty()) {
                RedencionesPromocionModel::whereIn('cita_id', $citaIds)->delete();
            }

            if ($citaIds->isNotEmpty()) {
                AuditoriaCitasModel::whereIn('cita_id', $citaIds)->delete();
            }

            AuditoriaCitasModel::where('usuario_id', $colaborador->id)->delete();

            if ($citaIds->isNotEmpty()) {
                ComisionesModel::whereIn('cita_id', $citaIds)->delete();
            }

            ComisionesModel::where('colaborador_id', $colaborador->id)->delete();

            CitasModel::where('cobrado_por', $colaborador->id)
                ->update(['cobrado_por' => null]);

            CitasModel::where('colaborador_id', $colaborador->id)->delete();

            if ($colaborador->horario) {
                $colaborador->horario->delete();
            }

            $this->eliminarFoto(\App\Support\StorageHelper::path($colaborador->getRawOriginal('foto_url')));

            $colaborador->servicios()->detach();

            $colaborador->delete();

            DB::commit();

            $this->mensaje = "Colaborador \"{$colaborador->nombre}\" eliminado junto con todos sus registros relacionados.";
            $this->tipoMensaje = 'success';
            $this->cancelarEliminacion();
            $this->resetPage();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar colaborador', [
                'id' => $this->eliminarId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->mensaje = 'Error al eliminar: ' . $e->getMessage();
            $this->tipoMensaje = 'error';
        }
    }

    public function toggleActivo($id)
    {
        if (!$this->esAdmin) {
            $this->mensaje = 'No tienes permiso.';
            $this->tipoMensaje = 'error';
            return;
        }
        try {
            $colaborador = User::where('id', $id)
                ->where('empresa_id', $this->empresa->id)
                ->where('rol', 'colaborador')
                ->first();
            if ($colaborador) {
                $colaborador->activo = !$colaborador->activo;
                $colaborador->save();
                $this->mensaje = 'Estado actualizado correctamente.';
                $this->tipoMensaje = 'success';
            }
        } catch (\Exception $e) {
            $this->mensaje = 'Ocurrió un error al cambiar el estado.';
            $this->tipoMensaje = 'error';
        }
    }

    public function resetFormulario()
    {
        $this->colaboradorIdEditar = null;
        $this->nombre = '';
        $this->email = '';
        $this->telefono = '';
        $this->password = '';
        $this->comision = '';
        $this->activo = true;
        $this->serviciosSeleccionados = [];
        $this->fotoFile = null;
        $this->fotoExistente = null;
        $this->diasHorario = [];
        $this->resetErrorBag();
    }

    protected function guardarFoto($file): string
    {
        $nombre = Str::slug($this->nombre) . '-' . time() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('colaboradores', $nombre, 'public');
    }

    protected function eliminarFoto(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
        $this->resetFormulario();
    }

    public function limpiarFiltros()
    {
        $this->filtroBuscar = '';
        $this->filtroActivo = '';
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.gestion-colaboradores', [
            'colaboradores' => $this->colaboradores,
            'totalColaboradores' => $this->totalColaboradores,
            'colaboradoresActivos' => $this->colaboradoresActivos,
            'serviciosDisponibles' => $this->serviciosDisponibles,
            'esAdmin' => $this->esAdmin,
            'fotoPreviewUrl' => $this->fotoPreviewUrl,
        ]);
    }
}