<div>
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">📊 Dashboard SuperAdmin</h2>
            <p class="text-sm text-gray-500">Última actualización: {{ now()->format('d/m/Y H:i') }}</p>
        </div>
        <button wire:click="abrirCrearEmpresa" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center shadow-md hover:shadow-lg transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nueva Empresa
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-500 hover:shadow-lg transition">
            <div class="text-sm text-gray-500">Total Empresas</div>
            <div class="text-2xl font-bold text-blue-600">{{ $stats['totalEmpresas'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500 hover:shadow-lg transition">
            <div class="text-sm text-gray-500">Empresas Activas</div>
            <div class="text-2xl font-bold text-green-600">{{ $stats['empresasActivas'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-500 hover:shadow-lg transition">
            <div class="text-sm text-gray-500">Empresas en Prueba</div>
            <div class="text-2xl font-bold text-yellow-600">{{ $stats['empresasPrueba'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-red-500 hover:shadow-lg transition">
            <div class="text-sm text-gray-500">Empresas Suspendidas</div>
            <div class="text-2xl font-bold text-red-600">{{ $stats['empresasSuspendidas'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-purple-500 hover:shadow-lg transition">
            <div class="text-sm text-gray-500">Cobro del Mes</div>
            <div class="text-2xl font-bold text-purple-600">${{ number_format($stats['cobroMes'] ?? 0, 2) }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
            <div class="text-sm text-gray-500">Ingresos Totales del Mes</div>
            <div class="text-2xl font-bold text-green-600">${{ number_format($stats['ingresosMes'] ?? 0, 2) }}</div>
            <div class="text-sm text-gray-400 mt-1">{{ $stats['citasMes'] ?? 0 }} citas realizadas</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
            <div class="text-sm text-gray-500">Empresas Inactivas</div>
            <div class="text-2xl font-bold text-gray-600">{{ $stats['empresasInactivas'] ?? 0 }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
            <div class="text-sm text-gray-500">Empresas por Plan</div>
            <div class="flex space-x-4 mt-1">
                @foreach(['basico' => '🟢', 'pro' => '🔵', 'empresa' => '🟣'] as $plan => $icono)
                    <div>
                        <span class="text-sm">{{ $icono }}</span>
                        <span class="text-sm font-bold">{{ $stats['empresasPorPlan'][$plan] ?? 0 }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">📈 Crecimiento de Empresas (Últimos 6 meses)</h3>
        <div class="flex items-end space-x-2 h-48">
            @foreach($stats['crecimientoMensual'] as $index => $cantidad)
                <div class="flex-1 flex flex-col items-center">
                    <div class="w-full bg-blue-200 rounded-t relative" 
                         style="height: {{ $stats['totalEmpresas'] > 0 ? ($cantidad / $stats['totalEmpresas'] * 100) + 20 : 20 }}px">
                        <div class="w-full bg-blue-600 rounded-t absolute bottom-0" 
                             style="height: {{ $stats['totalEmpresas'] > 0 ? $cantidad / $stats['totalEmpresas'] * 100 : 0 }}%">
                            <span class="absolute -top-5 left-1/2 transform -translate-x-1/2 text-xs font-bold text-blue-600">
                                {{ $cantidad }}
                            </span>
                        </div>
                    </div>
                    <span class="text-xs text-gray-600 mt-1">{{ $stats['labelsCrecimiento'][$index] ?? '' }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">🏢 Listado de Empresas</h3>
            <span class="text-sm text-gray-500">Total: {{ $empresas->total() }}</span>
        </div>

        <div class="p-4 bg-gray-50 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <div>
                    <label class="text-sm text-gray-600">Buscar</label>
                    <input type="text" wire:model.live.debounce.300ms="filtroBuscar" 
                           placeholder="Nombre, email o slug..." 
                           class="w-full border rounded-lg p-2 text-sm">
                </div>
                <div>
                    <label class="text-sm text-gray-600">Plan</label>
                    <select wire:model.live="filtroPlan" class="w-full border rounded-lg p-2 text-sm">
                        <option value="">Todos</option>
                        @foreach($planes as $plan)
                            <option value="{{ $plan }}">{{ ucfirst($plan) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Estatus</label>
                    <select wire:model.live="filtroEstatus" class="w-full border rounded-lg p-2 text-sm">
                        <option value="">Todos</option>
                        @foreach($estatuses as $estatus)
                            <option value="{{ $estatus }}">{{ ucfirst($estatus) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end space-x-2">
                    <button wire:click="limpiarFiltros" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm w-full">
                        Limpiar filtros
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empresa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contacto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estatus</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vencimiento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($empresas as $empresa)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($empresa->logo_url)
                                    <img src="{{ Storage::url($empresa->logo_url) }}" alt="{{ $empresa->nombre }}" 
                                         class="h-10 w-10 rounded-full object-cover mr-3 border border-gray-200">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center mr-3">
                                        <span class="text-white font-bold text-sm">{{ substr($empresa->nombre, 0, 2) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $empresa->nombre }}</div>
                                    <div class="text-xs text-gray-400">{{ $empresa->slug }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $empresa->email_contacto }}</div>
                            <div class="text-xs text-gray-400">{{ $empresa->telefono ?? 'Sin teléfono' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full font-medium
                                @if($empresa->plan == 'basico') bg-gray-100 text-gray-700
                                @elseif($empresa->plan == 'pro') bg-blue-100 text-blue-700
                                @else bg-purple-100 text-purple-700 @endif">
                                {{ ucfirst($empresa->plan) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <select wire:change="cambiarEstatus({{ $empresa->id }}, $event.target.value)"
                                    class="text-xs rounded-full px-2 py-1 border-0 font-semibold cursor-pointer focus:ring-2 focus:ring-offset-2
                                        @if($empresa->estatus == 'activo') bg-green-100 text-green-800 hover:bg-green-200
                                        @elseif($empresa->estatus == 'prueba') bg-yellow-100 text-yellow-800 hover:bg-yellow-200
                                        @elseif($empresa->estatus == 'suspendido') bg-red-100 text-red-800 hover:bg-red-200
                                        @else bg-gray-100 text-gray-800 hover:bg-gray-200 @endif">
                                @foreach($estatuses as $estatus)
                                    <option value="{{ $estatus }}" {{ $empresa->estatus == $estatus ? 'selected' : '' }}>
                                        {{ ucfirst($estatus) }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $empresa->fecha_vencimiento ? $empresa->fecha_vencimiento->format('d/m/Y') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-1">
                                <button wire:click="verDetallesEmpresa({{ $empresa->id }})" 
                                        class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                        title="Ver detalles">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>

                                {{-- 👈 BOTÓN EDITAR --}}
                                <button wire:click="abrirEditarEmpresa({{ $empresa->id }})" 
                                        class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                        title="Editar empresa">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>

                                {{-- 👈 BOTÓN ELIMINAR --}}
                                <button wire:click="eliminarEmpresa({{ $empresa->id }})" 
                                        onclick="confirm('¿Eliminar esta empresa? Esto eliminará todos sus datos.') || event.stopImmediatePropagation()"
                                        class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition"
                                        title="Eliminar empresa">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <p>No hay empresas registradas</p>
                            <p class="text-sm text-gray-400">Haz clic en "Nueva Empresa" para crear una</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $empresas->links() }}
        </div>
    </div>

    <livewire:superadmin.formulario-empresa />
    <livewire:superadmin.detalles-empresa />
</div>