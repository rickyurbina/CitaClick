<div>
    {{-- Filtros --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">📊 Dashboard</h2>
            <p class="text-sm text-gray-500">Resumen de citas e ingresos</p>
        </div>
        <div class="flex space-x-2">
            <button wire:click="cambiarPeriodo('dia')" 
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all
                        {{ $periodo === 'dia' ? 'bg-primary text-on-primary shadow-md' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container' }}">
                Día
            </button>
            <button wire:click="cambiarPeriodo('semana')" 
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all
                        {{ $periodo === 'semana' ? 'bg-primary text-on-primary shadow-md' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container' }}">
                Semana
            </button>
            <button wire:click="cambiarPeriodo('mes')" 
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all
                        {{ $periodo === 'mes' ? 'bg-primary text-on-primary shadow-md' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container' }}">
                Mes
            </button>
        </div>
    </div>

    {{-- Tarjetas de métricas --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-surface p-6 rounded-xl border border-outline-variant shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-label-sm text-on-surface-variant uppercase tracking-wider font-label-sm">Citas de Hoy</p>
                    <h3 class="text-headline-lg font-bold text-on-surface">{{ $citasHoy }}</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
                    <span class="material-symbols-outlined">event_note</span>
                </div>
            </div>
        </div>

        <div class="bg-surface p-6 rounded-xl border border-outline-variant shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-label-sm text-on-surface-variant uppercase tracking-wider font-label-sm">Ingresos</p>
                    <h3 class="text-headline-lg font-bold text-secondary">${{ number_format($ingresosHoy, 2) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-primary-container flex items-center justify-center text-on-primary-container">
                    <span class="material-symbols-outlined">payments</span>
                </div>
            </div>
        </div>

        <div class="bg-surface p-6 rounded-xl border border-outline-variant shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-label-sm text-on-surface-variant uppercase tracking-wider font-label-sm">Efectivo</p>
                    <h3 class="text-headline-lg font-bold text-on-surface">${{ number_format($efectivoHoy, 2) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-surface-container-high flex items-center justify-center text-on-surface">
                    <span class="material-symbols-outlined">payments</span>
                </div>
            </div>
        </div>

        <div class="bg-surface p-6 rounded-xl border-2 border-secondary shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 -mr-16 -mt-16 bg-secondary opacity-5 rounded-full"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-label-sm text-on-surface-variant uppercase tracking-wider font-label-sm">Ganancia Neta</p>
                    <h3 class="text-headline-lg font-bold text-secondary">${{ number_format($gananciaNeta, 2) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
                    <span class="material-symbols-outlined">trending_up</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Gráficas --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- Citas --}}
        <div class="bg-surface p-6 rounded-xl border border-outline-variant shadow-sm">
            @php
                $citasAtendidas = $citasAtendidas ?? [];
                $citasProgramadas = $citasProgramadas ?? [];
                $citasCanceladas = $citasCanceladas ?? [];
                $totalAtendidas = array_sum($citasAtendidas);
                $totalProgramadas = array_sum($citasProgramadas);
                $totalCanceladas = array_sum($citasCanceladas);
                $maxCitas = count($citasPorDia) ? max($citasPorDia) : 0;
                $maxCitas = $maxCitas > 0 ? $maxCitas : 1;
                $totalPuntosCitas = count($citasPorDia);
                $isMes = $periodo === 'mes';
                $barClass = $isMes ? 'gap-0.5' : 'gap-2';
                $labelClass = $isMes ? 'text-[8px]' : 'text-xs';
                $hayCitas = $totalPuntosCitas > 0 && ($totalPuntosCitas > 1 || ($citasPorDia[0] ?? 0) > 0);
            @endphp
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-4">
                <h3 class="font-headline-md text-headline-md text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary">bar_chart</span>
                    Citas por estado
                </h3>
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1" role="list" aria-label="Leyenda de citas">
                    <span class="inline-flex items-center gap-1.5 text-xs text-on-surface-variant" role="listitem">
                        <span class="w-2.5 h-2.5 rounded-sm bg-secondary shrink-0"></span>
                        Atendidas ({{ $totalAtendidas }})
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-xs text-on-surface-variant" role="listitem">
                        <span class="w-2.5 h-2.5 rounded-sm bg-primary-container shrink-0"></span>
                        Programadas ({{ $totalProgramadas }})
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-xs text-on-surface-variant" role="listitem">
                        <span class="w-2.5 h-2.5 rounded-sm bg-error shrink-0"></span>
                        Canceladas / No asistió ({{ $totalCanceladas }})
                    </span>
                </div>
            </div>

            @if($hayCitas)
                <div class="h-64 flex items-end {{ $barClass }}">
                    @foreach($citasPorDia as $index => $cita)
                        @php
                            $atendidas = $citasAtendidas[$index] ?? 0;
                            $programadas = $citasProgramadas[$index] ?? 0;
                            $canceladas = $citasCanceladas[$index] ?? 0;
                            $height = ($cita / $maxCitas) * 170;
                            $label = $labels[$index] ?? '';
                        @endphp
                        <div class="flex-1 min-w-0 flex flex-col items-center justify-end h-full">
                            @if($cita > 0 && !$isMes)
                                <span class="text-[10px] font-medium text-on-surface mb-1">{{ $cita }}</span>
                            @endif
                            <div class="w-full max-w-[2.5rem] rounded-t overflow-hidden bg-surface-container-low"
                                 style="height: {{ max($height, $cita > 0 ? 8 : 2) }}px;"
                                 title="{{ $label }}: {{ $atendidas }} atendidas, {{ $programadas }} programadas, {{ $canceladas }} canceladas">
                                @if($canceladas > 0)
                                    <div class="w-full bg-error transition-all duration-500" style="height: {{ ($canceladas / $cita) * 100 }}%"></div>
                                @endif
                                @if($programadas > 0)
                                    <div class="w-full bg-primary-container transition-all duration-500" style="height: {{ ($programadas / $cita) * 100 }}%"></div>
                                @endif
                                @if($atendidas > 0)
                                    <div class="w-full bg-secondary transition-all duration-500" style="height: {{ ($atendidas / $cita) * 100 }}%"></div>
                                @endif
                            </div>
                            <span class="{{ $labelClass }} text-on-surface-variant mt-1 truncate w-full text-center">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
                <p class="mt-3 text-[11px] text-on-surface-variant leading-relaxed">
                    Verde: citas atendidas. Azul oscuro: agendadas, confirmadas o en curso. Rojo: canceladas o no asistió.
                </p>
            @else
                <div class="h-64 flex items-center justify-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-4xl text-outline mr-2">info</span>
                    No hay datos para mostrar
                </div>
            @endif
        </div>

        {{-- Ingresos --}}
        <div class="bg-surface p-6 rounded-xl border border-outline-variant shadow-sm">
            @php
                $ingresosEfectivo = $ingresosEfectivo ?? [];
                $ingresosTarjeta = $ingresosTarjeta ?? [];
                $ingresosTransferencia = $ingresosTransferencia ?? [];
                $totalEfectivo = array_sum($ingresosEfectivo);
                $totalTarjeta = array_sum($ingresosTarjeta);
                $totalTransferencia = array_sum($ingresosTransferencia);
                $maxIngresos = count($ingresosPorDia) ? max($ingresosPorDia) : 0;
                $maxIngresos = $maxIngresos > 0 ? $maxIngresos : 1;
                $totalPuntosIngresos = count($ingresosPorDia);
                $isMes = $periodo === 'mes';
                $barClass = $isMes ? 'gap-0.5' : 'gap-2';
                $labelClass = $isMes ? 'text-[8px]' : 'text-xs';
                $hayIngresos = $totalPuntosIngresos > 0 && ($totalPuntosIngresos > 1 || ($ingresosPorDia[0] ?? 0) > 0);
            @endphp
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-4">
                <h3 class="font-headline-md text-headline-md text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">trending_up</span>
                    Ingresos por método
                </h3>
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1" role="list" aria-label="Leyenda de ingresos">
                    <span class="inline-flex items-center gap-1.5 text-xs text-on-surface-variant" role="listitem">
                        <span class="w-2.5 h-2.5 rounded-sm bg-secondary shrink-0"></span>
                        Efectivo (${{ number_format($totalEfectivo, 0) }})
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-xs text-on-surface-variant" role="listitem">
                        <span class="w-2.5 h-2.5 rounded-sm bg-primary-container shrink-0"></span>
                        Tarjeta (${{ number_format($totalTarjeta, 0) }})
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-xs text-on-surface-variant" role="listitem">
                        <span class="w-2.5 h-2.5 rounded-sm bg-amber-500 shrink-0"></span>
                        Transferencia (${{ number_format($totalTransferencia, 0) }})
                    </span>
                </div>
            </div>

            @if($hayIngresos)
                <div class="h-64 flex items-end {{ $barClass }}">
                    @foreach($ingresosPorDia as $index => $ingreso)
                        @php
                            $efectivo = $ingresosEfectivo[$index] ?? 0;
                            $tarjeta = $ingresosTarjeta[$index] ?? 0;
                            $transferencia = $ingresosTransferencia[$index] ?? 0;
                            $height = ($ingreso / $maxIngresos) * 170;
                            $label = $labels[$index] ?? '';
                        @endphp
                        <div class="flex-1 min-w-0 flex flex-col items-center justify-end h-full">
                            @if($ingreso > 0 && !$isMes)
                                <span class="text-[10px] font-medium text-on-surface mb-1">${{ number_format($ingreso, 0) }}</span>
                            @endif
                            <div class="w-full max-w-[2.5rem] rounded-t overflow-hidden bg-surface-container-low"
                                 style="height: {{ max($height, $ingreso > 0 ? 8 : 2) }}px;"
                                 title="{{ $label }}: Efectivo ${{ number_format($efectivo, 2) }}, Tarjeta ${{ number_format($tarjeta, 2) }}, Transferencia ${{ number_format($transferencia, 2) }}">
                                @if($transferencia > 0)
                                    <div class="w-full bg-amber-500 transition-all duration-500" style="height: {{ ($transferencia / $ingreso) * 100 }}%"></div>
                                @endif
                                @if($tarjeta > 0)
                                    <div class="w-full bg-primary-container transition-all duration-500" style="height: {{ ($tarjeta / $ingreso) * 100 }}%"></div>
                                @endif
                                @if($efectivo > 0)
                                    <div class="w-full bg-secondary transition-all duration-500" style="height: {{ ($efectivo / $ingreso) * 100 }}%"></div>
                                @endif
                            </div>
                            <span class="{{ $labelClass }} text-on-surface-variant mt-1 truncate w-full text-center">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
                <p class="mt-3 text-[11px] text-on-surface-variant leading-relaxed">
                    Verde: efectivo. Azul oscuro: tarjeta. Ámbar: transferencia.
                </p>
            @else
                <div class="h-64 flex items-center justify-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-4xl text-outline mr-2">info</span>
                    No hay datos para mostrar
                </div>
            @endif
        </div>
    </div>

    {{-- Top colaboradores y últimas citas --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Top colaboradores --}}
        <div class="bg-surface p-6 rounded-xl border border-outline-variant shadow-sm">
            <h3 class="font-headline-md text-headline-md text-on-surface mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary">emoji_events</span>
                Top Colaboradores
            </h3>
            @if(count($topColaboradores) > 0)
                <div class="space-y-3">
                    @foreach($topColaboradores as $colaborador)
                        <div class="flex items-center justify-between p-3 bg-surface-container-low rounded-lg border border-outline-variant/50">
                            <div>
                                <span class="font-body-md text-body-md text-on-surface font-medium">{{ $colaborador->nombre }}</span>
                                <span class="text-xs text-on-surface-variant ml-2">({{ $colaborador->comision_porcentaje }}% comisión)</span>
                            </div>
                            <span class="font-headline-md text-headline-md text-secondary font-bold">
                                ${{ number_format($colaborador->citas_sum_monto_pagado ?? 0, 2) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-on-surface-variant">
                    <span class="material-symbols-outlined text-4xl text-outline block mb-2">emoji_events</span>
                    <p>No hay datos disponibles</p>
                </div>
            @endif
        </div>

        {{-- Últimas citas --}}
        <div class="bg-surface p-6 rounded-xl border border-outline-variant shadow-sm">
            <h3 class="font-headline-md text-headline-md text-on-surface mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">history</span>
                Últimas Citas
            </h3>
            @if(count($ultimasCitas) > 0)
                <div class="space-y-3 max-h-80 overflow-y-auto pr-2">
                    @foreach($ultimasCitas as $cita)
                        <div class="flex items-center justify-between p-3 bg-surface-container-low rounded-lg border border-outline-variant/50">
                            <div>
                                <div class="font-body-md text-body-md text-on-surface font-medium">{{ $cita->cliente->nombre ?? 'N/A' }}</div>
                                <div class="text-xs text-on-surface-variant">
                                    {{ $cita->servicio->nombre ?? 'Sin servicio' }} • 
                                    {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }} {{ $cita->hora_inicio }}
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-xs px-2 py-1 rounded-full 
                                    @if($cita->pagado) bg-secondary-container text-on-secondary-container @else bg-error-container text-error @endif">
                                    {{ $cita->pagado ? 'Pagado' : 'Pendiente' }}
                                </span>
                                <div class="font-body-sm text-body-sm text-secondary font-semibold mt-1">
                                    ${{ number_format($cita->monto_pagado ?? 0, 2) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-on-surface-variant">
                    <span class="material-symbols-outlined text-4xl text-outline block mb-2">event_busy</span>
                    <p>No hay citas recientes</p>
                </div>
            @endif
        </div>
    </div>
</div>