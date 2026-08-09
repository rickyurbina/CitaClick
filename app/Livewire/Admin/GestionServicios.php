<?php

namespace App\Livewire\Admin;

use App\Models\EmpresasModel;
use App\Models\ServiciosModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class GestionServicios extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public EmpresasModel $empresa;

    // Modal
    public $mostrarModal = false;

    // Formulario
    public $servicioIdEditar = null;
    public $nombre = '';
    public $duracion = 30;
    public $precio = '';
    public $puntos = 10;
    public $activo = true;

    public $cargando = false;

    // Filtros
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

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:100',
            'duracion' => 'required|integer|min:5',
            'precio' => 'required|numeric|min:0',
            'puntos' => 'nullable|integer|min:0',
            'activo' => 'boolean',
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
        ];
    }

    public function abrirCrear()
    {
        if (!$this->esAdmin) {
            $this->dispatch('mostrar-mensaje', mensaje: 'No tienes permiso.', tipo: 'error');
            return;
        }

        $this->resetFormulario();
        $this->servicioIdEditar = null;
        $this->mostrarModal = true;
    }

    public function abrirEditar($id)
    {
        if (!$this->esAdmin) {
            $this->dispatch('mostrar-mensaje', mensaje: 'No tienes permiso.', tipo: 'error');
            return;
        }

        $servicio = ServiciosModel::where('empresa_id', $this->empresa->id)->findOrFail($id);

        $this->servicioIdEditar = $servicio->id;
        $this->nombre = $servicio->nombre;
        $this->duracion = $servicio->duracion_minutos;
        $this->precio = $servicio->precio;
        $this->puntos = $servicio->puntos_genera;
        $this->activo = (bool) $servicio->activo;

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
                'duracion_minutos' => $this->duracion,
                'precio' => $this->precio,
                'puntos_genera' => $this->puntos ?: 0,
                'activo' => $this->activo,
            ];

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

            $this->dispatch('mostrar-mensaje', mensaje: $mensaje, tipo: 'success');
            $this->cerrarModal();
            $this->resetPage();

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('mostrar-mensaje', 
                mensaje: 'Ocurrió un error: ' . $e->getMessage(),
                tipo: 'error'
            );
        }

        $this->cargando = false;
    }

    public function eliminar($id)
    {
        if (!$this->esAdmin) {
            $this->dispatch('mostrar-mensaje', mensaje: 'No tienes permiso.', tipo: 'error');
            return;
        }

        try {
            $tieneCitas = \App\Models\CitasModel::where('empresa_id', $this->empresa->id)
                ->where('servicio_id', $id)
                ->exists();

            if ($tieneCitas) {
                $this->dispatch('mostrar-mensaje', 
                    mensaje: 'No se puede eliminar. El servicio tiene citas asociadas.',
                    tipo: 'error'
                );
                return;
            }

            DB::beginTransaction();

            ServiciosModel::where('id', $id)
                ->where('empresa_id', $this->empresa->id)
                ->delete();

            DB::commit();

            $this->dispatch('mostrar-mensaje', 
                mensaje: 'Servicio eliminado correctamente.',
                tipo: 'success'
            );
            $this->resetPage();

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('mostrar-mensaje', 
                mensaje: 'Ocurrió un error al eliminar el servicio.',
                tipo: 'error'
            );
        }
    }

    public function toggleActivo($id)
    {
        if (!$this->esAdmin) {
            $this->dispatch('mostrar-mensaje', mensaje: 'No tienes permiso.', tipo: 'error');
            return;
        }

        try {
            $servicio = ServiciosModel::where('empresa_id', $this->empresa->id)->findOrFail($id);
            $servicio->activo = !$servicio->activo;
            $servicio->save();

            $this->dispatch('mostrar-mensaje', 
                mensaje: 'Estado actualizado correctamente.',
                tipo: 'success'
            );

        } catch (\Exception $e) {
            $this->dispatch('mostrar-mensaje', 
                mensaje: 'Ocurrió un error al cambiar el estado.',
                tipo: 'error'
            );
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
        $this->resetErrorBag();
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
        ]);
    }
}