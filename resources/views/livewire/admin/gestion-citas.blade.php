<div>
    {{-- ==================== MENSAJES DE SESIÓN ==================== --}}
    @if(session('error'))
        <div class="mb-4 p-3 bg-error-container border border-error rounded-lg text-error text-sm">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="mb-4 p-3 bg-secondary-container border border-secondary rounded-lg text-secondary text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- ==================== TARJETAS DE MÉTRICAS ==================== --}}
    @if($esRecepcionista)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-lg mb-2xl">
            <div class="bg-surface p-lg rounded-xl border border-outline-variant col-span-1 shadow-sm">
                <div class="flex items-center justify-between mb-sm">
                    <span class="text-on-surface-variant font-label-sm text-label-sm">Citas de Hoy</span>
                    <span class="material-symbols-outlined text-secondary">today</span>
                </div>
                <div class="font-headline-lg text-headline-lg text-primary">{{ $citasHoy }}</div>
            </div>
            <div class="bg-surface p-lg rounded-xl border border-outline-variant col-span-1 shadow-sm">
                <div class="flex items-center justify-between mb-sm">
                    <span class="text-on-surface-variant font-label-sm text-label-sm">Ingresos de Hoy</span>
                    <span class="material-symbols-outlined text-secondary">payments</span>
                </div>
                <div class="font-headline-md text-headline-md text-secondary font-extrabold">${{ number_format($ingresosHoy, 2) }}</div>
            </div>
            <div class="bg-surface p-lg rounded-xl border border-outline-variant col-span-1 shadow-sm">
                <div class="flex items-center justify-between mb-sm">
                    <span class="text-on-surface-variant font-label-sm text-label-sm">Efectivo de Hoy</span>
                    <span class="material-symbols-outlined text-secondary">payments</span>
                </div>
                <div class="font-headline-md text-headline-md text-secondary font-extrabold">${{ number_format($efectivoHoy, 2) }}</div>
            </div>
        </div>
    @endif

    @if($esColaborador)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-lg mb-2xl">
            <div class="bg-surface p-lg rounded-xl border border-outline-variant col-span-1 shadow-sm">
                <div class="flex items-center justify-between mb-sm">
                    <span class="text-on-surface-variant font-label-sm text-label-sm">Mis Citas de Hoy</span>
                    <span class="material-symbols-outlined text-secondary">event_note</span>
                </div>
                <div class="font-headline-lg text-headline-lg text-primary">{{ $totalCitasColaborador }}</div>
            </div>
            <div class="bg-surface p-lg rounded-xl border border-outline-variant col-span-1 shadow-sm">
                <div class="flex items-center justify-between mb-sm">
                    <span class="text-on-surface-variant font-label-sm text-label-sm">Pendientes</span>
                    <span class="material-symbols-outlined text-secondary">hourglass_top</span>
                </div>
                <div class="font-headline-lg text-headline-lg text-primary">{{ $citasPendientesColaborador }}</div>
            </div>
            <div class="bg-surface p-lg rounded-xl border-2 border-secondary col-span-1 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 -mr-16 -mt-16 bg-secondary opacity-5 rounded-full"></div>
                <div class="flex items-center justify-between mb-sm">
                    <span class="text-on-surface-variant font-label-sm text-label-sm">Mi Ingreso</span>
                    <span class="material-symbols-outlined text-secondary">payments</span>
                </div>
                <div class="font-headline-md text-headline-md text-secondary font-extrabold">${{ number_format($ingresoColaborador, 2) }}</div>
            </div>
        </div>
    @endif

    @if($esAdmin)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-lg mb-2xl">
            <div class="bg-surface p-lg rounded-xl border border-outline-variant col-span-1 shadow-sm">
                <div class="flex items-center justify-between mb-sm">
                    <span class="text-on-surface-variant font-label-sm text-label-sm">Citas de Hoy</span>
                    <span class="material-symbols-outlined text-secondary">today</span>
                </div>
                <div class="font-headline-lg text-headline-lg text-primary">{{ $citasHoy }}</div>
            </div>
            <div class="bg-surface p-lg rounded-xl border border-outline-variant col-span-1 shadow-sm">
                <div class="flex items-center justify-between mb-sm">
                    <span class="text-on-surface-variant font-label-sm text-label-sm">Ingresos de Hoy</span>
                    <span class="material-symbols-outlined text-secondary">payments</span>
                </div>
                <div class="font-headline-md text-headline-md text-secondary font-extrabold">${{ number_format($ingresosHoy, 2) }}</div>
            </div>
            <div class="bg-surface p-lg rounded-xl border border-outline-variant col-span-1 shadow-sm">
                <div class="flex items-center justify-between mb-sm">
                    <span class="text-on-surface-variant font-label-sm text-label-sm">Efectivo de Hoy</span>
                    <span class="material-symbols-outlined text-secondary">payments</span>
                </div>
                <div class="font-headline-md text-headline-md text-secondary font-extrabold">${{ number_format($efectivoHoy, 2) }}</div>
            </div>
        </div>
    @endif

    {{-- ==================== FILTROS (SOLO ADMIN Y RECEPCIONISTA) ==================== --}}
    @if($esAdmin || $esRecepcionista)
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
    @endif

    {{-- ==================== LISTADO PRINCIPAL (ADMIN Y RECEPCIONISTA) ==================== --}}
    @if($esAdmin || $esRecepcionista)
    <div class="bg-surface rounded-xl border border-outline-variant overflow-hidden shadow-sm">
        <div class="px-lg py-md flex flex-col md:flex-row justify-between items-start md:items-center gap-md border-b border-outline-variant">
            <div>
                <h2 class="font-headline-md text-headline-md text-primary">Listado de Citas</h2>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Gestione y supervise todas las citas activas.</p>
            </div>
            @if($puedeGestionar)
            <button wire:click="abrirCrearCita" type="button"
                    class="inline-flex items-center gap-sm px-lg py-3 bg-secondary text-on-secondary font-label-md text-label-md rounded-lg hover:brightness-110 active:scale-95 transition-all shadow-md">
                <span class="material-symbols-outlined">add</span>
                Nueva Cita
            </button>
            @endif
        </div>

        <!-- Vista en tabla para pantallas grandes -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low border-b border-outline-variant">
                        <th class="px-lg py-md font-label-md text-label-md text-on-surface-variant">Cliente</th>
                        <th class="px-lg py-md font-label-md text-label-md text-on-surface-variant">Servicio</th>
                        <th class="px-lg py-md font-label-md text-label-md text-on-surface-variant">Colaborador</th>
                        <th class="px-lg py-md font-label-md text-label-md text-on-surface-variant">Fecha / Hora</th>
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
                        <td class="px-lg py-md font-body-md text-body-md text-on-surface">{{ $cita->colaborador->nombre }}</td>
                        <td class="px-lg py-md">
                            <div class="font-body-md text-body-md text-on-surface">
                                {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
                                <span class="text-on-surface-variant font-body-sm text-body-sm ml-2">{{ $cita->hora_inicio }}</span>
                            </div>
                        </td>
                        <td class="px-lg py-md">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="px-sm py-1 text-label-sm font-label-sm rounded-full
                                    @if($cita->estado == 'agendada') bg-surface-container-high text-on-surface
                                    @elseif($cita->estado == 'confirmada') bg-secondary-container text-on-secondary-container
                                    @elseif($cita->estado == 'en_curso') bg-primary-container text-on-primary-container
                                    @elseif($cita->estado == 'atendida') bg-secondary-container text-on-secondary-container
                                    @elseif($cita->estado == 'cancelada') bg-error-container text-on-error-container
                                    @elseif($cita->estado == 'no_asistio') bg-surface-container text-on-surface-variant
                                    @else bg-surface-container text-on-surface-variant @endif">
                                    {{ ucfirst($cita->estado) }}
                                </span>
                                @if($cita->pagado)
                                    <span class="px-sm py-1 text-label-sm font-label-sm rounded-full bg-secondary-container text-on-secondary-container font-semibold">✅ Pagado</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-lg py-md">
                            <div class="font-label-md text-label-md {{ $cita->pagado ? 'text-secondary font-bold' : 'text-error' }}">
                                ${{ number_format($cita->monto_pagado ?? 0, 2) }}
                            </div>
                            <div class="font-body-sm text-body-sm {{ $cita->pagado ? 'text-secondary' : 'text-on-surface-variant' }}">
                                {{ $cita->pagado ? 'Pagado ✅' : 'Pendiente ⏳' }}
                            </div>
                        </td>
                        <td class="px-lg py-md text-right">
                            <div class="flex justify-end gap-sm items-center flex-wrap">
                                @if($puedeGestionar)
                                    <button wire:click="editarCita({{ $cita->id }})" class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-container-high rounded-lg transition-all" title="Editar"><span class="material-symbols-outlined text-[20px]">edit</span></button>
                                    {{-- ELIMINAR ELIMINADO --}}
                                    @if($cita->estado === 'en_curso')
                                        <span class="text-xs text-on-surface-variant">En curso</span>
                                    @endif
                                    @if(!$cita->pagado && in_array($cita->estado, ['agendada', 'confirmada', 'en_curso', 'atendida']))
                                        <button wire:click="abrirModalPago({{ $cita->id }})" class="p-2 text-on-surface-variant hover:text-green-600 hover:bg-green-50 rounded-lg transition-all" title="Cobrar cita"><span class="material-symbols-outlined text-[20px]">payments</span></button>
                                    @endif
                                    @if(in_array($cita->estado, ['agendada', 'confirmada']))
                                        @php $puedeCancelar = $cita->puedeCancelar(Auth::guard('web')->user()->rol); @endphp
                                        @if($puedeCancelar)
                                            <button wire:click="cancelarCita({{ $cita->id }})" onclick="confirm('¿Cancelar esta cita?') || event.stopImmediatePropagation()" class="p-2 text-on-surface-variant hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-all" title="Cancelar cita"><span class="material-symbols-outlined text-[20px]">cancel</span></button>
                                        @else
                                            <span class="text-xs text-on-surface-variant opacity-50" title="Solo 24 horas antes">🔒 24h</span>
                                        @endif
                                    @endif
                                    <div class="relative group">
                                        <button type="button" class="p-2 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high rounded-lg transition-all font-label-sm text-label-sm flex items-center gap-1">Estados <span class="material-symbols-outlined text-[16px]">expand_more</span></button>
                                        <div class="absolute right-0 hidden group-hover:block bg-surface-container-lowest border border-outline-variant shadow-lg rounded-lg p-2 z-10 min-w-32">
                                            @foreach(['agendada', 'confirmada', 'en_curso', 'atendida', 'cancelada', 'no_asistio'] as $estado)
                                                <button wire:click="cambiarEstado({{ $cita->id }}, '{{ $estado }}')" class="block w-full text-left px-3 py-1 font-body-sm text-body-sm text-on-surface hover:bg-surface-container-low rounded">{{ ucfirst($estado) }}</button>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-lg py-2xl text-center font-body-md text-body-md text-on-surface-variant">No hay citas registradas</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Vista en tarjetas para móviles -->
        <div class="md:hidden divide-y divide-outline-variant">
            @forelse($citas as $cita)
            <div class="p-4 space-y-3 hover:bg-surface-container-low transition-colors">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-secondary-container/20 text-secondary flex items-center justify-center">
                            <span class="material-symbols-outlined text-sm">person</span>
                        </div>
                        <div>
                            <div class="font-body-md font-semibold text-on-surface">{{ $cita->cliente->nombre }}</div>
                            <div class="font-body-sm text-body-sm text-on-surface-variant">{{ $cita->cliente->telefono }}</div>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-1">
                        <span class="px-2 py-0.5 text-xs font-medium rounded-full
                            @if($cita->estado == 'agendada') bg-surface-container-high text-on-surface
                            @elseif($cita->estado == 'confirmada') bg-secondary-container text-on-secondary-container
                            @elseif($cita->estado == 'en_curso') bg-primary-container text-on-primary-container
                            @elseif($cita->estado == 'atendida') bg-secondary-container text-on-secondary-container
                            @elseif($cita->estado == 'cancelada') bg-error-container text-on-error-container
                            @else bg-surface-container text-on-surface-variant @endif">
                            {{ ucfirst($cita->estado) }}
                        </span>
                        @if($cita->pagado)
                            <span class="text-xs text-secondary font-semibold">✅ Pagado</span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-1 text-sm text-on-surface-variant">
                    <div><span class="font-medium">Servicio:</span> {{ $cita->servicio->nombre }}</div>
                    <div><span class="font-medium">Colaborador:</span> {{ $cita->colaborador->nombre }}</div>
                    <div><span class="font-medium">Fecha:</span> {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</div>
                    <div><span class="font-medium">Hora:</span> {{ $cita->hora_inicio }}</div>
                    <div class="col-span-2"><span class="font-medium">Monto:</span> <span class="{{ $cita->pagado ? 'text-secondary font-bold' : 'text-error' }}">${{ number_format($cita->monto_pagado ?? 0, 2) }}</span> {{ $cita->pagado ? '✅' : '⏳' }}</div>
                </div>

                <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-outline-variant/40">
                    @if($puedeGestionar)
                        <button wire:click="editarCita({{ $cita->id }})" class="px-3 py-1.5 text-xs rounded-lg bg-surface-container-high text-on-surface hover:bg-secondary-container transition-colors">Editar</button>
                        @if(!$cita->pagado && in_array($cita->estado, ['agendada', 'confirmada', 'en_curso', 'atendida']))
                            <button wire:click="abrirModalPago({{ $cita->id }})" class="px-3 py-1.5 text-xs rounded-lg bg-green-50 text-green-600 hover:bg-green-100 transition-colors">Cobrar</button>
                        @endif
                        @if(in_array($cita->estado, ['agendada', 'confirmada']))
                            @php $puedeCancelar = $cita->puedeCancelar(Auth::guard('web')->user()->rol); @endphp
                            @if($puedeCancelar)
                                <button wire:click="cancelarCita({{ $cita->id }})" onclick="confirm('¿Cancelar esta cita?') || event.stopImmediatePropagation()" class="px-3 py-1.5 text-xs rounded-lg bg-orange-50 text-orange-600 hover:bg-orange-100 transition-colors">Cancelar</button>
                            @else
                                <span class="text-xs text-on-surface-variant opacity-50" title="Solo 24 horas antes">🔒 24h</span>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-on-surface-variant">
                <span class="material-symbols-outlined text-4xl text-outline block mb-2">event_busy</span>
                <p class="font-body-md">No hay citas registradas</p>
            </div>
            @endforelse
        </div>

        <div class="px-lg py-md bg-surface-container-low border-t border-outline-variant">{{ $citas->links() }}</div>
    </div>
    @endif

    {{-- ==================== VISTA DE COLABORADOR (LISTADOS ESPECIALES) ==================== --}}
    @if($esColaborador)
    <div class="space-y-lg">
        {{-- Citas de hoy activas (agendadas, confirmadas, en curso) --}}
        <div class="bg-surface rounded-xl border border-outline-variant overflow-hidden shadow-sm">
            <div class="px-lg py-md border-b border-outline-variant bg-secondary-container/10">
                <h2 class="font-headline-md text-headline-md text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary">event_available</span>
                    Mis citas de hoy
                    <span class="ml-auto text-sm bg-secondary-container text-on-secondary-container px-2 py-0.5 rounded-full">{{ $citasHoyAgendadas->count() }}</span>
                </h2>
            </div>
            <div class="p-lg">
                @if($citasHoyAgendadas->count() > 0)
                    <div class="space-y-3">
                        @foreach($citasHoyAgendadas as $cita)
                            <div class="flex items-center justify-between p-3 bg-surface-container-low rounded-lg border border-outline-variant hover:shadow-sm transition-shadow">
                                <div>
                                    <div class="font-body-md font-semibold text-on-surface">{{ $cita->cliente->nombre }}</div>
                                    <div class="font-body-sm text-body-sm text-on-surface-variant">
                                        {{ $cita->servicio->nombre }} • {{ $cita->hora_inicio }} - {{ $cita->hora_fin }}
                                    </div>
                                    <div class="font-body-sm text-body-sm text-on-surface-variant">📞 {{ $cita->cliente->telefono }}</div>
                                    <span class="text-xs text-on-surface-variant mt-1 inline-block">
                                        Estado: {{ ucfirst($cita->estado) }}
                                    </span>
                                </div>
                                <div class="flex flex-col items-end gap-2">
                                    @if(in_array($cita->estado, ['agendada', 'confirmada']))
                                        <button wire:click="checkIn({{ $cita->id }})" 
                                                class="px-4 py-2 bg-secondary text-on-secondary font-label-md text-label-md rounded-lg shadow-md hover:opacity-90 active:scale-95 transition-all flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[18px]">login</span>
                                            Check In
                                        </button>
                                    @endif
                                    @if($cita->estado == 'en_curso')
                                        <button wire:click="checkOut({{ $cita->id }})" 
                                                class="px-4 py-2 bg-primary text-on-primary font-label-md text-label-md rounded-lg shadow-md hover:opacity-90 active:scale-95 transition-all flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[18px]">logout</span>
                                            Check Out
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6 text-on-surface-variant">
                        <span class="material-symbols-outlined text-4xl text-outline block mb-2">event_busy</span>
                        <p>No tienes citas activas para hoy.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Citas atendidas hoy --}}
        <div class="bg-surface rounded-xl border border-outline-variant overflow-hidden shadow-sm">
            <div class="px-lg py-md border-b border-outline-variant bg-secondary-container/5">
                <h2 class="font-headline-md text-headline-md text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary">check_circle</span>
                    Mis citas atendidas (Hoy)
                    <span class="ml-auto text-sm bg-secondary-container text-on-secondary-container px-2 py-0.5 rounded-full">{{ $citasAtendidasHoy->count() }}</span>
                </h2>
            </div>
            <div class="p-lg">
                @if($citasAtendidasHoy->count() > 0)
                    <div class="space-y-3">
                        @foreach($citasAtendidasHoy as $cita)
                            <div class="flex items-center justify-between p-3 bg-surface-container-low rounded-lg border border-outline-variant">
                                <div>
                                    <div class="font-body-md font-semibold text-on-surface">{{ $cita->cliente->nombre }}</div>
                                    <div class="font-body-sm text-body-sm text-on-surface-variant">
                                        {{ $cita->servicio->nombre }} • {{ $cita->hora_inicio }} - {{ $cita->hora_fin }}
                                    </div>
                                    <div class="font-body-sm text-body-sm text-on-surface-variant">📞 {{ $cita->cliente->telefono }}</div>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full bg-secondary-container text-on-secondary-container">✅ Atendida</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6 text-on-surface-variant">
                        <span class="material-symbols-outlined text-4xl text-outline block mb-2">check_circle</span>
                        <p>No has atendido citas hoy.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Citas futuras (mañana y próxima semana) --}}
        <div class="bg-surface rounded-xl border border-outline-variant overflow-hidden shadow-sm">
            <div class="px-lg py-md border-b border-outline-variant bg-primary-container/5">
                <h2 class="font-headline-md text-headline-md text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">calendar_today</span>
                    Próximas citas
                </h2>
            </div>
            <div class="p-lg">
                @if($citasManana->count() > 0 || $citasProximaSemana->count() > 0)
                    @if($citasManana->count() > 0)
                        <h3 class="font-label-md text-label-md text-on-surface-variant mb-2">📅 Mañana ({{ \Carbon\Carbon::tomorrow()->format('d/m/Y') }})</h3>
                        <div class="space-y-2 mb-4">
                            @foreach($citasManana as $cita)
                                <div class="flex items-center justify-between p-3 bg-surface-container-low rounded-lg border border-outline-variant">
                                    <div>
                                        <div class="font-body-md font-semibold text-on-surface">{{ $cita->cliente->nombre }}</div>
                                        <div class="font-body-sm text-body-sm text-on-surface-variant">
                                            {{ $cita->servicio->nombre }} • {{ $cita->hora_inicio }} - {{ $cita->hora_fin }}
                                        </div>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full bg-surface-container-high text-on-surface">Agendada</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if($citasProximaSemana->count() > 0)
                        <h3 class="font-label-md text-label-md text-on-surface-variant mb-2">📅 Próxima semana</h3>
                        <div class="space-y-2">
                            @foreach($citasProximaSemana as $cita)
                                <div class="flex items-center justify-between p-3 bg-surface-container-low rounded-lg border border-outline-variant">
                                    <div>
                                        <div class="font-body-md font-semibold text-on-surface">{{ $cita->cliente->nombre }}</div>
                                        <div class="font-body-sm text-body-sm text-on-surface-variant">
                                            {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }} • {{ $cita->servicio->nombre }} • {{ $cita->hora_inicio }}
                                        </div>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full bg-surface-container-high text-on-surface">Agendada</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="text-center py-6 text-on-surface-variant">
                        <span class="material-symbols-outlined text-4xl text-outline block mb-2">event_note</span>
                        <p>No tienes citas programadas para los próximos días.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    {{-- ==================== MODAL CITA ==================== --}}
    @if($mostrarModalCita)
    <div class="fixed inset-0 bg-on-surface/40 flex items-center justify-center z-50 p-4">
        <div class="bg-surface-container-lowest rounded-xl border border-outline-variant max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-lg">
            <div class="sticky top-0 bg-surface-container-lowest z-10 px-lg py-md border-b border-outline-variant flex justify-between items-center">
                <h3 class="font-headline-md text-headline-md text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary">event</span>
                    {{ $citaIdEditar ? 'Editar Cita' : 'Nueva Cita' }}
                </h3>
                <button type="button" wire:click="cerrarModalCita" class="p-2 text-on-surface-variant hover:bg-surface-container-high rounded-lg transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form wire:submit.prevent="guardarCita" class="p-lg space-y-md">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                    <div class="flex flex-col gap-xs">
                        <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Cliente *</label>
                        <select wire:model="clienteId" class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                            <option value="">Seleccionar cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }} - {{ $cliente->telefono }}</option>
                            @endforeach
                        </select>
                        @error('clienteId') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-xs">
                        <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Estado</label>
                        <select wire:model="estado" class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                            <option value="agendada">Agendada</option>
                            <option value="confirmada">Confirmada</option>
                            <option value="en_curso">En curso</option>
                            <option value="atendida">Atendida</option>
                            <option value="cancelada">Cancelada</option>
                            <option value="no_asistio">No asistió</option>
                        </select>
                        @error('estado') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                    <div class="flex flex-col gap-xs">
                        <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Servicio *</label>
                        <select wire:model.live="servicioId" class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                            <option value="">Seleccionar servicio</option>
                            @foreach($servicios as $servicio)
                                <option value="{{ $servicio->id }}">{{ $servicio->nombre }} - ${{ number_format($servicio->precio, 2) }} ({{ $servicio->duracion_minutos }} min)</option>
                            @endforeach
                        </select>
                        @error('servicioId') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-xs">
                        <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Colaborador *</label>
                        <select wire:model.live="colaboradorId" class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                            <option value="">Seleccionar colaborador</option>
                            @foreach($colaboradores as $colaborador)
                                <option value="{{ $colaborador->id }}">{{ $colaborador->nombre }}</option>
                            @endforeach
                        </select>
                        @error('colaboradorId') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- CALENDARIO --}}
                <div class="space-y-xs mt-md">
                    <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Selecciona fecha y hora</label>

                    @if(!$servicioId || !$colaboradorId)
                        <div class="bg-surface-container-low border border-outline-variant rounded-lg p-md text-center text-on-surface-variant">
                            <span class="material-symbols-outlined text-[24px] block mx-auto mb-xs">info</span>
                            <p class="font-body-sm text-body-sm">Selecciona un servicio y un colaborador para ver las fechas disponibles.</p>
                        </div>
                    @else
                        @if($cargandoCalendario)
                            <div class="bg-surface-container-low border border-outline-variant rounded-lg p-md text-center text-on-surface-variant">
                                <svg class="animate-spin h-8 w-8 mx-auto mb-2 text-secondary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <p class="font-body-sm text-body-sm">Cargando fechas disponibles...</p>
                            </div>
                        @else
                            {{-- Días disponibles --}}
                            <div>
                                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider text-xs mb-2 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                                    Días disponibles
                                </p>
                                @if(count($diasCalendario) > 0 && collect($diasCalendario)->filter(fn($d) => !is_null($d) && $d['disponible'])->count() > 0)
                                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2 max-h-60 overflow-y-auto p-1">
                                        @foreach($diasCalendario as $dia)
                                            @if(!is_null($dia))
                                                <button type="button"
                                                    wire:click="seleccionarFecha('{{ $dia['fecha'] }}')"
                                                    @if(!$dia['disponible']) disabled @endif
                                                    class="rounded-lg p-2 text-center transition-all duration-200 touch-manipulation border
                                                        {{ $dia['esSeleccionado'] && $dia['disponible'] ? 'bg-secondary text-on-secondary shadow-md scale-95 border-secondary' : '' }}
                                                        {{ $dia['disponible'] && !$dia['esSeleccionado'] ? 'border-outline-variant hover:bg-secondary-container hover:border-secondary text-on-surface active:scale-95' : '' }}
                                                        {{ !$dia['disponible'] ? 'bg-surface-container-low text-outline cursor-not-allowed opacity-50 border-outline-variant' : '' }}
                                                        {{ $dia['esHoy'] && !$dia['esSeleccionado'] && $dia['disponible'] ? 'border-2 border-secondary' : '' }}
                                                    ">
                                                    <div class="font-label-md text-label-md">{{ $dia['dia'] }}</div>
                                                    <div class="font-label-sm text-label-sm uppercase text-[10px]">{{ $dia['nombreDia'] }}</div>
                                                    @if($dia['esHoy'] ?? false)
                                                        <span class="text-[8px] font-bold text-secondary block">Hoy</span>
                                                    @endif
                                                    @if(!$dia['disponible'] && $dia['fecha'] >= now()->format('Y-m-d'))
                                                        <span class="text-[8px] text-outline block">No disponible</span>
                                                    @endif
                                                </button>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <div class="bg-surface-container-low border border-outline-variant rounded-lg p-md text-center text-on-surface-variant">
                                        <span class="material-symbols-outlined text-[32px] block mx-auto mb-2 opacity-40">event_busy</span>
                                        <p class="font-body-sm text-body-sm">No hay días disponibles para este colaborador.</p>
                                        <p class="font-body-sm text-body-sm text-outline mt-1">Prueba seleccionar otro colaborador o servicio.</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Horas disponibles --}}
                            <div class="mt-4 pt-3 border-t border-outline-variant/40">
                                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider text-xs mb-2 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[18px]">schedule</span>
                                    Horas disponibles
                                    <span class="normal-case font-body-sm text-body-sm text-outline">(Duración: {{ $duracionServicio }} min)</span>
                                </p>
                                
                                @if(!$fecha)
                                    <div class="bg-surface-container-low border border-outline-variant rounded-lg p-md text-center text-on-surface-variant">
                                        <p class="font-body-sm text-body-sm">Selecciona una fecha para ver las horas disponibles.</p>
                                    </div>
                                @elseif(count($horasDisponibles) > 0)
                                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                                        @foreach($horasDisponibles as $hora)
                                            <button type="button"
                                                wire:click="seleccionarHora('{{ $hora['inicio'] }}')"
                                                @if(!$hora['disponible']) disabled @endif
                                                class="py-2.5 md:py-2 px-2 rounded-lg font-body-sm text-sm transition-all duration-200 text-center
                                                    min-h-[44px] md:min-h-[38px] touch-manipulation
                                                    {{ $hora['inicio'] === $horaInicio && $hora['disponible'] ? 'bg-secondary text-on-secondary shadow-md scale-95 font-semibold' : '' }}
                                                    {{ $hora['disponible'] && $hora['inicio'] !== $horaInicio ? 'border border-outline-variant hover:bg-secondary-container hover:border-secondary text-on-surface active:scale-95' : '' }}
                                                    {{ !$hora['disponible'] ? 'bg-surface-container-low text-outline cursor-not-allowed opacity-50 line-through' : '' }}
                                                ">
                                                {{ $hora['inicio'] }}
                                            </button>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-4 text-on-surface-variant/60">
                                        <span class="material-symbols-outlined text-[32px] block mx-auto mb-1 opacity-40">event_busy</span>
                                        <p class="font-body-sm text-body-sm">No hay horas disponibles para esta fecha</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endif

                    @error('fecha') <span class="font-body-sm text-body-sm text-error block mt-xs">{{ $message }}</span> @enderror
                    @error('horaInicio') <span class="font-body-sm text-body-sm text-error block mt-xs">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                    <div class="flex flex-col gap-xs">
                        <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Monto</label>
                        <input type="number" step="0.01" min="0" wire:model="montoPagado" class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                        @error('montoPagado') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-xs">
                        <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Método de pago</label>
                        <select wire:model="metodoPago" class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                            <option value="">No especificado</option>
                            <option value="efectivo">💵 Efectivo</option>
                            <option value="transferencia">🏦 Transferencia</option>
                            <option value="tarjeta">💳 Tarjeta</option>
                        </select>
                        @error('metodoPago') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">⚠️ El pago solo se puede registrar usando el botón <strong>"Cobrar"</strong> desde la lista de citas.</p>

                <div class="flex justify-end gap-sm mt-lg pt-md border-t border-outline-variant">
                    <button type="button" wire:click="cerrarModalCita" class="px-lg py-sm rounded-lg border border-outline-variant text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high transition-colors">Cancelar</button>
                    <button type="submit" class="px-lg py-sm rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:opacity-90 transition-opacity" wire:loading.attr="disabled">
                        <span wire:loading.remove>{{ $citaIdEditar ? 'Actualizar' : 'Guardar' }}</span>
                        <span wire:loading>Guardando...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- ==================== MODAL PAGO ==================== --}}
    @if($mostrarModalPago)
    <div class="fixed inset-0 bg-on-surface/40 flex items-center justify-center z-50 p-4">
        <div class="bg-surface-container-lowest rounded-xl border border-outline-variant max-w-md w-full max-h-[90vh] overflow-y-auto shadow-lg">
            <div class="sticky top-0 bg-surface-container-lowest z-10 px-lg py-md border-b border-outline-variant flex justify-between items-center">
                <h3 class="font-headline-md text-headline-md text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary">payments</span>
                    Cobrar Cita
                </h3>
                <button type="button" wire:click="cerrarModalPago" class="p-2 text-on-surface-variant hover:bg-surface-container-high rounded-lg transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            @if($errors->any())
                <div class="mx-lg mt-4 p-3 bg-error-container border border-error rounded-lg text-error text-sm">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="p-lg">
                <div class="bg-surface-container-low rounded-lg p-md mb-lg">
                    <div class="flex justify-between py-1 border-b border-outline-variant/40">
                        <span class="text-on-surface-variant font-body-sm">Cliente</span>
                        <span class="font-body-md text-body-md text-on-surface font-semibold">{{ $citaPago?->cliente->nombre ?? 'Cargando...' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-outline-variant/40">
                        <span class="text-on-surface-variant font-body-sm">Servicio</span>
                        <span class="font-body-md text-body-md text-on-surface">{{ $citaPago?->servicio->nombre ?? 'Cargando...' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-outline-variant/40">
                        <span class="text-on-surface-variant font-body-sm">Estado</span>
                        <span class="font-body-md text-body-md text-on-surface">{{ ucfirst($citaPago?->estado ?? 'Cargando...') }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-on-surface-variant font-body-sm">Total a cobrar</span>
                        <span class="font-headline-md text-headline-md text-secondary font-bold">${{ number_format($citaPago?->monto_pagado ?? 0, 2) }}</span>
                    </div>
                </div>

                <form wire:submit.prevent="procesarPago" class="space-y-md">
                    <div class="flex flex-col gap-xs">
                        <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Monto *</label>
                        <input type="number" step="0.01" min="0" wire:model="montoPago"
                               class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                        @error('montoPago') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-xs">
                        <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Método de pago *</label>
                        <div class="grid grid-cols-3 gap-sm">
                            <button type="button"
                                    wire:click="$set('metodoPagoSeleccionado', 'efectivo')"
                                    class="py-2 rounded-lg border-2 transition-all font-label-sm text-label-sm flex items-center justify-center gap-1
                                        {{ $metodoPagoSeleccionado === 'efectivo' ? 'border-secondary bg-secondary-container text-on-secondary-container' : 'border-outline-variant hover:bg-surface-container-low' }}">
                                <span class="material-symbols-outlined text-[18px]">payments</span>
                                Efectivo
                            </button>
                            <button type="button"
                                    wire:click="$set('metodoPagoSeleccionado', 'transferencia')"
                                    class="py-2 rounded-lg border-2 transition-all font-label-sm text-label-sm flex items-center justify-center gap-1
                                        {{ $metodoPagoSeleccionado === 'transferencia' ? 'border-secondary bg-secondary-container text-on-secondary-container' : 'border-outline-variant hover:bg-surface-container-low' }}">
                                <span class="material-symbols-outlined text-[18px]">account_balance</span>
                                Transferencia
                            </button>
                            <button type="button"
                                    wire:click="$set('metodoPagoSeleccionado', 'tarjeta')"
                                    class="py-2 rounded-lg border-2 transition-all font-label-sm text-label-sm flex items-center justify-center gap-1
                                        {{ $metodoPagoSeleccionado === 'tarjeta' ? 'border-secondary bg-secondary-container text-on-secondary-container' : 'border-outline-variant hover:bg-surface-container-low' }}">
                                <span class="material-symbols-outlined text-[18px]">credit_card</span>
                                Tarjeta
                            </button>
                        </div>
                        @error('metodoPagoSeleccionado') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-xs">
                        <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Referencia (opcional)</label>
                        <input type="text" wire:model="referenciaPago"
                               class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none"
                               placeholder="N° de transacción, voucher, etc.">
                        @error('referenciaPago') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end gap-sm mt-lg pt-md border-t border-outline-variant">
                        <button type="button" wire:click="cerrarModalPago"
                                class="px-lg py-sm rounded-lg border border-outline-variant text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high transition-colors">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-lg py-sm rounded-lg bg-secondary text-on-secondary font-label-md text-label-md hover:opacity-90 transition-opacity flex items-center gap-2"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove>
                                <span class="material-symbols-outlined text-[18px]">check</span>
                                Cobrar
                            </span>
                            <span wire:loading>
                                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Procesando...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>