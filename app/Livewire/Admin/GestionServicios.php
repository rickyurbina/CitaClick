<?php

namespace App\Livewire\Admin;

use App\Models\EmpresasModel;
use App\Models\ServiciosModel;
use App\Models\CitasModel;
use App\Models\ListaEsperaModel;
use App\Models\PromocionesModel;
use App\Models\ComisionesModel;
use App\Models\AuditoriaCitasModel;
use App\Models\RedencionesPromocionModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    // Modal eliminar (confirmación)
    public $mostrarModalEliminar = false;
    public $eliminarId = null;
    public $eliminarDetalles = [];

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
            Log::error('Error al guardar servicio', ['error' => $e->getMessage()]);
            $this->mensaje = 'Ocurrió un error: ' . $e->getMessage();
            $this->tipoMensaje = 'error';
        }
        $this->cargando = false;
    }

    /**
     * Abre el modal de confirmación y calcula los registros que se
     * eliminarán en cascada.
     */
    public function eliminar($id)
    {
        if (!$this->esAdmin) {
            $this->mensaje = 'No tienes permiso.';
            $this->tipoMensaje = 'error';
            return;
        }

        $servicio = ServiciosModel::where('empresa_id', $this->empresa->id)->find($id);

        if (!$servicio) {
            $this->mensaje = 'Servicio no encontrado.';
            $this->tipoMensaje = 'error';
            return;
        }

        $citaIds = CitasModel::where('servicio_id', $servicio->id)->pluck('id');

        $this->eliminarId = $servicio->id;
        $this->eliminarDetalles = [
            'nombre'      => $servicio->nombre,
            'precio'      => $servicio->precio,
            'citas'       => $citaIds->count(),
            'comisiones'  => $citaIds->isNotEmpty()
                                ? ComisionesModel::whereIn('cita_id', $citaIds)->count()
                                : 0,
            'auditorias'  => $citaIds->isNotEmpty()
                                ? AuditoriaCitasModel::whereIn('cita_id', $citaIds)->count()
                                : 0,
            'redenciones' => $citaIds->isNotEmpty()
                                ? RedencionesPromocionModel::whereIn('cita_id', $citaIds)->count()
                                : 0,
            'lista_espera' => ListaEsperaModel::where('servicio_id', $servicio->id)->count(),
            'promociones'  => Schema::hasColumn('promociones', 'servicio_id')
                                ? PromocionesModel::where('servicio_id', $servicio->id)->count()
                                : 0,
            'colaboradores' => $servicio->colaboradores()->count(),
            'tiene_imagen'  => Schema::hasColumn('servicios', 'imagen_url') && $servicio->getRawOriginal('imagen_url') ? 1 : 0,
        ];

        $this->mostrarModalEliminar = true;
    }

    public function cancelarEliminacion()
    {
        $this->mostrarModalEliminar = false;
        $this->eliminarId = null;
        $this->eliminarDetalles = [];
    }

    /**
     * Ejecuta el borrado en cascada de TODOS los registros relacionados.
     */
    public function ejecutarEliminacion()
    {
        if (!$this->esAdmin) {
            $this->mensaje = 'No tienes permiso.';
            $this->tipoMensaje = 'error';
            return;
        }

        if (!$this->eliminarId) {
            $this->mensaje = 'No hay servicio seleccionado.';
            $this->tipoMensaje = 'error';
            return;
        }

        try {
            DB::beginTransaction();

            $servicio = ServiciosModel::where('id', $this->eliminarId)
                ->where('empresa_id', $this->empresa->id)
                ->first();

            if (!$servicio) {
                throw new \Exception('Servicio no encontrado.');
            }

            $citaIds = CitasModel::where('servicio_id', $servicio->id)->pluck('id');

            // 1. Redenciones de promociones
            if ($citaIds->isNotEmpty()) {
                RedencionesPromocionModel::whereIn('cita_id', $citaIds)->delete();
            }

            // 2. Auditorías de esas citas
            if ($citaIds->isNotEmpty()) {
                AuditoriaCitasModel::whereIn('cita_id', $citaIds)->delete();
            }

            // 3. Comisiones de esas citas
            if ($citaIds->isNotEmpty()) {
                ComisionesModel::whereIn('cita_id', $citaIds)->delete();
            }

            // 4. Citas del servicio
            if ($citaIds->isNotEmpty()) {
                CitasModel::whereIn('id', $citaIds)->delete();
            }

            // 5. Lista de espera
            ListaEsperaModel::where('servicio_id', $servicio->id)->delete();

            // 6. Promociones (si existe la columna)
            if (Schema::hasColumn('promociones', 'servicio_id')) {
                PromocionesModel::where('servicio_id', $servicio->id)->delete();
            }

            // 7. Pivot colaborador_servicio
            $servicio->colaboradores()->detach();

            // 8. Imagen
            if (Schema::hasColumn('servicios', 'imagen_url')) {
                $this->eliminarImagen($servicio->getRawOriginal('imagen_url'));
            }

            // 9. Servicio
            $servicio->delete();

            DB::commit();

            $this->mensaje = "Servicio \"{$servicio->nombre}\" eliminado junto con todos sus registros relacionados.";
            $this->tipoMensaje = 'success';
            $this->cancelarEliminacion();
            $this->resetPage();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar servicio', [
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