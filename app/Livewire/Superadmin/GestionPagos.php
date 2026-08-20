<?php

namespace App\Livewire\SuperAdmin;

use App\Models\EmpresasModel;
use App\Models\PagoEmpresaModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class GestionPagos extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $filtroEmpresa = '';
    public $filtroPlan = '';
    public $filtroEstatus = '';
    public $filtroFechaDesde = '';
    public $filtroFechaHasta = '';

    public $mostrarModal = false;
    public $modo = 'crear';
    public $pagoId = null;

    public $empresaId = '';
    public $plan = 'basico';
    public $monto = '';
    public $fechaPago = '';
    public $fechaVencimiento = '';
    public $metodoPago = '';
    public $referencia = '';
    public $estatus = 'pagado';

    public $cargando = false;

    protected $listeners = [
        'abrir-crear-pago' => 'abrirCrear',
        'abrir-editar-pago' => 'abrirEditar',
        'cerrar-modal-pago' => 'cerrarModal',
        'pago-guardado' => 'cerrarModal',
    ];

    public function getEmpresasProperty()
    {
        return EmpresasModel::orderBy('nombre')->get(['id', 'nombre']);
    }

    public function getPlanesListProperty()
    {
        return ['basico', 'pro', 'empresa'];
    }

    public function getPagosProperty()
    {
        $query = PagoEmpresaModel::with('empresa');

        if ($this->filtroEmpresa) {
            $query->where('empresa_id', $this->filtroEmpresa);
        }

        if ($this->filtroPlan) {
            $query->where('plan', $this->filtroPlan);
        }

        if ($this->filtroEstatus) {
            $query->where('estatus', $this->filtroEstatus);
        }

        if ($this->filtroFechaDesde) {
            $query->whereDate('fecha_pago', '>=', $this->filtroFechaDesde);
        }

        if ($this->filtroFechaHasta) {
            $query->whereDate('fecha_pago', '<=', $this->filtroFechaHasta);
        }

        return $query->orderByDesc('fecha_pago')->paginate(15);
    }

    public function getTotalIngresosProperty()
    {
        return PagoEmpresaModel::where('estatus', 'pagado')->sum('monto');
    }

    public function getIngresosMesProperty()
    {
        return PagoEmpresaModel::where('estatus', 'pagado')
            ->whereMonth('fecha_pago', Carbon::now()->month)
            ->whereYear('fecha_pago', Carbon::now()->year)
            ->sum('monto');
    }

    public function getPagosPendientesCountProperty()
    {
        return PagoEmpresaModel::where('estatus', 'pendiente')->count();
    }

    public function abrirCrear()
    {
        $this->resetFormulario();
        $this->modo = 'crear';
        $this->pagoId = null;
        $this->fechaPago = Carbon::today()->format('Y-m-d');
        $this->fechaVencimiento = Carbon::today()->addDays(30)->format('Y-m-d');
        $this->mostrarModal = true;
        $this->dispatch('modal-abierto');
    }

    public function abrirEditar($id)
    {
        $pago = PagoEmpresaModel::findOrFail($id);

        $this->pagoId = $pago->id;
        $this->modo = 'editar';
        $this->empresaId = $pago->empresa_id;
        $this->plan = $pago->plan;
        $this->monto = $pago->monto;
        $this->fechaPago = $pago->fecha_pago->format('Y-m-d');
        $this->fechaVencimiento = $pago->fecha_vencimiento->format('Y-m-d');
        $this->metodoPago = $pago->metodo_pago;
        $this->referencia = $pago->referencia;
        $this->estatus = $pago->estatus;

        $this->mostrarModal = true;
        $this->dispatch('modal-abierto');
    }

    public function guardar()
    {
        $this->validate([
            'empresaId' => 'required|exists:empresas,id',
            'plan' => 'required|in:basico,pro,empresa',
            'monto' => 'required|numeric|min:0.01',
            'fechaPago' => 'required|date',
            'fechaVencimiento' => 'required|date|after:fechaPago',
            'metodoPago' => 'nullable|string|max:50',
            'referencia' => 'nullable|string|max:100',
            'estatus' => 'required|in:pagado,pendiente,fallido',
        ]);

        $this->cargando = true;

        try {
            DB::beginTransaction();

            $datos = [
                'empresa_id' => $this->empresaId,
                'plan' => $this->plan,
                'monto' => $this->monto,
                'fecha_pago' => $this->fechaPago,
                'fecha_vencimiento' => $this->fechaVencimiento,
                'metodo_pago' => $this->metodoPago,
                'referencia' => $this->referencia,
                'estatus' => $this->estatus,
            ];

            if ($this->modo === 'editar') {
                $pago = PagoEmpresaModel::findOrFail($this->pagoId);
                $pago->update($datos);
                $mensaje = 'Pago actualizado correctamente.';
            } else {
                PagoEmpresaModel::create($datos);
                $mensaje = 'Pago registrado correctamente.';
            }

            DB::commit();

            $this->dispatch('mostrar-mensaje', mensaje: $mensaje, tipo: 'success');
            $this->cerrarModal();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('mostrar-mensaje', mensaje: 'Error: ' . $e->getMessage(), tipo: 'error');
        }

        $this->cargando = false;
    }

    public function eliminar($id)
    {
        try {
            DB::beginTransaction();
            $pago = PagoEmpresaModel::findOrFail($id);
            $pago->delete();
            DB::commit();
            $this->dispatch('mostrar-mensaje', mensaje: 'Pago eliminado correctamente.', tipo: 'success');
            $this->resetPage();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('mostrar-mensaje', mensaje: 'Error al eliminar el pago.', tipo: 'error');
        }
    }

    public function limpiarFiltros()
    {
        $this->filtroEmpresa = '';
        $this->filtroPlan = '';
        $this->filtroEstatus = '';
        $this->filtroFechaDesde = '';
        $this->filtroFechaHasta = '';
        $this->resetPage();
    }

    public function resetFormulario()
    {
        $this->empresaId = '';
        $this->plan = 'basico';
        $this->monto = '';
        $this->fechaPago = Carbon::today()->format('Y-m-d');
        $this->fechaVencimiento = Carbon::today()->addDays(30)->format('Y-m-d');
        $this->metodoPago = '';
        $this->referencia = '';
        $this->estatus = 'pagado';
        $this->resetErrorBag();
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
        $this->resetFormulario();
        $this->dispatch('modal-cerrado');
    }

    public function render()
    {
        return view('livewire.superadmin.gestion-pagos', [
            'pagos' => $this->pagos,
            'empresas' => $this->empresas,
            'planesList' => $this->planesList,
            'totalIngresos' => $this->totalIngresos,
            'ingresosMes' => $this->ingresosMes,
            'pagosPendientes' => $this->pagosPendientesCount,
        ]);
    }
}
