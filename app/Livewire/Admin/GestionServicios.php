<?php

namespace App\Livewire\Admin;

use App\Models\EmpresasModel;
use App\Models\ServiciosModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class GestionServicios extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'tailwind';

    public EmpresasModel $empresa;

    public $mostrarModal = false;

    public $servicioIdEditar = null;
    public $nombre = '';
    public $duracion = 30;
    public $precio = '';
    public $puntos = 10;
    public $activo = true;
    public $imagenFile = null;
    public $imagenExistente = null;

    public $cargando = false;
    public $mensaje = null;
    public $tipoMensaje = 'info';

    public $filtroBuscar = '';
    public $filtroActivo = '';

    protected $listeners = [
        'cambiar-seccion' => 'resetearEstado',
    ];

    public function resetearEstado()
    {
        $this->resetPage();
    }

    public function getEsAdminProperty()
    {
        return in_array(Auth::guard('web')->user()->rol, ['empresa_admin', 'super_admin']);
    }

    public function getServiciosProperty()
    {
        $query = ServiciosModel::where('empresa_id', $this->empresa->id);

        if ($this->filtroBuscar) {
            $query->where('nombre', 'like', '%' . $this->filtroBuscar . '%');
        }

        if ($this->filtroActivo !== '') {
            $query->where('activo', $this->filtroActivo);
        }

        return $query->orderBy('nombre')->paginate(10);
    }

    public function getTotalServiciosProperty()
    {
        return ServiciosModel::where('empresa_id', $this->empresa->id)->count();
    }

    public function getServiciosActivosProperty()
    {
        return ServiciosModel::where('empresa_id', $this->empresa->id)
            ->where('activo', 1)
            ->count();
    }

    public function getImagenPreviewUrlProperty(): ?string
    {
        if ($this->imagenFile) {
            try {
                return $this->imagenFile->temporaryUrl();
            } catch (\Throwable $e) {
                return null;
            }
        }

        if ($this->imagenExistente) {
            $path = ltrim(str_replace('\\', '/', $this->imagenExistente), '/');
            if (str_starts_with($path, 'storage/')) {
                $path = substr($path, 8);
            }

            return asset('storage/' . $path);
        }

        return null;
    }

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:100',
            'duracion' => 'required|integer|min:5',
            'precio' => 'required|numeric|min:0',
            'puntos' => 'nullable|integer|min:0',
            'activo' => 'boolean',
            'imagenFile' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif,svg,webp',
        ];
    }

    protected function messages()
    {
        return [
            'nombre.required' => 'El nombre del servicio es obligatorio.',
            'duracion.required' => 'La duración es obligatoria.',
            'duracion.min' => 'La duración mínima es de 5 minutos.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.min' => 'El precio no puede ser negativo.',
            'puntos.min' => 'Los puntos no pueden ser negativos.',
            'imagenFile.image' => 'El archivo debe ser una imagen.',
            'imagenFile.max' => 'La imagen no puede pesar más de 2MB.',
            'imagenFile.mimes' => 'La imagen debe ser jpeg, png, jpg, gif, svg o webp.',
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
        $this->servicioIdEditar = null;
        $this->mensaje = null;
        $this->mostrarModal = true;
    }

    public function abrirEditar($id)
    {
        if (!$this->esAdmin) {
            $this->mensaje = 'No tienes permiso.';
            $this->tipoMensaje = 'error';
            return;
        }
        $servicio = ServiciosModel::where('empresa_id', $this->empresa->id)->findOrFail($id);
        $this->servicioIdEditar = $servicio->id;
        $this->nombre = $servicio->nombre;
        $this->duracion = $servicio->duracion_minutos;
        $this->precio = $servicio->precio;
        $this->puntos = $servicio->puntos_genera;
        $this->activo = (bool) $servicio->activo;
        $this->imagenExistente = Schema::hasColumn('servicios', 'imagen_url')
            ? $servicio->getRawOriginal('imagen_url')
            : null;
        $this->imagenFile = null;
        $this->mensaje = null;
        $this->mostrarModal = true;
    }

    public function guardar()
    {
        $this->validate();
        $this->cargando = true;
        $this->mensaje = null;

        try {
            DB::beginTransaction();
            $datos = [
                'empresa_id' => $this->empresa->id,
                'nombre' => $this->nombre,
                'duracion_minutos' => $this->duracion,
                'precio' => $this->precio,
                'puntos_genera' => $this->puntos !== '' && $this->puntos !== null ? (int) $this->puntos : 0,
                'activo' => (bool) $this->activo,
            ];

            if (Schema::hasColumn('servicios', 'imagen_url')) {
                if ($this->imagenFile) {
                    if ($this->imagenExistente) {
                        $this->eliminarImagen($this->imagenExistente);
                    }
                    $datos['imagen_url'] = $this->guardarImagen($this->imagenFile);
                } else {
                    $datos['imagen_url'] = $this->imagenExistente;
                }
            }

            if ($this->servicioIdEditar) {
                ServiciosModel::where('id', $this->servicioIdEditar)
                    ->where('empresa_id', $this->empresa->id)
                    ->update($datos);
                $mensaje = 'Servicio actualizado correctamente.';
            } else {
                ServiciosModel::create($datos);
                $mensaje = 'Servicio creado correctamente.';
            }
            DB::commit();
            $this->cerrarModal();
            $this->mensaje = $mensaje;
            $this->tipoMensaje = 'success';
            $this->resetPage();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->mensaje = 'Ocurrió un error: ' . $e->getMessage();
            $this->tipoMensaje = 'error';
        }
        $this->cargando = false;
    }

    public function eliminar($id)
    {
        if (!$this->esAdmin) {
            $this->mensaje = 'No tienes permiso.';
            $this->tipoMensaje = 'error';
            return;
        }
        try {
            $tieneCitas = \App\Models\CitasModel::where('empresa_id', $this->empresa->id)
                ->where('servicio_id', $id)
                ->exists();
            if ($tieneCitas) {
                $this->mensaje = 'No se puede eliminar. El servicio tiene citas asociadas.';
                $this->tipoMensaje = 'error';
                return;
            }
            DB::beginTransaction();
            $servicio = ServiciosModel::where('id', $id)
                ->where('empresa_id', $this->empresa->id)
                ->first();
            if ($servicio) {
                if (Schema::hasColumn('servicios', 'imagen_url')) {
                    $this->eliminarImagen($servicio->getRawOriginal('imagen_url'));
                }
                $servicio->delete();
            }
            DB::commit();
            $this->mensaje = 'Servicio eliminado correctamente.';
            $this->tipoMensaje = 'success';
            $this->resetPage();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->mensaje = 'Ocurrió un error al eliminar el servicio.';
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
            $servicio = ServiciosModel::where('empresa_id', $this->empresa->id)->findOrFail($id);
            $servicio->activo = !$servicio->activo;
            $servicio->save();
            $this->mensaje = 'Estado actualizado correctamente.';
            $this->tipoMensaje = 'success';
        } catch (\Exception $e) {
            $this->mensaje = 'Ocurrió un error al cambiar el estado.';
            $this->tipoMensaje = 'error';
        }
    }

    public function resetFormulario()
    {
        $this->servicioIdEditar = null;
        $this->nombre = '';
        $this->duracion = 30;
        $this->precio = '';
        $this->puntos = 10;
        $this->activo = true;
        $this->imagenFile = null;
        $this->imagenExistente = null;
        $this->resetErrorBag();
    }

    protected function guardarImagen($file): string
    {
        $nombre = Str::slug($this->nombre ?: 'servicio') . '-' . time() . '.' . $file->getClientOriginalExtension();

        return $file->storeAs('servicios', $nombre, 'public');
    }

    protected function eliminarImagen(?string $path): void
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
        return view('livewire.admin.gestion-servicios', [
            'servicios' => $this->servicios,
            'totalServicios' => $this->totalServicios,
            'serviciosActivos' => $this->serviciosActivos,
            'esAdmin' => $this->esAdmin,
            'imagenPreviewUrl' => $this->imagenPreviewUrl,
        ]);
    }
}
