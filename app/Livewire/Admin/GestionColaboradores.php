<?php

namespace App\Livewire\Admin;

use App\Models\EmpresasModel;
use App\Models\User;
use App\Models\ServiciosModel;
use App\Models\ColaboradorHorario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

    // Modal
    public $mostrarModal = false;

    // Formulario
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

    // NUEVO: horario semanal
    public $diasHorario = [];

    public $cargando = false;

    // Filtros
    public $filtroBuscar = '';
    public $filtroActivo = '';

    protected $listeners = [
        'cambiar-seccion' => 'resetearEstado',
    ];

    // Días disponibles
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
            $query->where(function($q) {
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
            // Validación de días: cada día debe tener inicio y fin si está activo
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
            $this->dispatch('mostrar-mensaje', mensaje: 'No tienes permiso.', tipo: 'error');
            return;
        }
        $this->resetFormulario();
        $this->colaboradorIdEditar = null;
        // Inicializar días con valores por defecto (todos activos con horario 09:00 - 18:00)
        $this->inicializarDiasHorario();
        $this->mostrarModal = true;
    }

    public function abrirEditar($id)
    {
        if (!$this->esAdmin) {
            $this->dispatch('mostrar-mensaje', mensaje: 'No tienes permiso.', tipo: 'error');
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

        // Cargar horario
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
                    $this->eliminarFoto($this->fotoExistente);
                }
                $datos['foto_url'] = $this->guardarFoto($this->fotoFile);
            } elseif ($this->colaboradorIdEditar) {
                $datos['foto_url'] = $this->fotoExistente;
            }

            if ($this->colaboradorIdEditar) {
                $colaborador = User::where('id', $this->colaboradorIdEditar)
                    ->where('empresa_id', $this->empresa->id)
                    ->first();
                if ($colaborador) {
                    $colaborador->update($datos);
                    $colaborador->servicios()->sync($this->serviciosSeleccionados);
                    // Guardar horario
                    $this->guardarHorario($colaborador);
                    $mensaje = 'Colaborador actualizado correctamente.';
                }
            } else {
                if (empty($datos['password'])) {
                    $datos['password'] = Hash::make($this->email);
                }
                $colaborador = User::create($datos);
                $colaborador->servicios()->attach($this->serviciosSeleccionados);
                $this->guardarHorario($colaborador);
                $mensaje = 'Colaborador creado correctamente.';
            }

            DB::commit();
            $this->dispatch('mostrar-mensaje', mensaje: $mensaje, tipo: 'success');
            $this->cerrarModal();
            $this->resetPage();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('mostrar-mensaje', mensaje: 'Ocurrió un error: ' . $e->getMessage(), tipo: 'error');
        }
        $this->cargando = false;
    }

    private function guardarHorario(User $colaborador)
    {
        // Construir array de configuración
        $config = [];
        foreach ($this->diasSemana as $dia) {
            $data = $this->diasHorario[$dia] ?? ['activo' => false, 'inicio' => '09:00', 'fin' => '18:00'];
            $config[$dia] = [
                'activo' => (bool) ($data['activo'] ?? false),
                'inicio' => $data['inicio'] ?? '09:00',
                'fin'    => $data['fin'] ?? '18:00',
            ];
        }

        // Actualizar o crear el registro
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
            $this->dispatch('mostrar-mensaje', mensaje: 'No tienes permiso.', tipo: 'error');
            return;
        }
        try {
            $citasPendientes = \App\Models\CitasModel::where('empresa_id', $this->empresa->id)
                ->where('colaborador_id', $id)
                ->whereIn('estado', ['agendada', 'confirmada', 'en_curso'])
                ->count();
            if ($citasPendientes > 0) {
                $this->dispatch('mostrar-mensaje', mensaje: 'No se puede eliminar. El colaborador tiene citas pendientes.', tipo: 'error');
                return;
            }
            DB::beginTransaction();
            $colaborador = User::where('id', $id)
                ->where('empresa_id', $this->empresa->id)
                ->where('rol', 'colaborador')
                ->first();
            if ($colaborador) {
                // Eliminar horario si existe
                if ($colaborador->horario) {
                    $colaborador->horario->delete();
                }
                $this->eliminarFoto($colaborador->getRawOriginal('foto_url'));
                $colaborador->servicios()->detach();
                $colaborador->delete();
            }
            DB::commit();
            $this->dispatch('mostrar-mensaje', mensaje: 'Colaborador eliminado correctamente.', tipo: 'success');
            $this->resetPage();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('mostrar-mensaje', mensaje: 'Ocurrió un error al eliminar el colaborador.', tipo: 'error');
        }
    }

    public function toggleActivo($id)
    {
        if (!$this->esAdmin) {
            $this->dispatch('mostrar-mensaje', mensaje: 'No tienes permiso.', tipo: 'error');
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
                $this->dispatch('mostrar-mensaje', mensaje: 'Estado actualizado correctamente.', tipo: 'success');
            }
        } catch (\Exception $e) {
            $this->dispatch('mostrar-mensaje', mensaje: 'Ocurrió un error al cambiar el estado.', tipo: 'error');
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
        ]);
    }
}