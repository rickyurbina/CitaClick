<div>
    <div class="grid grid-cols-1 md:grid-cols-5 gap-lg mb-2xl">
        <div class="bg-surface p-lg rounded-xl border border-outline-variant col-span-1 shadow-sm">
            <div class="flex items-center justify-between mb-sm">
                <span class="text-on-surface-variant font-label-sm text-label-sm">Citas Hoy</span>
                <span class="material-symbols-outlined text-secondary">today</span>
            </div>
            <div class="font-headline-lg text-headline-lg text-primary">{{ $citasHoy }}</div>
        </div>
        <div class="bg-surface p-lg rounded-xl border border-outline-variant col-span-1 shadow-sm">
            <div class="flex items-center justify-between mb-sm">
                <span class="text-on-surface-variant font-label-sm text-label-sm">Ingresos Hoy</span>
                <span class="material-symbols-outlined text-secondary">payments</span>
            </div>
            <div class="font-headline-md text-headline-md text-primary">${{ number_format($ingresosHoy, 2) }}</div>
        </div>

        @if($puedeGestionar ?? false)
        <div wire:click="abrirCrearCita"
             class="bg-secondary-container p-lg rounded-xl border border-outline-variant col-span-1 relative overflow-hidden group cursor-pointer hover:opacity-90 transition-opacity">
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div>
                    <span class="material-symbols-outlined text-on-secondary-container mb-sm">calendar_add_on</span>
                    <div class="font-label-md text-label-md text-on-secondary-container">Nueva Cita</div>
                </div>
                <div class="mt-md">
                    <span class="bg-primary text-on-primary px-4 py-1 rounded font-label-sm text-label-sm">Agendar</span>
                </div>
            </div>
        </div>
        @endif

        @if($puedeCrearColaboradores ?? false)
        <div wire:click="abrirCrearColaborador"
             class="bg-secondary-container p-lg rounded-xl border border-outline-variant col-span-1 relative overflow-hidden group cursor-pointer hover:opacity-90 transition-opacity">
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div>
                    <span class="material-symbols-outlined text-on-secondary-container mb-sm">person_add</span>
                    <div class="font-label-md text-label-md text-on-secondary-container">Nuevo Colaborador</div>
                </div>
                <div class="mt-md">
                    <span class="bg-primary text-on-primary px-4 py-1 rounded font-label-sm text-label-sm">Añadir</span>
                </div>
            </div>
        </div>
        @endif

        @if($puedeCrearServicios ?? false)
        <div wire:click="abrirCrearServicio"
             class="bg-secondary-container p-lg rounded-xl border border-outline-variant col-span-1 relative overflow-hidden group cursor-pointer hover:opacity-90 transition-opacity">
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div>
                    <span class="material-symbols-outlined text-on-secondary-container mb-sm">add_box</span>
                    <div class="font-label-md text-label-md text-on-secondary-container">Nuevo Servicio</div>
                </div>
                <div class="mt-md">
                    <span class="bg-primary text-on-primary px-4 py-1 rounded font-label-sm text-label-sm">Crear</span>
                </div>
            </div>
        </div>
        @endif

        <div class="bg-surface p-lg rounded-xl border border-outline-variant col-span-1 shadow-sm">
            <div class="flex items-center justify-between mb-sm">
                <span class="text-on-surface-variant font-label-sm text-label-sm">Total Citas</span>
                <span class="material-symbols-outlined text-secondary">event_note</span>
            </div>
            <div class="font-headline-lg text-headline-lg text-primary">{{ $citas->total() }}</div>
        </div>
    </div>

    <div class="bg-surface rounded-xl border border-outline-variant overflow-hidden shadow-sm mb-lg">
        <div class="px-lg py-md border-b border-outline-variant">
            <h2 class="font-headline-md text-headline-md text-primary">Filtros</h2>
            <p class="font-body-sm text-body-sm text-on-surface-variant">Refine el listado de citas activas.</p>
        </div>
        <div class="p-lg">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-md">
                <div class="flex flex-col gap-xs">
                    <label class="font-label-sm text-label-sm text-on-surface-variant">Fecha</label>
                    <input type="date" wire:model.live="filtroFecha"
                           class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface bg-surface-container-lowest focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                </div>
                <div class="flex flex-col gap-xs">
                    <label class="font-label-sm text-label-sm text-on-surface-variant">Estado</label>
                    <select wire:model.live="filtroEstado"
                            class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface bg-surface-container-lowest focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                        <option value="">Todos</option>
                        <option value="agendada">Agendada</option>
                        <option value="confirmada">Confirmada</option>
                        <option value="en_curso">En curso</option>
                        <option value="atendida">Atendida</option>
                        <option value="cancelada">Cancelada</option>
                        <option value="no_asistio">No asistió</option>
                    </select>
                </div>
                <div class="flex flex-col gap-xs">
                    <label class="font-label-sm text-label-sm text-on-surface-variant">Colaborador</label>
                    <select wire:model.live="filtroColaborador"
                            class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface bg-surface-container-lowest focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                        <option value="">Todos</option>
                        @foreach($colaboradores as $colab)
                            <option value="{{ $colab->id }}">{{ $colab->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-xs">
                    <label class="font-label-sm text-label-sm text-on-surface-variant">Buscar cliente</label>
                    <input type="text" wire:model.live.debounce.300ms="buscarCliente"
                           placeholder="Nombre o teléfono..."
                           class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface bg-surface-container-lowest focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                </div>
            </div>
            <div class="mt-md">
                <button wire:click="limpiarFiltros" type="button"
                        class="flex items-center gap-2 px-md py-sm rounded-lg border border-outline text-on-surface hover:bg-surface-container-low transition-colors font-label-md text-label-md">
                    <span class="material-symbols-outlined text-[18px]">filter_alt_off</span>
                    Limpiar filtros
                </button>
            </div>
        </div>
    </div>

    <div class="bg-surface rounded-xl border border-outline-variant overflow-hidden shadow-sm">
        <div class="px-lg py-md flex flex-col md:flex-row justify-between items-start md:items-center gap-md border-b border-outline-variant">
            <div>
                <h2 class="font-headline-md text-headline-md text-primary">Listado de Citas</h2>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Gestione y supervise todas las citas activas.</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low border-b border-outline-variant">
                        <th class="px-lg py-md font-label-md text-label-md text-on-surface-variant">Cliente</th>
                        <th class="px-lg py-md font-label-md text-label-md text-on-surface-variant">Servicio</th>
                        <th class="px-lg py-md font-label-md text-label-md text-on-surface-variant">Colaborador</th>
                        <th class="px-lg py-md font-label-md text-label-md text-on-surface-variant">Fecha/Hora</th>
                        <th class="px-lg py-md font-label-md text-label-md text-on-surface-variant">Estado</th>
                        <th class="px-lg py-md font-label-md text-label-md text-on-surface-variant">Monto</th>
                        <th class="px-lg py-md font-label-md text-label-md text-on-surface-variant text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($citas as $cita)
                    <tr class="hover:bg-surface-container-lowest transition-colors">
                        <td class="px-lg py-md">
                            <div class="font-body-md text-body-md text-on-surface font-semibold">{{ $cita->cliente->nombre }}</div>
                            <div class="font-body-sm text-body-sm text-on-surface-variant">{{ $cita->cliente->telefono }}</div>
                        </td>
                        <td class="px-lg py-md">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-secondary"></div>
                                <div>
                                    <span class="font-body-md text-body-md text-on-surface">{{ $cita->servicio->nombre }}</span>
                                    <div class="font-body-sm text-body-sm text-on-surface-variant">{{ $cita->servicio->duracion_minutos }} min</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-lg py-md font-body-md text-body-md text-on-surface">
                            {{ $cita->colaborador->nombre }}
                        </td>
                        <td class="px-lg py-md">
                            <div class="font-body-md text-body-md text-on-surface">{{ $cita->fecha }}</div>
                            <div class="font-body-sm text-body-sm text-on-surface-variant">{{ $cita->hora_inicio }} - {{ $cita->hora_fin }}</div>
                        </td>
                        <td class="px-lg py-md">
                            <span class="px-sm py-1 text-label-sm font-label-sm rounded-full
                                @if($cita->estado == 'agendada') bg-surface-container-high text-on-surface
                                @elseif($cita->estado == 'confirmada') bg-secondary-container text-on-secondary-container
                                @elseif($cita->estado == 'en_curso') bg-primary-container text-on-primary-container
                                @elseif($cita->estado == 'atendida') bg-secondary-container text-on-secondary-container
                                @elseif($cita->estado == 'cancelada') bg-error-container text-on-error-container
                                @else bg-surface-container text-on-surface-variant @endif">
                                {{ ucfirst($cita->estado) }}
                            </span>
                        </td>
                        <td class="px-lg py-md">
                            <div class="font-label-md text-label-md {{ $cita->pagado ? 'text-secondary' : 'text-error' }}">
                                ${{ number_format($cita->monto_pagado ?? 0, 2) }}
                            </div>
                            <div class="font-body-sm text-body-sm text-on-surface-variant">
                                {{ $cita->pagado ? 'Pagado' : 'Pendiente' }}
                            </div>
                        </td>
                        <td class="px-lg py-md text-right">
                            <div class="flex justify-end gap-sm items-center">
                                @if($puedeGestionar ?? false)
                                    <button wire:click="editarCita({{ $cita->id }})"
                                            type="button"
                                            class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-container-high rounded-lg transition-all"
                                            title="Editar">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </button>
                                    <button wire:click="eliminarCita({{ $cita->id }})"
                                            onclick="confirm('¿Eliminar esta cita?') || event.stopImmediatePropagation()"
                                            type="button"
                                            class="p-2 text-on-surface-variant hover:text-error hover:bg-error-container rounded-lg transition-all"
                                            title="Eliminar">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                @endif

                                @if($esColaborador ?? false)
                                    <button wire:click="cambiarEstado({{ $cita->id }}, 'en_curso')"
                                            type="button"
                                            class="px-sm py-1 font-label-sm text-label-sm text-primary hover:bg-primary-container rounded-lg transition-colors">
                                        En curso
                                    </button>
                                    <button wire:click="cambiarEstado({{ $cita->id }}, 'atendida')"
                                            type="button"
                                            class="px-sm py-1 font-label-sm text-label-sm text-secondary hover:bg-secondary-container rounded-lg transition-colors">
                                        Atendida
                                    </button>
                                @endif

                                @if($puedeGestionar ?? false)
                                    <div class="relative group">
                                        <button type="button"
                                                class="p-2 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high rounded-lg transition-all font-label-sm text-label-sm flex items-center gap-1">
                                            Estados
                                            <span class="material-symbols-outlined text-[16px]">expand_more</span>
                                        </button>
                                        <div class="absolute right-0 hidden group-hover:block bg-surface-container-lowest border border-outline-variant shadow-lg rounded-lg p-2 z-10 min-w-32">
                                            @foreach(['agendada', 'confirmada', 'en_curso', 'atendida', 'cancelada', 'no_asistio'] as $estado)
                                                <button wire:click="cambiarEstado({{ $cita->id }}, '{{ $estado }}')"
                                                        type="button"
                                                        class="block w-full text-left px-3 py-1 font-body-sm text-body-sm text-on-surface hover:bg-surface-container-low rounded">
                                                    {{ ucfirst($estado) }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-lg py-2xl text-center font-body-md text-body-md text-on-surface-variant">
                            No hay citas registradas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-lg py-md bg-surface-container-low border-t border-outline-variant">
            {{ $citas->links() }}
        </div>
    </div>

    <!-- ==================== MODAL CITA ==================== -->
    @if($mostrarModalCita)
    <div class="fixed inset-0 bg-on-surface/40 flex items-center justify-center z-50 p-4">
        <div class="bg-surface-container-lowest rounded-xl border border-outline-variant max-w-md w-full max-h-[90vh] overflow-y-auto shadow-lg">
            <div class="p-lg">
                <h3 class="font-headline-md text-headline-md text-on-surface mb-lg flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary">event</span>
                    {{ $citaIdEditar ? 'Editar Cita' : 'Nueva Cita' }}
                </h3>

                <form wire:submit.prevent="guardarCita">
                    <div class="space-y-md">
                        <div class="flex flex-col gap-xs">
                            <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Cliente *</label>
                            <select wire:model="clienteId"
                                    class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                                <option value="">Seleccionar cliente</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }} - {{ $cliente->telefono }}</option>
                                @endforeach
                            </select>
                            @error('clienteId') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-xs">
                            <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Servicio *</label>
                            <select wire:model="servicioId"
                                    class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                                <option value="">Seleccionar servicio</option>
                                @foreach($servicios as $servicio)
                                    <option value="{{ $servicio->id }}">
                                        {{ $servicio->nombre }} - ${{ number_format($servicio->precio, 2) }}
                                        ({{ $servicio->duracion_minutos }} min)
                                    </option>
                                @endforeach
                            </select>
                            @error('servicioId') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-xs">
                            <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Colaborador *</label>
                            <select wire:model="colaboradorId"
                                    class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                                <option value="">Seleccionar colaborador</option>
                                @foreach($colaboradores as $colaborador)
                                    <option value="{{ $colaborador->id }}">
                                        {{ $colaborador->nombre }}
                                        @if($colaborador->comision_porcentaje)
                                            ({{ $colaborador->comision_porcentaje }}% comisión)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('colaboradorId') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-md">
                            <div class="flex flex-col gap-xs">
                                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Fecha *</label>
                                <input type="date" wire:model="fecha" min="{{ date('Y-m-d') }}"
                                       class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                                @error('fecha') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Hora *</label>
                                <input type="time" wire:model="horaInicio" step="900"
                                       class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                                @error('horaInicio') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex flex-col gap-xs">
                            <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Estado</label>
                            <select wire:model="estado"
                                    class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                                <option value="agendada">Agendada</option>
                                <option value="confirmada">Confirmada</option>
                                <option value="en_curso">En curso</option>
                                <option value="atendida">Atendida</option>
                                <option value="cancelada">Cancelada</option>
                                <option value="no_asistio">No asistió</option>
                            </select>
                            @error('estado') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-xs">
                            <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Monto</label>
                            <input type="number" step="0.01" min="0" wire:model="montoPagado"
                                   class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                            @error('montoPagado') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-xs">
                            <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Método de pago</label>
                            <select wire:model="metodoPago"
                                    class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                                <option value="">No especificado</option>
                                <option value="efectivo">Efectivo</option>
                                <option value="transferencia">Transferencia</option>
                                <option value="tarjeta">Tarjeta</option>
                            </select>
                            @error('metodoPago') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center gap-2">
                            <input type="checkbox" wire:model="pagado" id="pagado"
                                   class="w-4 h-4 text-secondary border-outline-variant rounded focus:ring-secondary">
                            <label for="pagado" class="font-body-sm text-body-sm text-on-surface">¿Pagado?</label>
                        </div>
                    </div>

                    <div class="flex justify-end gap-sm mt-lg pt-md border-t border-outline-variant">
                        <button type="button" wire:click="cerrarModalCita"
                                class="px-lg py-sm rounded-lg border border-outline-variant text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high transition-colors">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-lg py-sm rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:opacity-90 transition-opacity">
                            {{ $citaIdEditar ? 'Actualizar' : 'Guardar' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- ==================== MODAL COLABORADOR ==================== -->
    @if($mostrarModalColaborador)
    <div class="fixed inset-0 bg-on-surface/40 flex items-center justify-center z-50 p-4">
        <div class="bg-surface-container-lowest rounded-xl border border-outline-variant max-w-md w-full max-h-[90vh] overflow-y-auto shadow-lg">
            <div class="p-lg">
                <h3 class="font-headline-md text-headline-md text-on-surface mb-lg flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary">person_add</span>
                    {{ $colaboradorIdEditar ? 'Editar Colaborador' : 'Nuevo Colaborador' }}
                </h3>

                <form wire:submit.prevent="guardarColaborador">
                    <div class="space-y-md">
                        <div class="flex flex-col gap-xs">
                            <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Nombre *</label>
                            <input type="text" wire:model="colaboradorNombre"
                                   class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                            @error('colaboradorNombre') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-xs">
                            <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Email *</label>
                            <input type="email" wire:model="colaboradorEmail"
                                   class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                            @error('colaboradorEmail') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-xs">
                            <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Teléfono</label>
                            <input type="text" wire:model="colaboradorTelefono"
                                   class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                            @error('colaboradorTelefono') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-xs">
                            <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">
                                {{ $colaboradorIdEditar ? 'Nueva Contraseña (opcional)' : 'Contraseña *' }}
                            </label>
                            <input type="password" wire:model="colaboradorPassword"
                                   class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                            @error('colaboradorPassword') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                            @if($colaboradorIdEditar)
                                <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Dejar en blanco para mantener la contraseña actual</p>
                            @endif
                        </div>

                        <div class="flex flex-col gap-xs">
                            <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Comisión (%)</label>
                            <input type="number" step="0.01" min="0" max="100" wire:model="colaboradorComision"
                                   class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none"
                                   placeholder="Ej: 10">
                            @error('colaboradorComision') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-md">
                            <div class="flex flex-col gap-xs">
                                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Hora inicio</label>
                                <input type="time" wire:model="colaboradorHorarioInicio"
                                       class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                                @error('colaboradorHorarioInicio') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Hora fin</label>
                                <input type="time" wire:model="colaboradorHorarioFin"
                                       class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                                @error('colaboradorHorarioFin') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Servicios del colaborador -->
                        <div class="flex flex-col gap-xs">
                            <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">
                                Servicios que puede realizar *
                            </label>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mb-2">Selecciona uno o varios servicios</p>

                            <div class="space-y-2 max-h-40 overflow-y-auto border border-outline-variant rounded-lg p-2 bg-surface">
                                @foreach($serviciosAll as $servicio)
                                    <label class="flex items-center hover:bg-surface-container-low p-1 rounded cursor-pointer">
                                        <input type="checkbox"
                                               wire:model="colaboradorServicios"
                                               value="{{ $servicio->id }}"
                                               class="rounded border-outline-variant text-secondary focus:ring-secondary">
                                        <span class="ml-2 font-body-sm text-body-sm text-on-surface">
                                            {{ $servicio->nombre }}
                                            <span class="text-on-surface-variant text-xs">
                                                ({{ $servicio->duracion_minutos }} min - ${{ number_format($servicio->precio, 2) }})
                                            </span>
                                            @if(!$servicio->activo)
                                                <span class="text-error text-xs">(Inactivo)</span>
                                            @endif
                                        </span>
                                    </label>
                                @endforeach
                            </div>

                            @error('colaboradorServicios')
                                <span class="text-error text-label-sm font-label-sm block mt-1">{{ $message }}</span>
                            @enderror

                            @if(count($colaboradorServicios) > 0)
                                <div class="mt-2 flex flex-wrap gap-1">
                                    @foreach($colaboradorServicios as $servicioId)
                                        @php
                                            $servicio = $serviciosAll->firstWhere('id', $servicioId);
                                        @endphp
                                        @if($servicio)
                                            <span class="inline-flex items-center px-2 py-1 bg-secondary-container text-on-secondary-container text-xs rounded-full font-label-sm">
                                                {{ $servicio->nombre }}
                                                <button type="button"
                                                        wire:click="$set('colaboradorServicios', {{ json_encode(array_diff($colaboradorServicios, [$servicioId])) }})"
                                                        class="ml-1 text-on-secondary-container hover:opacity-70">
                                                    <span class="material-symbols-outlined text-[14px]">close</span>
                                                </button>
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-2">
                            <input type="checkbox" wire:model="colaboradorActivo" id="colaboradorActivo"
                                   class="w-4 h-4 text-secondary border-outline-variant rounded focus:ring-secondary">
                            <label for="colaboradorActivo" class="font-body-sm text-body-sm text-on-surface">Activo</label>
                        </div>
                    </div>

                    <div class="flex justify-end gap-sm mt-lg pt-md border-t border-outline-variant">
                        <button type="button" wire:click="cerrarModalColaborador"
                                class="px-lg py-sm rounded-lg border border-outline-variant text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high transition-colors">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-lg py-sm rounded-lg bg-secondary text-on-secondary font-label-md text-label-md hover:opacity-90 transition-opacity">
                            {{ $colaboradorIdEditar ? 'Actualizar' : 'Guardar' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- ==================== MODAL SERVICIO ==================== -->
    @if($mostrarModalServicio)
    <div class="fixed inset-0 bg-on-surface/40 flex items-center justify-center z-50 p-4">
        <div class="bg-surface-container-lowest rounded-xl border border-outline-variant max-w-md w-full max-h-[90vh] overflow-y-auto shadow-lg">
            <div class="p-lg">
                <h3 class="font-headline-md text-headline-md text-on-surface mb-lg flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary">add_box</span>
                    {{ $servicioIdEditar ? 'Editar Servicio' : 'Nuevo Servicio' }}
                </h3>

                <form wire:submit.prevent="guardarServicio">
                    <div class="space-y-md">
                        <div class="flex flex-col gap-xs">
                            <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Nombre *</label>
                            <input type="text" wire:model="servicioNombre"
                                   class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none"
                                   placeholder="Ej: Corte de cabello">
                            @error('servicioNombre') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-xs">
                            <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Duración (minutos) *</label>
                            <input type="number" min="5" step="5" wire:model="servicioDuracion"
                                   class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none"
                                   placeholder="30">
                            @error('servicioDuracion') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-xs">
                            <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Precio *</label>
                            <input type="number" step="0.01" min="0" wire:model="servicioPrecio"
                                   class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none"
                                   placeholder="0.00">
                            @error('servicioPrecio') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-xs">
                            <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Puntos que genera</label>
                            <input type="number" min="0" wire:model="servicioPuntos"
                                   class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none"
                                   placeholder="10">
                            @error('servicioPuntos') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Puntos que recibe el cliente al agendar esta cita</p>
                        </div>

                        <div class="flex items-center gap-2">
                            <input type="checkbox" wire:model="servicioActivo" id="servicioActivo"
                                   class="w-4 h-4 text-secondary border-outline-variant rounded focus:ring-secondary">
                            <label for="servicioActivo" class="font-body-sm text-body-sm text-on-surface">Activo</label>
                        </div>
                    </div>

                    <div class="flex justify-end gap-sm mt-lg pt-md border-t border-outline-variant">
                        <button type="button" wire:click="cerrarModalServicio"
                                class="px-lg py-sm rounded-lg border border-outline-variant text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high transition-colors">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-lg py-sm rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:opacity-90 transition-opacity">
                            {{ $servicioIdEditar ? 'Actualizar' : 'Guardar' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
