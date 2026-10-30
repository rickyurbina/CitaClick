<?php

namespace App\Livewire\SuperAdmin;

use App\Models\EmpresasModel;
use App\Models\PagoEmpresaModel;
use App\Models\User;
use App\Models\ClientesModel;
use App\Models\ServiciosModel;
use App\Models\CitasModel;
use App\Models\ComisionesModel;
use App\Models\AuditoriaCitasModel;
use App\Models\RedencionesPromocionModel;
use App\Models\ListaEsperaModel;
use App\Models\NotificacionesModel;
use App\Models\PromocionesModel;
use App\Models\ColaboradorHorario;
use App\Support\StorageHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Mensajes
    public $mensaje = null;
    public $tipoMensaje = 'info';

    // Filtros
    public $filtroBuscar = '';
    public $filtroPlan = '';
    public $filtroEstatus = '';

    // Control de apertura (legacy)
    public $forzarApertura = false;
    public $empresaIdForzar = null;
    public $accionForzar = 'crear';

    // Modal de eliminación
    public $mostrarModalEliminar = false;
    public $eliminarId = null;
    public $eliminarDetalles = [];

    public function getStatsProperty()
    {
        $totalEmpresas = EmpresasModel::count();
        $empresasActivas = EmpresasModel::where('estatus', 'activo')->count();
        $empresasPrueba = EmpresasModel::where('estatus', 'prueba')->count();
        $empresasSuspendidas = EmpresasModel::where('estatus', 'suspendido')->count();
        $empresasInactivas = EmpresasModel::where('estatus', 'inactivo')->count();

        
        $cobroMes = PagoEmpresaModel::whereMonth('fecha_pago', Carbon::now()->month)
            ->whereYear('fecha_pago', Carbon::now()->year)
            ->where('estatus', 'pagado')
            ->sum('monto');

        $empresasPorPlan = EmpresasModel::select('plan', DB::raw('count(*) as total'))
            ->groupBy('plan')
            ->pluck('total', 'plan')
            ->toArray();

        $crecimientoMensual = [];
        $labelsCrecimiento = [];
        for ($i = 5; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i);
            $inicio = $mes->copy()->startOfMonth();
            $fin = $mes->copy()->endOfMonth();

            $crecimientoMensual[] = EmpresasModel::whereBetween('created_at', [$inicio, $fin])->count();
            $labelsCrecimiento[] = $mes->format('M Y');
        }

        return [
            'totalEmpresas' => $totalEmpresas,
            'empresasActivas' => $empresasActivas,
            'empresasPrueba' => $empresasPrueba,
            'empresasSuspendidas' => $empresasSuspendidas,
            'empresasInactivas' => $empresasInactivas,
            'cobroMes' => $cobroMes,
            'empresasPorPlan' => $empresasPorPlan,
            'crecimientoMensual' => $crecimientoMensual,
            'labelsCrecimiento' => $labelsCrecimiento,
        ];
    }

    public function getEmpresasProperty()
    {
        $query = EmpresasModel::query();

        if ($this->filtroBuscar) {
            $query->where(function ($q) {
                $q->where('nombre', 'like', '%' . $this->filtroBuscar . '%')
                  ->orWhere('email_contacto', 'like', '%' . $this->filtroBuscar . '%')
                  ->orWhere('slug', 'like', '%' . $this->filtroBuscar . '%');
            });
        }

        if ($this->filtroPlan) {
            $query->where('plan', $this->filtroPlan);
        }

        if ($this->filtroEstatus) {
            $query->where('estatus', $this->filtroEstatus);
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    public function getPlanesProperty()
    {
        return ['basico', 'pro', 'empresa'];
    }

    public function getEstatusesProperty()
    {
        return ['activo', 'inactivo', 'prueba', 'suspendido'];
    }

    // ==================== APERTURA DE MODALES ====================

    public function abrirCrearEmpresa()
    {
        $this->forzarApertura = true;
        $this->accionForzar = 'crear';
        $this->empresaIdForzar = null;
        $this->dispatch('abrir-crear-empresa');
    }

    public function abrirEditarEmpresa($id)
    {
        $this->forzarApertura = true;
        $this->accionForzar = 'editar';
        $this->empresaIdForzar = $id;
        $this->dispatch('abrir-editar-empresa', id: $id);
    }

    public function verDetallesEmpresa($id)
    {
        $this->dispatch('ver-detalles-empresa', id: $id);
    }

    // ==================== CAMBIAR ESTATUS ====================

    public function cambiarEstatus($id, $nuevoEstatus)
    {
        try {
            $empresa = EmpresasModel::findOrFail($id);
            $empresa->estatus = $nuevoEstatus;
            $empresa->save();

            $this->mensaje = 'Estatus actualizado a "' . ucfirst($nuevoEstatus) . '".';
            $this->tipoMensaje = 'success';
        } catch (\Exception $e) {
            Log::error('Error al cambiar estatus', ['id' => $id, 'error' => $e->getMessage()]);
            $this->mensaje = 'Ocurrió un error al cambiar el estatus.';
            $this->tipoMensaje = 'error';
        }
    }

    // ==================== ELIMINACIÓN EN CASCADA ====================

    public function eliminarEmpresa($id)
    {
        $empresa = EmpresasModel::find($id);

        if (!$empresa) {
            $this->mensaje = 'Empresa no encontrada.';
            $this->tipoMensaje = 'error';
            return;
        }

        $userIds = User::where('empresa_id', $empresa->id)->pluck('id');
        $clienteIds = ClientesModel::where('empresa_id', $empresa->id)->pluck('id');
        $servicioIds = ServiciosModel::where('empresa_id', $empresa->id)->pluck('id');
        $citaIds = CitasModel::where('empresa_id', $empresa->id)->pluck('id');

        $this->eliminarId = $empresa->id;
        $this->eliminarDetalles = [
            'nombre'         => $empresa->nombre,
            'slug'           => $empresa->slug,
            'email'          => $empresa->email_contacto,
            'plan'           => $empresa->plan,
            'estatus'        => $empresa->estatus,
            'users'          => $userIds->count(),
            'clientes'       => $clienteIds->count(),
            'servicios'      => $servicioIds->count(),
            'citas'          => $citaIds->count(),
            'comisiones'     => ComisionesModel::where('empresa_id', $empresa->id)->count(),
            'auditorias'     => $citaIds->isNotEmpty()
                                    ? AuditoriaCitasModel::whereIn('cita_id', $citaIds)->count()
                                    : 0,
            'redenciones'    => RedencionesPromocionModel::where('empresa_id', $empresa->id)->count(),
            'lista_espera'   => ListaEsperaModel::where('empresa_id', $empresa->id)->count(),
            'notificaciones' => NotificacionesModel::where('empresa_id', $empresa->id)->count(),
            'promociones'    => PromocionesModel::where('empresa_id', $empresa->id)->count(),
            'pagos'          => PagoEmpresaModel::where('empresa_id', $empresa->id)->count(),
            'tiene_logo'     => $empresa->getRawOriginal('logo_url') ? 1 : 0,
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
        if (!$this->eliminarId) {
            $this->mensaje = 'No hay empresa seleccionada.';
            $this->tipoMensaje = 'error';
            return;
        }

        try {
            DB::beginTransaction();

            $empresa = EmpresasModel::find($this->eliminarId);

            if (!$empresa) {
                throw new \Exception('Empresa no encontrada.');
            }

            $nombreEmpresa = $empresa->nombre;

            $userIds = User::where('empresa_id', $empresa->id)->pluck('id');
            $servicioIds = ServiciosModel::where('empresa_id', $empresa->id)->pluck('id');
            $citaIds = CitasModel::where('empresa_id', $empresa->id)->pluck('id');

            RedencionesPromocionModel::where('empresa_id', $empresa->id)->delete();
            if ($citaIds->isNotEmpty()) {
                RedencionesPromocionModel::whereIn('cita_id', $citaIds)->delete();
                AuditoriaCitasModel::whereIn('cita_id', $citaIds)->delete();
                ComisionesModel::whereIn('cita_id', $citaIds)->delete();
                CitasModel::whereIn('id', $citaIds)->delete();
            }
            if ($userIds->isNotEmpty()) {
                AuditoriaCitasModel::whereIn('usuario_id', $userIds)->delete();
                ColaboradorHorario::whereIn('colaborador_id', $userIds)->delete();
                DB::table('colaborador_servicio')->whereIn('colaborador_id', $userIds)->delete();
            }
            if ($servicioIds->isNotEmpty()) {
                DB::table('colaborador_servicio')->whereIn('servicio_id', $servicioIds)->delete();
            }

            ComisionesModel::where('empresa_id', $empresa->id)->delete();
            ListaEsperaModel::where('empresa_id', $empresa->id)->delete();
            NotificacionesModel::where('empresa_id', $empresa->id)->delete();
            PromocionesModel::where('empresa_id', $empresa->id)->delete();
            PagoEmpresaModel::where('empresa_id', $empresa->id)->delete();

            if ($servicioIds->isNotEmpty()) {
                foreach (ServiciosModel::whereIn('id', $servicioIds)->get() as $servicio) {
                    $p = StorageHelper::path($servicio->getRawOriginal('imagen_url'));
                    if ($p && Storage::disk('public')->exists($p)) {
                        Storage::disk('public')->delete($p);
                    }
                }
            }
            ServiciosModel::where('empresa_id', $empresa->id)->delete();
            ClientesModel::where('empresa_id', $empresa->id)->delete();

            if ($userIds->isNotEmpty()) {
                foreach (User::whereIn('id', $userIds)->get() as $user) {
                    $p = StorageHelper::path($user->getRawOriginal('foto_url'));
                    if ($p && Storage::disk('public')->exists($p)) {
                        Storage::disk('public')->delete($p);
                    }
                }
            }
            User::where('empresa_id', $empresa->id)->delete();

            $logo = StorageHelper::path($empresa->getRawOriginal('logo_url'));
            if ($logo && Storage::disk('public')->exists($logo)) {
                Storage::disk('public')->delete($logo);
            }

            $empresa->delete();

            DB::commit();

            $this->mensaje = "Empresa \"{$nombreEmpresa}\" eliminada junto con todos sus registros relacionados.";
            $this->tipoMensaje = 'success';
            $this->cancelarEliminacion();
            $this->resetPage();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar empresa', [
                'id' => $this->eliminarId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->mensaje = 'Error al eliminar la empresa: ' . $e->getMessage();
            $this->tipoMensaje = 'error';
        }
    }

    public function limpiarFiltros()
    {
        $this->filtroBuscar = '';
        $this->filtroPlan = '';
        $this->filtroEstatus = '';
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.superadmin.dashboard', [
            'stats' => $this->stats,
            'empresas' => $this->empresas,
            'planes' => $this->planes,
            'estatuses' => $this->estatuses,
            'forzarApertura' => $this->forzarApertura,
            'accionForzar' => $this->accionForzar,
            'empresaIdForzar' => $this->empresaIdForzar,
            'eliminarDetalles' => $this->eliminarDetalles,
        ]);
    }
}