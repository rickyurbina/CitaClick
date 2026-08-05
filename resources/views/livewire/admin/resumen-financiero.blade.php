<div>
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-500">Efectivo de hoy</p>
            <p class="text-2xl font-bold">${{ number_format($ingresosHoy, 2) }}</p>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-500">Comisiones a pagar</p>
            <p class="text-2xl font-bold text-red-600">-${{ number_format($comisionesHoy, 2) }}</p>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-500">Ganancia neta</p>
            <p class="text-2xl font-bold text-green-600">${{ number_format($gananciaNetaHoy, 2) }}</p>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-sm text-gray-500">Margen de beneficio</p>
            <p class="text-2xl font-bold">{{ $margen }}%</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow mb-8">
        <h2 class="font-semibold mb-4">Ganancias de los últimos 7 días</h2>

        @php $max = $gananciasSemana->max('total') ?: 1; @endphp

        <div class="flex items-end gap-3 h-48">
            @foreach ($gananciasSemana as $dia)
                <div class="flex-1 flex flex-col items-center justify-end h-full">
                    <span class="text-xs text-gray-500 mb-1">${{ number_format($dia['total'], 0) }}</span>
                    <div class="w-full bg-blue-500 rounded-t"
                         style="height: {{ $max > 0 ? ($dia['total'] / $max) * 100 : 0 }}%"></div>
                    <span class="text-xs text-gray-400 mt-1">{{ $dia['fecha'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="font-semibold mb-4">Colaboradores con más ingresos hoy</h2>

            @forelse ($topColaboradores as $item)
                <div class="flex justify-between py-2 border-b last:border-0">
                    <span>{{ $item->colaborador->nombre ?? 'Sin nombre' }}</span>
                    <span class="font-medium">${{ number_format($item->total, 2) }}</span>
                </div>
            @empty
                <p class="text-gray-400 text-sm">Todavía no hay ingresos registrados hoy.</p>
            @endforelse
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold">Últimas entradas de efectivo</h2>
                <button wire:click="$dispatch('cambiarSeccion', { seccion: 'citas' })"
                        class="text-sm text-blue-600 hover:underline">
                    Ver todas
                </button>
            </div>

            @forelse ($ultimasEntradas as $cita)
                <div class="flex justify-between py-2 border-b last:border-0 text-sm">
                    <div>
                        <p class="font-medium">{{ $cita->cliente->nombre ?? 'Cliente' }}</p>
                        <p class="text-gray-400">{{ $cita->servicio->nombre ?? '' }} · {{ $cita->colaborador->nombre ?? '' }}</p>
                    </div>
                    <span class="font-medium">${{ number_format($cita->monto_pagado, 2) }}</span>
                </div>
            @empty
                <p class="text-gray-400 text-sm">Sin movimientos todavía hoy.</p>
            @endforelse
        </div>
    </div>
</div>