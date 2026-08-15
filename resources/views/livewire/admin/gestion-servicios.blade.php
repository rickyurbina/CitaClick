<div>
    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-md mb-xl">
        <div>
            <h2 class="font-headline-md text-headline-md text-on-surface">Servicios</h2>
            <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Gestiona los servicios de la empresa</p>
        </div>
        @if($esAdmin)
        <button wire:click="abrirCrear" type="button" class="inline-flex items-center gap-sm px-lg py-3 bg-secondary text-on-secondary font-label-md text-label-md rounded-lg hover:brightness-110 active:scale-95 transition-all shadow-md">
            <span class="material-symbols-outlined">add</span> Nuevo Servicio
        </button>
        @endif
    </div>

    {{-- TARJETAS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-lg mb-xl">
        <div class="p-lg bg-surface border border-outline-variant rounded-xl shadow-sm flex items-center gap-lg">
            <div class="w-12 h-12 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
                <span class="material-symbols-outlined">inventory_2</span>
            </div>
            <div>
                <p class="text-label-sm text-on-surface-variant uppercase tracking-wider font-label-sm">Total Servicios</p>
                <h4 class="text-headline-md font-bold text-on-surface">{{ $totalServicios }}</h4>
            </div>
        </div>
        <div class="p-lg bg-surface border border-outline-variant rounded-xl shadow-sm flex items-center gap-lg">
            <div class="w-12 h-12 rounded-full bg-surface-container-high flex items-center justify-center text-secondary">
                <span class="material-symbols-outlined">check_circle</span>
            </div>
            <div>
                <p class="text-label-sm text-on-surface-variant uppercase tracking-wider font-label-sm">Servicios Activos</p>
                <h4 class="text-headline-md font-bold text-on-surface">{{ $serviciosActivos }}</h4>
            </div>
        </div>
    </div>

    {{-- FILTROS --}}
    <div class="bg-surface border border-outline-variant rounded-xl shadow-sm p-lg mb-xl">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
            <div class="flex flex-col gap-xs">
                <label class="font-label-sm text-label-sm text-on-surface-variant">Buscar</label>
                <input type="text" wire:model.live.debounce.300ms="filtroBuscar" placeholder="Nombre del servicio..." class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface bg-surface-container-lowest focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
            </div>
            <div class="flex flex-col gap-xs">
                <label class="font-label-sm text-label-sm text-on-surface-variant">Estado</label>
                <select wire:model.live="filtroActivo" class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface bg-surface-container-lowest focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                    <option value="">Todos</option>
                    <option value="1">Activos</option>
                    <option value="0">Inactivos</option>
                </select>
            </div>
            <div class="flex items-end">
                <button wire:click="limpiarFiltros" type="button" class="w-full flex items-center justify-center gap-2 px-md py-2 rounded-lg border border-outline text-on-surface hover:bg-surface-container-low transition-colors font-label-md text-label-md">
                    <span class="material-symbols-outlined text-[18px]">filter_alt_off</span> Limpiar filtros
                </button>
            </div>
        </div>
    </div>

    {{-- TABLA --}}
    <div class="bg-surface border border-outline-variant rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low border-b border-outline-variant">
                        <th class="px-lg py-4 font-label-md text-label-md text-on-surface">Servicio</th>
                        <th class="px-lg py-4 font-label-md text-label-md text-on-surface">Duración</th>
                        <th class="px-lg py-4 font-label-md text-label-md text-on-surface">Precio</th>
                        <th class="px-lg py-4 font-label-md text-label-md text-on-surface">Puntos</th>
                        <th class="px-lg py-4 font-label-md text-label-md text-on-surface">Estado</th>
                        <th class="px-lg py-4 font-label-md text-label-md text-on-surface text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($servicios as $servicio)
                    <tr class="hover:bg-surface-container-low transition-colors group">
                        <td class="px-lg py-4">
                            <div class="flex items-center gap-md">
                                <div class="w-8 h-8 rounded bg-primary-container text-on-primary-container flex items-center justify-center">
                                    <span class="material-symbols-outlined text-sm">content_cut</span>
                                </div>
                                <div>
                                    <span class="font-body-md font-semibold text-on-surface">{{ $servicio->nombre }}</span>
                                    <div class="font-body-sm text-body-sm text-on-surface-variant">ID: #{{ $servicio->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-lg py-4 font-body-md text-body-md text-on-surface-variant">{{ $servicio->duracion_minutos }} min</td>
                        <td class="px-lg py-4 font-body-md text-body-md text-on-surface font-semibold">${{ number_format($servicio->precio, 2) }}</td>
                        <td class="px-lg py-4 font-body-md text-body-md text-on-surface-variant">{{ $servicio->puntos_genera }} pts</td>
                        <td class="px-lg py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium @if($servicio->activo) bg-secondary-container text-on-secondary-container @else bg-error-container text-on-error-container @endif">
                                {{ $servicio->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="px-lg py-4 text-right">
                            <div class="flex justify-end gap-sm">
                                <button wire:click="abrirEditar({{ $servicio->id }})" class="p-2 text-on-surface-variant hover:bg-secondary-container hover:text-on-secondary-container rounded transition-colors" title="Editar"><span class="material-symbols-outlined">edit</span></button>
                                <button wire:click="toggleActivo({{ $servicio->id }})" class="p-2 text-on-surface-variant hover:bg-surface-container-high rounded transition-colors" title="{{ $servicio->activo ? 'Desactivar' : 'Activar' }}">
                                    @if($servicio->activo) <span class="material-symbols-outlined">block</span> @else <span class="material-symbols-outlined">check_circle</span> @endif
                                </button>
                                <button wire:click="eliminar({{ $servicio->id }})" onclick="confirm('¿Eliminar este servicio?') || event.stopImmediatePropagation()" class="p-2 text-on-surface-variant hover:bg-error-container hover:text-error rounded transition-colors" title="Eliminar"><span class="material-symbols-outlined">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-lg py-2xl text-center text-on-surface-variant"><span class="material-symbols-outlined text-4xl text-outline mb-3 block">inventory_2</span><p class="font-body-md text-body-md">No hay servicios registrados</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-lg py-md border-t border-outline-variant bg-surface-container-low">{{ $servicios->links() }}</div>
    </div>

    {{-- MODAL FORMULARIO --}}
    @if($mostrarModal)
    <div class="fixed inset-0 bg-on-surface/40 flex items-center justify-center z-50 p-4"
         x-data="{ open: true }"
         x-init="$watch('open', value => { if (!value) @this.cerrarModal(); })"
         @click.away="open = false">
        <div class="bg-surface-container-lowest rounded-xl border border-outline-variant max-w-lg w-full max-h-[90vh] overflow-y-auto shadow-lg">
            <div class="sticky top-0 bg-surface-container-lowest z-10 px-lg py-md border-b border-outline-variant flex justify-between items-center">
                <h3 class="font-headline-md text-headline-md text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary">{{ $servicioIdEditar ? 'edit' : 'add_box' }}</span>
                    {{ $servicioIdEditar ? 'Editar Servicio' : 'Nuevo Servicio' }}
                </h3>
                <button type="button" wire:click="cerrarModal" class="p-2 text-on-surface-variant hover:bg-surface-container-high rounded-lg transition-colors"><span class="material-symbols-outlined">close</span></button>
            </div>
            <form wire:submit.prevent="guardar" class="p-lg space-y-md">
                <div class="flex flex-col gap-xs">
                    <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Nombre *</label>
                    <input type="text" wire:model="nombre" class="w-full h-12 px-md border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all font-body-md text-body-md text-on-surface" placeholder="Ej: Corte de cabello">
                    @error('nombre') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col gap-xs">
                    <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Duración (minutos) *</label>
                    <input type="number" min="5" step="5" wire:model="duracion" class="w-full h-12 px-md border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all font-body-md text-body-md text-on-surface">
                    @error('duracion') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col gap-xs">
                    <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Precio *</label>
                    <input type="number" step="0.01" min="0" wire:model="precio" class="w-full h-12 px-md border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all font-body-md text-body-md text-on-surface" placeholder="0.00">
                    @error('precio') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col gap-xs">
                    <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Puntos que genera</label>
                    <input type="number" min="0" wire:model="puntos" class="w-full h-12 px-md border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all font-body-md text-body-md text-on-surface" placeholder="10">
                    @error('puntos') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Puntos que recibe el cliente al agendar esta cita</p>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" wire:model="activo" id="activo" class="w-4 h-4 text-secondary border-outline-variant rounded focus:ring-secondary">
                    <label for="activo" class="font-body-sm text-body-sm text-on-surface">Activo</label>
                </div>
                <div class="flex justify-end gap-sm pt-md border-t border-outline-variant">
                    <button type="button" wire:click="cerrarModal" class="px-lg py-sm rounded-lg border border-outline-variant text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high transition-colors">Cancelar</button>
                    <button type="submit" class="px-lg py-sm rounded-lg bg-secondary text-on-secondary font-label-md text-label-md hover:opacity-90 transition-opacity" wire:loading.attr="disabled">
                        <span wire:loading.remove>{{ $servicioIdEditar ? 'Actualizar' : 'Guardar' }}</span>
                        <span wire:loading>Guardando...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>