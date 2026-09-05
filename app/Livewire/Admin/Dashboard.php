<?php

namespace App\Livewire\Admin;

use App\Models\EmpresasModel;
use App\Models\CitasModel;
use App\Models\ComisionesModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Dashboard extends Component
{
    public EmpresasModel $empresa;
    public string $periodo = 'dia';

    public $citasHoy = 0;
    public $ingresosHoy = 0;
    public $efectivoHoy = 0;
    public $gananciaNeta = 0;
    public $citasPorDia = [];
    public $ingresosPorDia = [];
    public $labels = [];
    public $topColaboradores = [];
    public $ultimasCitas = [];

    public function mount()
    {
        $this->actualizarDatos();
    }

    public function cambiarPeriodo($periodo)
    {
        $this->periodo = $periodo;
        $this->actualizarDatos();
    }

    public function actualizarDatos()
    {
        $hoy = Carbon::today();
        $rol = Auth::guard('web')->user()->rol;

        if (!in_array($rol, ['empresa_admin', 'super_admin'])) {
            return;
        }

        $fechaInicio = clone $hoy;
        $fechaFin = clone $hoy;

        switch ($this->periodo) {
            case 'dia':
                $fechaInicio = $hoy->copy()->startOfDay();
                $fechaFin = $hoy->copy()->endOfDay();
                break;
            case 'semana':
                $fechaInicio = $hoy->copy()->startOfWeek();
                $fechaFin = $hoy->copy()->endOfWeek();
                break;
            case 'mes':
                $fechaInicio = $hoy->copy()->startOfMonth();
                $fechaFin = $hoy->copy()->endOfMonth();
                break;
            default:
                $fechaInicio = $hoy->copy()->startOfDay();
                $fechaFin = $hoy->copy()->endOfDay();
                break;
        }

        $cacheKey = 'dashboard_stats_' . $this->empresa->id . '_' . $this->periodo;
        $stats = Cache::remember($cacheKey, 300, function () use ($fechaInicio, $fechaFin, $hoy) {
            $citasHoy = CitasModel::where('empresa_id', $this->empresa->id)
                ->whereDate('fecha', $hoy)
                ->count();

            $ingresosTotales = CitasModel::where('empresa_id', $this->empresa->id)
                ->whereBetween('fecha_pago', [$fechaInicio, $fechaFin])
                ->where('pagado', 1)
                ->sum('monto_pagado');

            $efectivo = CitasModel::where('empresa_id', $this->empresa->id)
                ->whereBetween('fecha_pago', [$fechaInicio, $fechaFin])
                ->where('pagado', 1)
                ->where('metodo_pago', 'efectivo')
                ->sum('monto_pagado');

            $comisiones = ComisionesModel::where('empresa_id', $this->empresa->id)
                ->whereHas('cita', function ($query) use ($fechaInicio, $fechaFin) {
                    $query->whereBetween('fecha_pago', [$fechaInicio, $fechaFin])
                          ->where('pagado', 1);
                })
                ->sum('monto');

            $gananciaNeta = $ingresosTotales - $comisiones;

            $labels = [];
            $citasData = [];
            $ingresosData = [];

            if ($this->periodo === 'dia') {
                for ($h = 8; $h <= 20; $h++) {
                    $horaInicio = $hoy->copy()->setHour($h)->setMinute(0);
                    $horaFin = $hoy->copy()->setHour($h)->setMinute(59);
                    $labels[] = $h . ':00';
                    $citasData[] = CitasModel::where('empresa_id', $this->empresa->id)
                        ->whereBetween('fecha', [$horaInicio, $horaFin])
                        ->count();
                    $ingresosData[] = CitasModel::where('empresa_id', $this->empresa->id)
                        ->whereBetween('fecha_pago', [$horaInicio, $horaFin])
                        ->where('pagado', 1)
                        ->sum('monto_pagado');
                }
            } elseif ($this->periodo === 'semana') {
                for ($i = 6; $i >= 0; $i--) {
                    $fecha = $hoy->copy()->subDays($i);
                    $labels[] = $fecha->format('D d');
                    $citasData[] = CitasModel::where('empresa_id', $this->empresa->id)
                        ->whereDate('fecha', $fecha)
                        ->count();
                    $ingresosData[] = CitasModel::where('empresa_id', $this->empresa->id)
                        ->whereDate('fecha_pago', $fecha)
                        ->where('pagado', 1)
                        ->sum('monto_pagado');
                }
            } elseif ($this->periodo === 'mes') {
                $diasDelMes = $hoy->daysInMonth;
                for ($d = 1; $d <= $diasDelMes; $d++) {
                    $fecha = $hoy->copy()->day($d);
                    $labels[] = $d;
                    $citasData[] = CitasModel::where('empresa_id', $this->empresa->id)
                        ->whereDate('fecha', $fecha)
                        ->count();
                    $ingresosData[] = CitasModel::where('empresa_id', $this->empresa->id)
                        ->whereDate('fecha_pago', $fecha)
                        ->where('pagado', 1)
                        ->sum('monto_pagado');
                }
            }

            $topColaboradores = User::where('empresa_id', $this->empresa->id)
                ->where('rol', 'colaborador')
                ->where('activo', 1)
                ->withSum(['citas' => function ($query) use ($fechaInicio, $fechaFin) {
                    $query->whereBetween('fecha_pago', [$fechaInicio, $fechaFin])
                          ->where('pagado', 1);
                }], 'monto_pagado')
                ->having('citas_sum_monto_pagado', '>', 0)
                ->orderBy('citas_sum_monto_pagado', 'desc')
                ->limit(5)
                ->get();

            $ultimasCitas = CitasModel::where('empresa_id', $this->empresa->id)
                ->with(['cliente:id,nombre,telefono', 'servicio:id,nombre', 'colaborador:id,nombre'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            return [
                'citasHoy' => $citasHoy,
                'ingresosTotales' => $ingresosTotales,
                'efectivo' => $efectivo,
                'gananciaNeta' => $gananciaNeta,
                'labels' => $labels,
                'citasData' => $citasData,
                'ingresosData' => $ingresosData,
                'topColaboradores' => $topColaboradores,
                'ultimasCitas' => $ultimasCitas,
            ];
        });

        $this->citasHoy = $stats['citasHoy'];
        $this->ingresosHoy = $stats['ingresosTotales'];
        $this->efectivoHoy = $stats['efectivo'];
        $this->gananciaNeta = $stats['gananciaNeta'];
        $this->labels = $stats['labels'];
        $this->citasPorDia = $stats['citasData'];
        $this->ingresosPorDia = $stats['ingresosData'];
        $this->topColaboradores = $stats['topColaboradores'];
        $this->ultimasCitas = $stats['ultimasCitas'];
    }

    public function render()
    {
        return view('livewire.admin.dashboard', [
            'periodo' => $this->periodo,
            'citasHoy' => $this->citasHoy,
            'ingresosHoy' => $this->ingresosHoy,
            'efectivoHoy' => $this->efectivoHoy,
            'gananciaNeta' => $this->gananciaNeta,
            'citasPorDia' => $this->citasPorDia,
            'ingresosPorDia' => $this->ingresosPorDia,
            'labels' => $this->labels,
            'topColaboradores' => $this->topColaboradores,
            'ultimasCitas' => $this->ultimasCitas,
        ]);
    }
}