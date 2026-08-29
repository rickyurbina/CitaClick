<?php

namespace App\Livewire\Admin;

use App\Models\EmpresasModel;
use App\Models\CitasModel;
use App\Models\ComisionesModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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

        // Definir rango de fechas según período
        $fechaInicio = clone $hoy;
        $fechaFin = clone $hoy;

        switch ($this->periodo) {
            case 'dia':
                $fechaInicio = $hoy->copy();
                $fechaFin = $hoy->copy();
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
                $fechaInicio = $hoy->copy();
                $fechaFin = $hoy->copy();
                break;
        }

        // Citas de hoy (siempre hoy)
        $this->citasHoy = CitasModel::where('empresa_id', $this->empresa->id)
            ->whereDate('fecha', $hoy)
            ->count();

        // Ingresos del período
        $ingresosTotales = CitasModel::where('empresa_id', $this->empresa->id)
            ->whereBetween('fecha_pago', [$fechaInicio, $fechaFin])
            ->where('pagado', 1)
            ->sum('monto_pagado');

        $this->ingresosHoy = $ingresosTotales;

        // Efectivo del período
        $this->efectivoHoy = CitasModel::where('empresa_id', $this->empresa->id)
            ->whereBetween('fecha_pago', [$fechaInicio, $fechaFin])
            ->where('pagado', 1)
            ->where('metodo_pago', 'efectivo')
            ->sum('monto_pagado');

        // Comisiones usando fecha_pago de la cita asociada
        $comisiones = ComisionesModel::where('empresa_id', $this->empresa->id)
            ->whereHas('cita', function ($query) use ($fechaInicio, $fechaFin) {
                $query->whereBetween('fecha_pago', [$fechaInicio, $fechaFin])
                      ->where('pagado', 1);
            })
            ->sum('monto');

        $this->gananciaNeta = $ingresosTotales - $comisiones;

        // Generar datos para gráficas según período
        $labels = [];
        $citasData = [];
        $ingresosData = [];

        if ($this->periodo === 'dia') {
            for ($h = 8; $h <= 20; $h++) {
                $horaInicio = Carbon::today()->setHour($h)->setMinute(0);
                $horaFin = Carbon::today()->setHour($h)->setMinute(59);
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
                $fecha = Carbon::today()->subDays($i);
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
            $diasDelMes = Carbon::today()->daysInMonth;
            for ($d = 1; $d <= $diasDelMes; $d++) {
                $fecha = Carbon::create(Carbon::today()->year, Carbon::today()->month, $d);
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

        // Asegurar que no estén vacíos
        if (empty($labels)) {
            $labels = ['Sin datos'];
            $citasData = [0];
            $ingresosData = [0];
        }

        $this->labels = $labels;
        $this->citasPorDia = $citasData;
        $this->ingresosPorDia = $ingresosData;

        // Top colaboradores
        $this->topColaboradores = User::where('empresa_id', $this->empresa->id)
            ->where('rol', 'colaborador')
            ->where('activo', 1)
            ->withSum(['citas' => function ($query) use ($fechaInicio, $fechaFin) {
                $query->whereBetween('fecha_pago', [$fechaInicio, $fechaFin])
                      ->where('pagado', 1);
            }], 'monto_pagado')
            ->having('citas_sum_monto_pagado', '>', 0)
            ->orderBy('citas_sum_monto_pagado', 'desc')
            ->limit(5)
            ->get(['id', 'nombre', 'comision_porcentaje']);

        // Últimas 5 citas
        $this->ultimasCitas = CitasModel::where('empresa_id', $this->empresa->id)
            ->with(['cliente:id,nombre,telefono', 'servicio:id,nombre', 'colaborador:id,nombre'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
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