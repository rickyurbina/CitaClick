<div>
    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-md mb-xl">
        <div>
            <h2 class="font-headline-md text-headline-md text-on-surface">Colaboradores</h2>
            <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Gestiona los colaboradores de la empresa</p>
        </div>
        @if($esAdmin)
        <button wire:click="abrirCrear" type="button" class="inline-flex items-center gap-sm px-lg py-3 bg-secondary text-on-secondary font-label-md text-label-md rounded-lg hover:brightness-110 active:scale-95 transition-all shadow-md">
            <span class="material-symbols-outlined">person_add</span> Nuevo Colaborador
        </button>
        @endif
    </div>

    {{-- TARJETAS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-lg mb-xl">
        <div class="p-lg bg-surface border border-outline-variant rounded-xl shadow-sm flex items-center gap-lg">
            <div class="w-12 h-12 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
                <span class="material-symbols-outlined">group</span>
            </div>
            <div>
                <p class="text-label-sm text-on-surface-variant uppercase tracking-wider font-label-sm">Total Colaboradores</p>
                <h4 class="text-headline-md font-bold text-on-surface">{{ $totalColaboradores }}</h4>
            </div>
        </div>
        <div class="p-lg bg-surface border border-outline-variant rounded-xl shadow-sm flex items-center gap-lg">
            <div class="w-12 h-12 rounded-full bg-surface-container-high flex items-center justify-center text-secondary">
                <span class="material-symbols-outlined">check_circle</span>
            </div>
            <div>
                <p class="text-label-sm text-on-surface-variant uppercase tracking-wider font-label-sm">Colaboradores Activos</p>
                <h4 class="text-headline-md font-bold text-on-surface">{{ $colaboradoresActivos }}</h4>
            </div>
        </div>
    </div>

    {{-- FILTROS --}}
    <div class="bg-surface border border-outline-variant rounded-xl shadow-sm p-lg mb-xl">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
            <div class="flex flex-col gap-xs">
                <label class="font-label-sm text-label-sm text-on-surface-variant">Buscar</label>
                <input type="text" wire:model.live.debounce.300ms="filtroBuscar" placeholder="Nombre, email o teléfono..." class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface bg-surface-container-lowest focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
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
                        <th class="px-lg py-4 font-label-md text-label-md text-on-surface">Colaborador</th>
                        <th class="px-lg py-4 font-label-md text-label-md text-on-surface">Contacto</th>
                        <th class="px-lg py-4 font-label-md text-label-md text-on-surface">Horario</th>
                        <th class="px-lg py-4 font-label-md text-label-md text-on-surface">Comisión</th>
                        <th class="px-lg py-4 font-label-md text-label-md text-on-surface">Estado</th>
                        <th class="px-lg py-4 font-label-md text-label-md text-on-surface">Servicios</th>
                        <th class="px-lg py-4 font-label-md text-label-md text-on-surface text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($colaboradores as $colaborador)
                    <tr class="hover:bg-surface-container-low transition-colors group">
                        <td class="px-lg py-4">
                            <div class="flex items-center gap-md">
                                <div class="w-8 h-8 rounded bg-primary-container text-on-primary-container flex items-center justify-center">
                                    <span class="material-symbols-outlined text-sm">person</span>
                                </div>
                                <div>
                                    <span class="font-body-md font-semibold text-on-surface">{{ $colaborador->nombre }}</span>
                                    <div class="font-body-sm text-body-sm text-on-surface-variant">ID: #{{ $colaborador->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-lg py-4">
                            <div class="font-body-md text-body-md text-on-surface">{{ $colaborador->email }}</div>
                            <div class="font-body-sm text-body-sm text-on-surface-variant">{{ $colaborador->telefono ?? 'Sin teléfono' }}</div>
                        </td>
                        <td class="px-lg py-4 font-body-md text-body-md text-on-surface-variant">{{ $colaborador->horario_inicio }} - {{ $colaborador->horario_fin }}</td>
                        <td class="px-lg py-4 font-body-md text-body-md text-on-surface">{{ $colaborador->comision_porcentaje ? $colaborador->comision_porcentaje . '%' : 'N/A' }}</td>
                        <td class="px-lg py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium @if($colaborador->activo) bg-secondary-container text-on-secondary-container @else bg-error-container text-on-error-container @endif">
                                {{ $colaborador->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="px-lg py-4 font-body-md text-body-md text-on-surface-variant">{{ $colaborador->servicios->count() }}</td>
                        <td class="px-lg py-4 text-right">
                            <div class="flex justify-end gap-sm">
                                <button wire:click="abrirEditar({{ $colaborador->id }})" class="p-2 text-on-surface-variant hover:bg-secondary-container hover:text-on-secondary-container rounded transition-colors" title="Editar"><span class="material-symbols-outlined">edit</span></button>
                                <button wire:click="toggleActivo({{ $colaborador->id }})" class="p-2 text-on-surface-variant hover:bg-surface-container-high rounded transition-colors" title="{{ $colaborador->activo ? 'Desactivar' : 'Activar' }}">
                                    @if($colaborador->activo) <span class="material-symbols-outlined">block</span> @else <span class="material-symbols-outlined">check_circle</span> @endif
                                </button>
                                <button wire:click="eliminar({{ $colaborador->id }})" onclick="confirm('¿Eliminar este colaborador?') || event.stopImmediatePropagation()" class="p-2 text-on-surface-variant hover:bg-error-container hover:text-error rounded transition-colors" title="Eliminar"><span class="material-symbols-outlined">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-lg py-2xl text-center text-on-surface-variant"><span class="material-symbols-outlined text-4xl text-outline mb-3 block">group_off</span><p class="font-body-md text-body-md">No hay colaboradores registrados</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-lg py-md border-t border-outline-variant bg-surface-container-low">{{ $colaboradores->links() }}</div>
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
                    <span class="material-symbols-outlined text-secondary">{{ $colaboradorIdEditar ? 'edit' : 'person_add' }}</span>
                    {{ $colaboradorIdEditar ? 'Editar Colaborador' : 'Nuevo Colaborador' }}
                </h3>
                <button type="button" wire:click="cerrarModal" class="p-2 text-on-surface-variant hover:bg-surface-container-high rounded-lg transition-colors"><span class="material-symbols-outlined">close</span></button>
            </div>
            <form wire:submit.prevent="guardar" class="p-lg space-y-md">
                <div class="flex flex-col gap-xs">
                    <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Nombre *</label>
                    <input type="text" wire:model="nombre" class="w-full h-12 px-md border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all font-body-md text-body-md text-on-surface">
                    @error('nombre') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col gap-xs">
                    <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Email *</label>
                    <input type="email" wire:model="email" class="w-full h-12 px-md border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all font-body-md text-body-md text-on-surface">
                    @error('email') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col gap-xs">
                    <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Teléfono</label>
                    <input type="tel" wire:model="telefono" class="w-full h-12 px-md border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all font-body-md text-body-md text-on-surface">
                    @error('telefono') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col gap-xs">
                    <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">{{ $colaboradorIdEditar ? 'Nueva Contraseña (opcional)' : 'Contraseña *' }}</label>
                    <input type="password" wire:model="password" class="w-full h-12 px-md border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all font-body-md text-body-md text-on-surface">
                    @error('password') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                    @if($colaboradorIdEditar)<p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Dejar en blanco para mantener la actual</p>@endif
                </div>
                <div class="flex flex-col gap-xs">
                    <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Comisión (%)</label>
                    <input type="number" step="0.01" min="0" max="100" wire:model="comision" class="w-full h-12 px-md border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all font-body-md text-body-md text-on-surface" placeholder="Ej: 10">
                    @error('comision') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-2 gap-md">
                    <div class="flex flex-col gap-xs">
                        <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Hora inicio</label>
                        <input type="time" wire:model="horarioInicio" class="w-full h-12 px-md border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all font-body-md text-body-md text-on-surface">
                        @error('horarioInicio') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-xs">
                        <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Hora fin</label>
                        <input type="time" wire:model="horarioFin" class="w-full h-12 px-md border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all font-body-md text-body-md text-on-surface">
                        @error('horarioFin') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="flex flex-col gap-xs">
                    <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Servicios que realiza *</label>
                    <p class="font-body-sm text-body-sm text-on-surface-variant mb-2">Selecciona al menos un servicio</p>
                    <div class="space-y-2 max-h-40 overflow-y-auto border border-outline-variant rounded-lg p-2 bg-surface">
                        @foreach($serviciosDisponibles as $servicio)
                        <label class="flex items-center hover:bg-surface-container-low p-1 rounded cursor-pointer">
                            <input type="checkbox" wire:model="serviciosSeleccionados" value="{{ $servicio->id }}" class="rounded border-outline-variant text-secondary focus:ring-secondary">
                            <span class="ml-2 font-body-sm text-body-sm text-on-surface">{{ $servicio->nombre }}</span>
                            <span class="ml-auto font-label-sm text-label-sm text-on-surface-variant">${{ number_format($servicio->precio, 2) }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('serviciosSeleccionados') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" wire:model="activo" id="activo" class="w-4 h-4 text-secondary border-outline-variant rounded focus:ring-secondary">
                    <label for="activo" class="font-body-sm text-body-sm text-on-surface">Activo</label>
                </div>
                <div class="flex justify-end gap-sm pt-md border-t border-outline-variant">
                    <button type="button" wire:click="cerrarModal" class="px-lg py-sm rounded-lg border border-outline-variant text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high transition-colors">Cancelar</button>
                    <button type="submit" class="px-lg py-sm rounded-lg bg-secondary text-on-secondary font-label-md text-label-md hover:opacity-90 transition-opacity" wire:loading.attr="disabled">
                        <span wire:loading.remove>{{ $colaboradorIdEditar ? 'Actualizar' : 'Guardar' }}</span>
                        <span wire:loading>Guardando...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>