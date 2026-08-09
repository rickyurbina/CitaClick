<div>
    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">💇 Servicios</h2>
            <p class="text-sm text-gray-500">Gestiona los servicios de la empresa</p>
        </div>
        @if($esAdmin)
        <button wire:click="abrirCrear" 
                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nuevo Servicio
        </button>
        @endif
    </div>

    {{-- TARJETAS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-purple-500">
            <div class="text-sm text-gray-500">Total Servicios</div>
            <div class="text-2xl font-bold text-purple-600">{{ $totalServicios }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500">
            <div class="text-sm text-gray-500">Servicios Activos</div>
            <div class="text-2xl font-bold text-green-600">{{ $serviciosActivos }}</div>
        </div>
    </div>

    {{-- FILTROS --}}
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div>
                <label class="text-sm text-gray-600">Buscar</label>
                <input type="text" wire:model.live.debounce.300ms="filtroBuscar" 
                       placeholder="Nombre del servicio..." 
                       class="w-full border rounded-lg p-2 text-sm">
            </div>
            <div>
                <label class="text-sm text-gray-600">Estado</label>
                <select wire:model.live="filtroActivo" class="w-full border rounded-lg p-2 text-sm">
                    <option value="">Todos</option>
                    <option value="1">Activos</option>
                    <option value="0">Inactivos</option>
                </select>
            </div>
            <div class="flex items-end">
                <button wire:click="limpiarFiltros" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm w-full">
                    Limpiar filtros
                </button>
            </div>
        </div>
    </div>

    {{-- TABLA --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Servicio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Duración</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Puntos</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($servicios as $servicio)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $servicio->nombre }}</div>
                            <div class="text-xs text-gray-500">ID: #{{ $servicio->id }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $servicio->duracion_minutos }} min
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-semibold text-green-600">${{ number_format($servicio->precio, 2) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $servicio->puntos_genera }} pts
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($servicio->activo) bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ $servicio->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-1">
                                <button wire:click="abrirEditar({{ $servicio->id }})" 
                                        class="p-1.5 text-gray-400 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition"
                                        title="Editar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>

                                <button wire:click="toggleActivo({{ $servicio->id }})" 
                                        class="p-1.5 text-gray-400 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition"
                                        title="{{ $servicio->activo ? 'Desactivar' : 'Activar' }}">
                                    @if($servicio->activo)
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                    @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    @endif
                                </button>

                                <button wire:click="eliminar({{ $servicio->id }})" 
                                        onclick="confirm('¿Eliminar este servicio?') || event.stopImmediatePropagation()"
                                        class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition"
                                        title="Eliminar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <p>No hay servicios registrados</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t">
            {{ $servicios->links() }}
        </div>
    </div>

    {{-- MODAL FORMULARIO --}}
    @if($mostrarModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
         x-data="modalServicio()" x-init="init()" @click.self="cerrar()">
        <div class="bg-white rounded-xl max-w-lg w-full max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="sticky top-0 bg-white z-10 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800">
                    {{ $servicioIdEditar ? '✏️ Editar Servicio' : '💇 Nuevo Servicio' }}
                </h3>
                <button type="button" wire:click="cerrarModal" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="guardar" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                    <input type="text" wire:model="nombre" class="w-full border rounded-lg p-2" placeholder="Ej: Corte de cabello">
                    @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Duración (minutos) *</label>
                    <input type="number" min="5" step="5" wire:model="duracion" class="w-full border rounded-lg p-2">
                    @error('duracion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Precio *</label>
                    <input type="number" step="0.01" min="0" wire:model="precio" class="w-full border rounded-lg p-2" placeholder="0.00">
                    @error('precio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Puntos que genera</label>
                    <input type="number" min="0" wire:model="puntos" class="w-full border rounded-lg p-2" placeholder="10">
                    @error('puntos') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <p class="text-xs text-gray-400 mt-1">Puntos que recibe el cliente al agendar esta cita</p>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" wire:model="activo" id="activo" class="rounded border-gray-300">
                    <label for="activo" class="ml-2 text-sm text-gray-700">Activo</label>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" wire:click="cerrarModal" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg"
                            wire:loading.attr="disabled">
                        <span wire:loading.remove>{{ $servicioIdEditar ? 'Actualizar' : 'Guardar' }}</span>
                        <span wire:loading>Guardando...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('modalServicio', () => ({
                init() { document.body.style.overflow = 'hidden'; },
                cerrar() { @this.cerrarModal(); },
                destroy() { document.body.style.overflow = 'auto'; }
            }));
        });
        document.addEventListener('livewire:initialized', () => {
            @this.on('modal-cerrado', () => { document.body.style.overflow = 'auto'; });
            @this.on('modal-abierto', () => { document.body.style.overflow = 'hidden'; });
        });
    </script>
    @endpush
</div>