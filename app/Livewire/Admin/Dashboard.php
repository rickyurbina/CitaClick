<?php

namespace App\Livewire\Admin;

use App\Models\EmpresasModel;
use App\Models\CitasModel;
use App\Models\ComisionesModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public EmpresasModel $empresa;
    public string $periodo = 'semana';

    public function getStatsProperty()
    {
        $today = Carbon::today();
        $userId = Auth::guard('web')->user()->id;
        $rol = Auth::guard('web')->user()->rol;

        $query = CitasModel::where('empresa_id', $this->empresa->id);

        if ($rol === 'colaborador') {
            $query->where('colaborador_id', $userId);
        }

        $citasHoy = (clone $query)->whereDate('fecha', $today)->count();

        $ingresosHoy = (clone $query)
            ->whereDate('fecha', $today)
            ->where('pagado', 1)
            ->sum('monto_pagado');

        $efectivoHoy = (clone $query)
            ->whereDate('fecha', $today)
            ->where('pagado', 1)
            ->where('metodo_pago', 'efectivo')
            ->sum('monto_pagado');

        $comisionesHoy = 0;
        if (in_array($rol, ['empresa_admin', 'super_admin'])) {
            $comisionesHoy = ComisionesModel::where('empresa_id', $this->empresa->id)
                ->whereDate('created_at', $today)
                ->where('estatus', 'pagada')
                ->sum('monto');
        }

        $citasPorEstado = (clone $query)
            ->whereDate('fecha', $today)
            ->select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->pluck('total', 'estado')
            ->toArray();

        $topColaboradores = [];
        if (in_array($rol, ['empresa_admin', 'super_admin'])) {
            $topColaboradores = User::where('empresa_id', $this->empresa->id)
                ->where('rol', 'colaborador')
                ->where('activo', 1)
                ->withSum(['citas' => function($q) {
                    $q->where('pagado', 1)
                      ->whereDate('fecha', '>=', Carbon::now()->subDays(30));
                }], 'monto_pagado')
                ->orderBy('citas_sum_monto_pagado', 'desc')
                ->limit(5)
                ->get(['id', 'nombre', 'comision_porcentaje', 'email']);
        }

        $ultimasCitas = (clone $query)
            ->with(['cliente:id,nombre,telefono', 
                    'servicio:id,nombre,precio',
                    'colaborador:id,nombre'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        if ($this->periodo === 'semana') {
            $fechas = collect(range(6, 0))->map(fn($d) => Carbon::today()->subDays($d));
        } elseif ($this->periodo === 'mes') {
            $fechas = collect(range(29, 0))->map(fn($d) => Carbon::today()->subDays($d));
        } else {
            $fechas = collect(range(11, 0))->map(fn($m) => Carbon::today()->subMonths($m));
        }

        $citasPorDia = [];
        $ingresosPorDia = [];

        foreach ($fechas as $fecha) {
            $dia = $fecha->format('Y-m-d');
            
            $citasPorDia[$dia] = (clone $query)
                ->whereDate('fecha', $fecha)
                ->count();
                
            $ingresosPorDia[$dia] = (clone $query)
                ->whereDate('fecha', $fecha)
                ->where('pagado', 1)
                ->sum('monto_pagado');
        }

        return [
            'citasHoy' => $citasHoy,
            'ingresosHoy' => $ingresosHoy,
            'efectivoHoy' => $efectivoHoy,
            'comisionesHoy' => $comisionesHoy,
            'gananciaNeta' => $ingresosHoy - $comisionesHoy,
            'citasPorEstado' => $citasPorEstado,
            'topColaboradores' => $topColaboradores,
            'ultimasCitas' => $ultimasCitas,
            'citasPorDia' => array_values($citasPorDia),
            'ingresosPorDia' => array_values($ingresosPorDia),
            'labels' => $fechas->map(fn($f) => $f->format('d/m'))->toArray(),
        ];
    }

    public function cambiarPeriodo($periodo)
    {
        $this->periodo = $periodo;
    }

    public function render()
    {
        return view('livewire.admin.dashboard', [
            'stats' => $this->stats,
        ]);
    }
}