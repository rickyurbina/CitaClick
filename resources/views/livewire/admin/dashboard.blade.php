<div class="max-w-container-max mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-md mb-xl">
        <div>
            <h1 class="font-headline-lg text-headline-lg text-on-surface">Resumen Financiero</h1>
            <p class="text-on-surface-variant font-body-md">Análisis en tiempo real de ingresos y márgenes operativos.</p>
        </div>
        <div class="flex gap-sm">
            <button wire:click="cambiarPeriodo('semana')"
                    type="button"
                    class="px-md py-2 border border-outline-variant font-label-md text-label-md rounded-lg flex items-center gap-2 transition-colors
                        {{ $periodo === 'semana' ? 'bg-primary text-on-primary border-primary' : 'text-on-surface hover:bg-surface-container' }}">
                Semana
            </button>
            <button wire:click="cambiarPeriodo('mes')"
                    type="button"
                    class="px-md py-2 border border-outline-variant font-label-md text-label-md rounded-lg flex items-center gap-2 transition-colors
                        {{ $periodo === 'mes' ? 'bg-primary text-on-primary border-primary' : 'text-on-surface hover:bg-surface-container' }}">
                Mes
            </button>
            <button wire:click="cambiarPeriodo('año')"
                    type="button"
                    class="px-md py-2 border border-outline-variant font-label-md text-label-md rounded-lg flex items-center gap-2 transition-colors
                        {{ $periodo === 'año' ? 'bg-primary text-on-primary border-primary' : 'text-on-surface hover:bg-surface-container' }}">
                Año
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-lg mb-xl">
        <div class="bg-surface-container-lowest rounded-xl p-lg border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-surface-container-low rounded-lg">
                    <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">today</span>
                </div>
            </div>
            <p class="text-on-surface-variant font-label-md mb-1">Citas de Hoy</p>
            <h3 class="font-headline-md text-headline-md text-on-surface">{{ $stats['citasHoy'] }}</h3>
        </div>

        <div class="bg-surface-container-lowest rounded-xl p-lg border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-surface-container-low rounded-lg">
                    <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">account_balance_wallet</span>
                </div>
            </div>
            <p class="text-on-surface-variant font-label-md mb-1">Ingresos de Hoy</p>
            <h3 class="font-headline-md text-headline-md text-on-surface">${{ number_format($stats['ingresosHoy'], 2) }}</h3>
        </div>

        <div class="bg-surface-container-lowest rounded-xl p-lg border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-surface-container-low rounded-lg">
                    <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">payments</span>
                </div>
            </div>
            <p class="text-on-surface-variant font-label-md mb-1">Efectivo Hoy</p>
            <h3 class="font-headline-md text-headline-md text-on-surface">${{ number_format($stats['efectivoHoy'], 2) }}</h3>
        </div>

        <div class="bg-surface-container-lowest rounded-xl p-lg border-2 border-secondary shadow-lg relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 -mr-16 -mt-16 bg-secondary opacity-5 rounded-full"></div>
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-secondary-container rounded-lg">
                    <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">trending_up</span>
                </div>
                <span class="px-2 py-1 bg-secondary text-on-secondary rounded text-[10px] font-bold tracking-wider uppercase">En Tiempo Real</span>
            </div>
            <p class="text-on-surface-variant font-label-md mb-1">Ganancia Neta</p>
            <h3 class="font-headline-md text-headline-md text-secondary font-extrabold">${{ number_format($stats['gananciaNeta'], 2) }}</h3>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-xl">
        <div class="col-span-12 lg:col-span-8 bg-surface-container-lowest rounded-xl p-lg border border-outline-variant shadow-sm flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <h4 class="font-headline-md text-label-md text-on-surface">Evolución de Citas e Ingresos</h4>
                <div class="flex gap-2">
                    <span class="flex items-center gap-1 text-[12px] font-medium text-on-surface-variant">
                        <span class="w-3 h-3 rounded-full bg-primary"></span> Citas
                    </span>
                    <span class="flex items-center gap-1 text-[12px] font-medium text-on-surface-variant">
                        <span class="w-3 h-3 rounded-full bg-secondary"></span> Ingresos
                    </span>
                </div>
            </div>
            <div class="h-64 flex items-end space-x-2" x-data="{
                citas: {{ json_encode($stats['citasPorDia']) }},
                ingresos: {{ json_encode($stats['ingresosPorDia']) }},
                labels: {{ json_encode($stats['labels']) }},
                maxCitas: Math.max(...{{ json_encode($stats['citasPorDia']) }}, 1),
                maxIngresos: Math.max(...{{ json_encode($stats['ingresosPorDia']) }}, 1)
            }">
                <template x-for="(label, index) in labels" :key="index">
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-full flex flex-col items-center space-y-1">
                            <div class="w-full bg-primary-container/30 rounded-t"
                                 :style="'height:' + (citas[index] / maxCitas * 150) + 'px'">
                                <div class="w-full bg-primary rounded-t h-full"
                                     :style="'height:' + (citas[index] / maxCitas * 100) + '%'">
                                </div>
                            </div>
                            <div class="w-full bg-secondary-container/40 rounded-t"
                                 :style="'height:' + (ingresos[index] / maxIngresos * 150) + 'px'">
                                <div class="w-full bg-secondary rounded-t h-full"
                                     :style="'height:' + (ingresos[index] / maxIngresos * 100) + '%'">
                                </div>
                            </div>
                        </div>
                        <span class="text-xs text-on-surface-variant mt-1 font-label-sm" x-text="label"></span>
                    </div>
                </template>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-4 bg-surface-container-lowest rounded-xl p-lg border border-outline-variant shadow-sm flex flex-col">
            <h4 class="font-headline-md text-label-md text-on-surface mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary">emoji_events</span>
                Top Colaboradores
            </h4>
            @if(count($stats['topColaboradores']) > 0)
                <div class="flex-1 space-y-6 overflow-y-auto pr-2">
                    @foreach($stats['topColaboradores'] as $colaborador)
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-surface-container-low flex items-center justify-center">
                                        <span class="material-symbols-outlined text-primary text-[20px]">person</span>
                                    </div>
                                    <div>
                                        <p class="font-label-md text-on-surface">{{ $colaborador->nombre }}</p>
                                        <p class="text-[12px] text-on-surface-variant">{{ $colaborador->comision_porcentaje }}% comisión</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-label-md text-secondary">${{ number_format($colaborador->citas_sum_monto_pagado ?? 0, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="font-body-sm text-body-sm text-on-surface-variant">No hay datos disponibles</p>
            @endif
        </div>

        <div class="col-span-12 bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm overflow-hidden">
            <div class="p-lg border-b border-outline-variant flex justify-between items-center">
                <h4 class="font-headline-md text-label-md text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary">receipt_long</span>
                    Últimas Citas
                </h4>
            </div>
            @if(count($stats['ultimasCitas']) > 0)
                <div class="divide-y divide-outline-variant">
                    @foreach($stats['ultimasCitas'] as $cita)
                        <div class="px-lg py-4 flex items-center justify-between hover:bg-surface-container-low transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-bold text-[10px]">
                                    {{ strtoupper(substr($cita->cliente->nombre ?? 'C', 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-label-md text-on-surface">{{ $cita->cliente->nombre }}</p>
                                    <p class="text-[12px] text-on-surface-variant">{{ $cita->servicio->nombre }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-body-sm text-body-sm text-on-surface-variant">{{ $cita->fecha }}</p>
                                <p class="font-label-md text-on-surface">${{ number_format($cita->monto_pagado ?? 0, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-lg">
                    <p class="font-body-sm text-body-sm text-on-surface-variant">No hay citas recientes</p>
                </div>
            @endif
        </div>
    </div>
</div>
