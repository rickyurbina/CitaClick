<?php

namespace App\Livewire\SuperAdmin;

use App\Models\EmpresasModel;
use App\Models\CitasModel;
use App\Models\ComisionesModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $filtroBuscar = '';
    public $filtroPlan = '';
    public $filtroEstatus = '';

    // 👈 VARIABLES PARA CONTROLAR APERTURA FORZADA
    public $forzarApertura = false;
    public $empresaIdForzar = null;
    public $accionForzar = 'crear'; // 'crear' o 'editar'

    public function getStatsProperty()
    {
        $totalEmpresas = EmpresasModel::count();
        $empresasActivas = EmpresasModel::where('estatus', 'activo')->count();
        $empresasPrueba = EmpresasModel::where('estatus', 'prueba')->count();
        $empresasSuspendidas = EmpresasModel::where('estatus', 'suspendido')->count();
        $empresasInactivas = EmpresasModel::where('estatus', 'inactivo')->count();

        $cobroMes = ComisionesModel::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('estatus', 'pagada')
            ->sum('monto');

        $ingresosMes = CitasModel::whereMonth('fecha_pago', Carbon::now()->month)
            ->whereYear('fecha_pago', Carbon::now()->year)
            ->where('pagado', 1)
            ->sum('monto_pagado');

        $citasMes = CitasModel::whereMonth('fecha', Carbon::now()->month)
            ->whereYear('fecha', Carbon::now()->year)
            ->count();

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
            'ingresosMes' => $ingresosMes,
            'citasMes' => $citasMes,
            'empresasPorPlan' => $empresasPorPlan,
            'crecimientoMensual' => $crecimientoMensual,
            'labelsCrecimiento' => $labelsCrecimiento,
        ];
    }

    public function getEmpresasProperty()
    {
        $query = EmpresasModel::query();

        if ($this->filtroBuscar) {
            $query->where(function($q) {
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

    // 👈 MÉTODOS PARA FORZAR APERTURA
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

    public function cambiarEstatus($id, $nuevoEstatus)
    {
        try {
            $empresa = EmpresasModel::findOrFail($id);
            $empresa->estatus = $nuevoEstatus;
            $empresa->save();

            $this->dispatch('mostrar-mensaje', 
                mensaje: 'Estatus actualizado a "' . ucfirst($nuevoEstatus) . '"',
                tipo: 'success'
            );

        } catch (\Exception $e) {
            $this->dispatch('mostrar-mensaje', 
                mensaje: 'Ocurrió un error al cambiar el estatus.',
                tipo: 'error'
            );
        }
    }

    public function eliminarEmpresa($id)
    {
        try {
            DB::beginTransaction();

            $empresa = EmpresasModel::findOrFail($id);
            
            $tieneDatos = $empresa->users()->count() > 0 || 
                          $empresa->clientes()->count() > 0 || 
                          $empresa->citas()->count() > 0;

            if ($tieneDatos) {
                $this->dispatch('mostrar-mensaje', 
                    mensaje: 'No se puede eliminar. La empresa tiene datos asociados.',
                    tipo: 'error'
                );
                DB::rollBack();
                return;
            }

            $logoPath = $empresa->getRawOriginal('logo_url');
            if ($logoPath && Storage::disk('public')->exists($logoPath)) {
                Storage::disk('public')->delete($logoPath);
            }

            $empresa->delete();

            DB::commit();

            $this->dispatch('mostrar-mensaje', 
                mensaje: 'Empresa eliminada correctamente.',
                tipo: 'success'
            );
            $this->resetPage();

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('mostrar-mensaje', 
                mensaje: 'Ocurrió un error al eliminar la empresa.',
                tipo: 'error'
            );
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
        ]);
    }
}