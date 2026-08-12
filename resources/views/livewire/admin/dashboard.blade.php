<div>
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                @if($stats['rol'] === 'colaborador')
                    👤 Mi Dashboard
                @else
                    📊 Dashboard
                @endif
            </h2>
            <p class="text-sm text-gray-500">
                @if($stats['rol'] === 'colaborador')
                    Resumen de tus citas y comisiones
                @else
                    Resumen financiero del día
                @endif
            </p>
        </div>
        <div class="flex space-x-2">
            <button wire:click="cambiarPeriodo('semana')" 
                    class="px-3 py-1 rounded-lg text-sm {{ $periodo === 'semana' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
                Semana
            </button>
            <button wire:click="cambiarPeriodo('mes')" 
                    class="px-3 py-1 rounded-lg text-sm {{ $periodo === 'mes' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
                Mes
            </button>
            <button wire:click="cambiarPeriodo('año')" 
                    class="px-3 py-1 rounded-lg text-sm {{ $periodo === 'año' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
                Año
            </button>
        </div>
    </div>

    @if(in_array($stats['rol'], ['empresa_admin', 'recepcionista', 'super_admin']))
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-500">
            <div class="text-sm text-gray-500">Citas de Hoy</div>
            <div class="text-2xl font-bold text-blue-600">{{ $stats['citasHoy'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500">
            <div class="text-sm text-gray-500">Ingresos de Hoy</div>
            <div class="text-2xl font-bold text-green-600">${{ number_format($stats['ingresosHoy'], 2) }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-500">
            <div class="text-sm text-gray-500">Efectivo Hoy</div>
            <div class="text-2xl font-bold text-yellow-600">${{ number_format($stats['efectivoHoy'], 2) }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-purple-500">
            <div class="text-sm text-gray-500">Ganancia Neta</div>
            <div class="text-2xl font-bold text-purple-600">${{ number_format($stats['gananciaNeta'], 2) }}</div>
        </div>
    </div>
    @endif

    @if($stats['rol'] === 'colaborador')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-500">
            <div class="text-sm text-gray-500">Mis Citas de Hoy</div>
            <div class="text-2xl font-bold text-blue-600">{{ $stats['misCitasHoy'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-orange-500">
            <div class="text-sm text-gray-500">Pendientes</div>
            <div class="text-2xl font-bold text-orange-600">{{ $stats['misCitasPendientes'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500">
            <div class="text-sm text-gray-500">Mi Comisión de Hoy</div>
            <div class="text-2xl font-bold text-green-600">${{ number_format($stats['miComisionHoy'], 2) }}</div>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">
            @if($stats['rol'] === 'colaborador')
                Mis Citas e Ingresos
            @else
                Evolución de Citas e Ingresos
            @endif
        </h3>
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
                        <div class="w-full bg-blue-200 rounded-t" 
                             :style="'height:' + (citas[index] / maxCitas * 150) + 'px'">
                            <div class="w-full bg-blue-600 rounded-t h-full" 
                                 :style="'height:' + (citas[index] / maxCitas * 100) + '%'">
                            </div>
                        </div>
                        <div class="w-full bg-green-200 rounded-t" 
                             :style="'height:' + (ingresos[index] / maxIngresos * 150) + 'px'">
                            <div class="w-full bg-green-600 rounded-t h-full" 
                                 :style="'height:' + (ingresos[index] / maxIngresos * 100) + '%'">
                            </div>
                        </div>
                    </div>
                    <span class="text-xs text-gray-600 mt-1" x-text="label"></span>
                </div>
            </template>
        </div>
        <div class="flex justify-center space-x-4 mt-4">
            <div class="flex items-center">
                <div class="w-3 h-3 bg-blue-600 rounded mr-1"></div>
                <span class="text-xs">Citas</span>
            </div>
            <div class="flex items-center">
                <div class="w-3 h-3 bg-green-600 rounded mr-1"></div>
                <span class="text-xs">Ingresos</span>
            </div>
        </div>
    </div>

    @if(in_array($stats['rol'], ['empresa_admin', 'super_admin']))
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">🏆 Top Colaboradores</h3>
            @if(count($stats['topColaboradores']) > 0)
                <div class="space-y-3">
                    @foreach($stats['topColaboradores'] as $colaborador)
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="font-medium">{{ $colaborador->nombre }}</span>
                                <span class="text-xs text-gray-500 ml-2">{{ $colaborador->comision_porcentaje }}% comisión</span>
                            </div>
                            <span class="text-green-600 font-semibold">${{ number_format($colaborador->citas_sum_monto_pagado ?? 0, 2) }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm">No hay datos disponibles</p>
            @endif
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">📋 Últimas Citas</h3>
            @if(count($stats['ultimasCitas']) > 0)
                <div class="space-y-3">
                    @foreach($stats['ultimasCitas'] as $cita)
                        <div class="flex items-center justify-between text-sm">
                            <div>
                                <span class="font-medium">{{ $cita->cliente->nombre ?? 'N/A' }}</span>
                                <span class="text-gray-500 text-xs ml-2">{{ $cita->servicio->nombre ?? '' }}</span>
                            </div>
                            <div class="text-right">
                                <span class="text-gray-600">{{ $cita->fecha }}</span>
                                <span class="text-gray-400 text-xs ml-2">${{ number_format($cita->monto_pagado ?? 0, 2) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm">No hay citas recientes</p>
            @endif
        </div>
    </div>
    @endif
</div>