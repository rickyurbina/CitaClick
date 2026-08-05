<?php

namespace App\Livewire\Admin;

use App\Models\EmpresasModel;
use App\Models\CitasModel;
use Carbon\Carbon;
use Livewire\Component;

class ResumenFinanciero extends Component
{
    public EmpresasModel $empresa;

    public function getIngresosHoyProperty()
    {
        return CitasModel::where('empresa_id', $this->empresa->id)
            ->where('fecha', Carbon::today())
            ->where('pagado', 1)
            ->sum('monto_pagado');
    }

    public function getComisionesHoyProperty()
    {
        $citas = CitasModel::where('empresa_id', $this->empresa->id)
            ->where('fecha', Carbon::today())
            ->where('pagado', 1)
            ->with('colaborador')
            ->get();

        $total = 0;

        foreach ($citas as $cita) {
            $porcentaje = $cita->colaborador->comision_porcentaje ?? 0;
            $total += $cita->monto_pagado * ($porcentaje / 100);
        }

        return $total;
    }

    public function getGananciaNetaHoyProperty()
    {
        return $this->ingresosHoy - $this->comisionesHoy;
    }

    public function getMargenProperty()
    {
        if ($this->ingresosHoy == 0) {
            return 0;
        }

        return round(($this->gananciaNetaHoy / $this->ingresosHoy) * 100, 1);
    }

    public function getGananciasSemanaProperty()
    {
        $dias = collect();

        for ($i = 6; $i >= 0; $i--) {
            $fecha = Carbon::today()->subDays($i);

            $total = CitasModel::where('empresa_id', $this->empresa->id)
                ->where('fecha', $fecha->format('Y-m-d'))
                ->where('pagado', 1)
                ->sum('monto_pagado');

            $dias->push([
                'fecha' => $fecha->format('d/m'),
                'total' => (float) $total,
            ]);
        }

        return $dias;
    }

    public function getTopColaboradoresProperty()
    {
        return CitasModel::where('empresa_id', $this->empresa->id)
            ->where('fecha', Carbon::today())
            ->where('pagado', 1)
            ->selectRaw('colaborador_id, SUM(monto_pagado) as total')
            ->groupBy('colaborador_id')
            ->orderByDesc('total')
            ->with('colaborador')
            ->take(5)
            ->get();
    }

    public function getUltimasEntradasProperty()
    {
        return CitasModel::where('empresa_id', $this->empresa->id)
            ->where('fecha', Carbon::today())
            ->where('pagado', 1)
            ->with(['cliente', 'servicio', 'colaborador'])
            ->orderByDesc('fecha_pago')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.resumen-financiero', [
            'ingresosHoy' => $this->ingresosHoy,
            'comisionesHoy' => $this->comisionesHoy,
            'gananciaNetaHoy' => $this->gananciaNetaHoy,
            'margen' => $this->margen,
            'gananciasSemana' => $this->gananciasSemana,
            'topColaboradores' => $this->topColaboradores,
            'ultimasEntradas' => $this->ultimasEntradas,
        ]);
    }
}