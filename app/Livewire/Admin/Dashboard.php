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
    public $citasAtendidas = [];
    public $citasProgramadas = [];
    public $citasCanceladas = [];
    public $ingresosEfectivo = [];
    public $ingresosTarjeta = [];
    public $ingresosTransferencia = [];
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

        $graficaInicio = $this->periodo === 'semana'
            ? $hoy->copy()->subDays(6)->startOfDay()
            : $fechaInicio;
        $graficaFin = $this->periodo === 'semana'
            ? $hoy->copy()->endOfDay()
            : $fechaFin;

        // 1. OBTENER DATOS ANTES DE CALCULAR LOS LABELS
        $citasPeriodo = CitasModel::where('empresa_id', $this->empresa->id)
            ->whereBetween('fecha', [$graficaInicio, $graficaFin])
            ->get(['fecha', 'hora_inicio', 'estado']);

        $pagosPeriodo = CitasModel::where('empresa_id', $this->empresa->id)
            ->whereBetween('fecha_pago', [$graficaInicio, $graficaFin])
            ->where('pagado', 1)
            ->get(['fecha_pago', 'monto_pagado', 'metodo_pago']);

        // 2. CALCULAR LABELS DINÁMICAMENTE
        $labels = [];
        $bucketKeys = [];

        if ($this->periodo === 'dia') {
            $horasRegistradas = collect();
            
            // Extraer horas de citas
            foreach ($citasPeriodo as $cita) {
                if ($cita->hora_inicio) {
                    $horasRegistradas->push(Carbon::parse($cita->hora_inicio)->hour);
                }
            }
            // Extraer horas de pagos
            foreach ($pagosPeriodo as $pago) {
                if ($pago->fecha_pago) {
                    $horasRegistradas->push(Carbon::parse($pago->fecha_pago)->hour);
                }
            }

            // Si hay registros, calculamos el rango. Si no, mostramos de 8 a 20 por defecto.
            if ($horasRegistradas->isNotEmpty()) {
                $horaMin = max(0, $horasRegistradas->min() - 1);
                $horaMax = min(23, $horasRegistradas->max() + 1);
            } else {
                $horaMin = 8;
                $horaMax = 20;
            }

            // Asegurar un rango mínimo visible (ej. 4 horas)
            if ($horaMin >= $horaMax) {
                $horaMax = min(23, $horaMin + 4);
            }

            for ($h = $horaMin; $h <= $horaMax; $h++) {
                $bucketKeys[] = (string) $h;
                $labels[] = $h . ':00';
            }

        } elseif ($this->periodo === 'semana') {
            for ($i = 6; $i >= 0; $i--) {
                $fecha = $hoy->copy()->subDays($i);
                $bucketKeys[] = $fecha->toDateString();
                $labels[] = $fecha->format('D d');
            }
        } else {
            $diasDelMes = $hoy->daysInMonth;
            for ($d = 1; $d <= $diasDelMes; $d++) {
                $fecha = $hoy->copy()->day($d);
                $bucketKeys[] = $fecha->toDateString();
                $labels[] = (string) $d;
            }
        }

        // 3. LLENAR LOS ARRAYS DE DATOS
        $vacios = array_fill_keys($bucketKeys, 0);
        $citasAtendidasMap = $vacios;
        $citasProgramadasMap = $vacios;
        $citasCanceladasMap = $vacios;
        $ingresosEfectivoMap = $vacios;
        $ingresosTarjetaMap = $vacios;
        $ingresosTransferenciaMap = $vacios;

        $estadosProgramadas = ['agendada', 'confirmada', 'en_curso'];
        $estadosCanceladas = ['cancelada', 'no_asistio'];

        foreach ($citasPeriodo as $cita) {
            $clave = $this->periodo === 'dia'
                ? (string) Carbon::parse($cita->hora_inicio)->hour
                : Carbon::parse($cita->fecha)->toDateString();

            if (!array_key_exists($clave, $vacios)) {
                continue;
            }

            if ($cita->estado === 'atendida') {
                $citasAtendidasMap[$clave]++;
            } elseif (in_array($cita->estado, $estadosCanceladas, true)) {
                $citasCanceladasMap[$clave]++;
            } elseif (in_array($cita->estado, $estadosProgramadas, true)) {
                $citasProgramadasMap[$clave]++;
            } else {
                $citasProgramadasMap[$clave]++;
            }
        }

        foreach ($pagosPeriodo as $pago) {
            $fechaPago = Carbon::parse($pago->fecha_pago);
            $clave = $this->periodo === 'dia'
                ? (string) $fechaPago->hour
                : $fechaPago->toDateString();

            if (!array_key_exists($clave, $vacios)) {
                continue;
            }

            $monto = (float) $pago->monto_pagado;
            if ($pago->metodo_pago === 'tarjeta') {
                $ingresosTarjetaMap[$clave] += $monto;
            } elseif ($pago->metodo_pago === 'transferencia') {
                $ingresosTransferenciaMap[$clave] += $monto;
            } else {
                $ingresosEfectivoMap[$clave] += $monto;
            }
        }

        $citasAtendidas = array_values($citasAtendidasMap);
        $citasProgramadas = array_values($citasProgramadasMap);
        $citasCanceladas = array_values($citasCanceladasMap);
        $ingresosEfectivo = array_values($ingresosEfectivoMap);
        $ingresosTarjeta = array_values($ingresosTarjetaMap);
        $ingresosTransferencia = array_values($ingresosTransferenciaMap);

        $citasData = array_map(
            fn ($atendida, $programada, $cancelada) => $atendida + $programada + $cancelada,
            $citasAtendidas,
            $citasProgramadas,
            $citasCanceladas
        );
        $ingresosData = array_map(
            fn ($efectivo, $tarjeta, $transferencia) => $efectivo + $tarjeta + $transferencia,
            $ingresosEfectivo,
            $ingresosTarjeta,
            $ingresosTransferencia
        );

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

        $this->citasHoy = $citasHoy;
        $this->ingresosHoy = $ingresosTotales;
        $this->efectivoHoy = $efectivo;
        $this->gananciaNeta = $gananciaNeta;
        $this->labels = $labels;
        $this->citasPorDia = $citasData;
        $this->ingresosPorDia = $ingresosData;
        $this->citasAtendidas = $citasAtendidas;
        $this->citasProgramadas = $citasProgramadas;
        $this->citasCanceladas = $citasCanceladas;
        $this->ingresosEfectivo = $ingresosEfectivo;
        $this->ingresosTarjeta = $ingresosTarjeta;
        $this->ingresosTransferencia = $ingresosTransferencia;
        $this->topColaboradores = $topColaboradores;
        $this->ultimasCitas = $ultimasCitas;
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
            'citasAtendidas' => $this->citasAtendidas,
            'citasProgramadas' => $this->citasProgramadas,
            'citasCanceladas' => $this->citasCanceladas,
            'ingresosEfectivo' => $this->ingresosEfectivo,
            'ingresosTarjeta' => $this->ingresosTarjeta,
            'ingresosTransferencia' => $this->ingresosTransferencia,
            'labels' => $this->labels,
            'topColaboradores' => $this->topColaboradores,
            'ultimasCitas' => $this->ultimasCitas,
        ]);
    }
}