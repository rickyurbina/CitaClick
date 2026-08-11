<div class="max-w-container-max mx-auto">
    <div class="flex justify-between items-end mb-xl">
        <div>
            <h1 class="font-headline-lg text-headline-lg text-on-surface">Dashboard</h1>
            <p class="text-on-surface-variant font-body-md">Resumen financiero del día y tendencias recientes.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-lg mb-xl">
        <div class="bg-surface-container-lowest rounded-xl p-lg border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-surface-container-low rounded-lg">
                    <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">account_balance_wallet</span>
                </div>
            </div>
            <p class="text-on-surface-variant font-label-md mb-1">Efectivo de hoy</p>
            <h3 class="font-headline-md text-headline-md text-on-surface">${{ number_format($ingresosHoy, 2) }}</h3>
        </div>

        <div class="bg-surface-container-lowest rounded-xl p-lg border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-surface-container-low rounded-lg">
                    <span class="material-symbols-outlined text-error" style="font-variation-settings: 'FILL' 1;">money_off</span>
                </div>
            </div>
            <p class="text-on-surface-variant font-label-md mb-1">Comisiones a pagar</p>
            <h3 class="font-headline-md text-headline-md text-error">-${{ number_format($comisionesHoy, 2) }}</h3>
        </div>

        <div class="bg-surface-container-lowest rounded-xl p-lg border-2 border-secondary shadow-lg relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 -mr-16 -mt-16 bg-secondary opacity-5 rounded-full"></div>
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-secondary-container rounded-lg">
                    <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">payments</span>
                </div>
                <span class="px-2 py-1 bg-secondary text-on-secondary rounded text-[10px] font-bold tracking-wider uppercase">Neto</span>
            </div>
            <p class="text-on-surface-variant font-label-md mb-1">Ganancia neta</p>
            <h3 class="font-headline-md text-headline-md text-secondary font-extrabold">${{ number_format($gananciaNetaHoy, 2) }}</h3>
        </div>

        <div class="bg-surface-container-lowest rounded-xl p-lg border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-surface-container-low rounded-lg">
                    <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">analytics</span>
                </div>
            </div>
            <p class="text-on-surface-variant font-label-md mb-1">Margen de beneficio</p>
            <h3 class="font-headline-md text-headline-md text-on-surface">{{ $margen }}%</h3>
        </div>
    </div>

    <div class="bg-surface-container-lowest rounded-xl p-lg border border-outline-variant shadow-sm mb-xl">
        <h2 class="font-headline-md text-label-md text-on-surface mb-6">Ganancias de los últimos 7 días</h2>

        @php $max = $gananciasSemana->max('total') ?: 1; @endphp

        <div class="flex items-end gap-3 h-48">
            @foreach ($gananciasSemana as $dia)
                <div class="flex-1 flex flex-col items-center justify-end h-full">
                    <span class="font-label-sm text-label-sm text-on-surface-variant mb-1">${{ number_format($dia['total'], 0) }}</span>
                    <div class="w-full bg-secondary rounded-t"
                         style="height: {{ $max > 0 ? ($dia['total'] / $max) * 100 : 0 }}%"></div>
                    <span class="font-label-sm text-label-sm text-on-surface-variant mt-1">{{ $dia['fecha'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-xl">
        <div class="bg-surface-container-lowest rounded-xl p-lg border border-outline-variant shadow-sm">
            <h2 class="font-headline-md text-label-md text-on-surface mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary">emoji_events</span>
                Colaboradores con más ingresos hoy
            </h2>

            @forelse ($topColaboradores as $item)
                <div class="flex justify-between py-3 border-b border-outline-variant last:border-0">
                    <span class="font-body-md text-body-md text-on-surface">{{ $item->colaborador->nombre ?? 'Sin nombre' }}</span>
                    <span class="font-label-md text-label-md text-secondary">${{ number_format($item->total, 2) }}</span>
                </div>
            @empty
                <p class="font-body-sm text-body-sm text-on-surface-variant">Todavía no hay ingresos registrados hoy.</p>
            @endforelse
        </div>

        <div class="bg-surface-container-lowest rounded-xl p-lg border border-outline-variant shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h2 class="font-headline-md text-label-md text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary">receipt_long</span>
                    Últimas entradas de efectivo
                </h2>
                <button wire:click="$dispatch('cambiarSeccion', { seccion: 'citas' })"
                        type="button"
                        class="font-label-sm text-label-sm text-secondary hover:underline">
                    Ver todas
                </button>
            </div>

            @forelse ($ultimasEntradas as $cita)
                <div class="flex justify-between py-3 border-b border-outline-variant last:border-0">
                    <div>
                        <p class="font-label-md text-label-md text-on-surface">{{ $cita->cliente->nombre ?? 'Cliente' }}</p>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">{{ $cita->servicio->nombre ?? '' }} · {{ $cita->colaborador->nombre ?? '' }}</p>
                    </div>
                    <span class="font-label-md text-label-md text-on-surface">${{ number_format($cita->monto_pagado, 2) }}</span>
                </div>
            @empty
                <p class="font-body-sm text-body-sm text-on-surface-variant">Sin movimientos todavía hoy.</p>
            @endforelse
        </div>
    </div>
</div>
