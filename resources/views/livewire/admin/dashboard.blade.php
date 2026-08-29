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
            <h3 class="font-headline-md text-headline-md text-on-surface mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary">bar_chart</span>
                Citas
            </h3>
            @php
                $maxCitas = max($citasPorDia) > 0 ? max($citasPorDia) : 1;
                $totalCitas = count($citasPorDia);
                $isMes = $periodo === 'mes';
                $barClass = $isMes ? 'space-x-0.5' : 'space-x-2';
                $labelClass = $isMes ? 'text-[8px]' : 'text-xs';
            @endphp

            @if($totalCitas > 1 || $citasPorDia[0] > 0)
                <div class="h-64 flex items-end {{ $barClass }}">
                    @foreach($citasPorDia as $index => $cita)
                        @php
                            $height = ($cita / $maxCitas) * 150; // altura máxima 150px
                            $label = $labels[$index] ?? '';
                        @endphp
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-secondary/20 rounded-t" style="height: {{ $height }}px;">
                                <div class="w-full bg-secondary rounded-t h-full transition-all duration-500" 
                                     style="height: {{ ($cita / $maxCitas) * 100 }}%;"></div>
                            </div>
                            <span class="{{ $labelClass }} text-on-surface-variant mt-1 truncate w-full text-center">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="h-64 flex items-center justify-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-4xl text-outline mr-2">info</span>
                    No hay datos para mostrar
                </div>
            @endif
        </div>

        {{-- Ingresos --}}
        <div class="bg-surface p-6 rounded-xl border border-outline-variant shadow-sm">
            <h3 class="font-headline-md text-headline-md text-on-surface mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">trending_up</span>
                Ingresos ($)
            </h3>
            @php
                $maxIngresos = max($ingresosPorDia) > 0 ? max($ingresosPorDia) : 1;
                $totalIngresos = count($ingresosPorDia);
                $isMes = $periodo === 'mes';
                $barClass = $isMes ? 'space-x-0.5' : 'space-x-2';
                $labelClass = $isMes ? 'text-[8px]' : 'text-xs';
            @endphp

            @if($totalIngresos > 1 || $ingresosPorDia[0] > 0)
                <div class="h-64 flex items-end {{ $barClass }}">
                    @foreach($ingresosPorDia as $index => $ingreso)
                        @php
                            $height = ($ingreso / $maxIngresos) * 150;
                            $label = $labels[$index] ?? '';
                        @endphp
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-primary/20 rounded-t" style="height: {{ $height }}px;">
                                <div class="w-full bg-primary rounded-t h-full transition-all duration-500" 
                                     style="height: {{ ($ingreso / $maxIngresos) * 100 }}%;"></div>
                            </div>
                            <span class="{{ $labelClass }} text-on-surface-variant mt-1 truncate w-full text-center">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
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