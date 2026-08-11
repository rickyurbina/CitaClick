<div class="space-y-lg">
    {{-- Client header --}}
    <div class="glass-card rounded-xl p-md">
        <div class="flex items-center justify-between gap-md flex-wrap">
            <div class="flex items-center gap-md min-w-0">
                <div class="w-12 h-12 rounded-full bg-surface-container-low border border-outline-variant flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-secondary" style="font-size: 24px;">person</span>
                </div>
                <div class="min-w-0">
                    <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Bienvenido</p>
                    <h3 class="font-headline-md text-[18px] text-on-surface truncate">{{ $cliente->nombre }}</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-xs mt-xs">
                        <span class="material-symbols-outlined" style="font-size: 16px;">call</span>
                        {{ $cliente->telefono }}
                    </p>
                </div>
            </div>
            <div class="flex flex-col items-end gap-sm">
                <div class="flex gap-sm">
                    <span class="inline-flex items-center gap-xs font-label-sm text-label-sm bg-secondary-container text-on-secondary-container px-sm py-xs rounded-lg">
                        <span class="material-symbols-outlined" style="font-size: 16px;">thumb_up</span>
                        {{ $puntosBuenos ?? 0 }}
                    </span>
                    <span class="inline-flex items-center gap-xs font-label-sm text-label-sm bg-error-container text-error px-sm py-xs rounded-lg">
                        <span class="material-symbols-outlined" style="font-size: 16px;">thumb_down</span>
                        {{ $puntosMalos ?? 0 }}
                    </span>
                </div>
                @if(isset($cliente) && $cliente->estaBloqueado())
                    <span class="inline-flex items-center gap-xs font-label-sm text-label-sm bg-error text-on-error px-sm py-xs rounded-lg">
                        <span class="material-symbols-outlined" style="font-size: 16px;">block</span>
                        Bloqueado hasta {{ $cliente->bloqueado_hasta->format('d/m/Y') }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Navigation toggles --}}
    <div class="flex gap-sm">
        <button type="button"
                wire:click="mostrarFormularioCita"
                class="flex-1 px-md py-sm rounded-lg font-label-md text-label-md transition-all duration-200 flex items-center justify-center gap-sm
                    {{ $mostrarFormulario ? 'bg-secondary text-on-secondary shadow-md' : 'bg-surface-container-low text-on-surface-variant border border-outline-variant hover:bg-surface-container' }}">
            <span class="material-symbols-outlined" style="font-size: 18px;">event_available</span>
            Nueva Cita
        </button>
        <button type="button"
                wire:click="verHistorial"
                class="flex-1 px-md py-sm rounded-lg font-label-md text-label-md transition-all duration-200 flex items-center justify-center gap-sm
                    {{ $mostrarHistorial ? 'bg-secondary text-on-secondary shadow-md' : 'bg-surface-container-low text-on-surface-variant border border-outline-variant hover:bg-surface-container' }}">
            <span class="material-symbols-outlined" style="font-size: 18px;">history</span>
            Historial ({{ $totalCitas ?? 0 }})
        </button>
        <button type="button"
                wire:click="volver"
                class="px-md py-sm rounded-lg font-label-md text-label-md bg-surface-container-low text-on-surface-variant border border-outline-variant hover:bg-surface-container transition-all duration-200 flex items-center justify-center"
                aria-label="Volver">
            <span class="material-symbols-outlined" style="font-size: 20px;">arrow_back</span>
        </button>
    </div>

    {{-- FORMULARIO DE CITA --}}
    @if($mostrarFormulario ?? false)
    <div class="glass-card rounded-xl p-lg space-y-lg">
        <div>
            <h3 class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant">Nueva cita</h3>
            <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">Selecciona servicio, colaborador y horario.</p>
        </div>

        <form wire:submit.prevent="agendarCita" class="space-y-lg">
            <div class="space-y-xs">
                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Servicio *</label>
                <div class="focus-ring flex items-center bg-surface border border-outline-variant rounded-lg transition-all duration-200">
                    <div class="px-md flex items-center border-r border-outline-variant bg-surface-container-low rounded-l-lg h-12">
                        <span class="material-symbols-outlined text-on-surface-variant" style="font-size: 20px;">spa</span>
                    </div>
                    <select wire:model="servicioId"
                            class="w-full h-12 px-md bg-transparent border-none focus:ring-0 font-body-md text-body-md text-on-surface appearance-none cursor-pointer">
                        <option value="">Seleccionar servicio</option>
                        @foreach($servicios as $servicio)
                            <option value="{{ $servicio->id }}">
                                {{ $servicio->nombre }} - ${{ number_format($servicio->precio, 2) }}
                                ({{ $servicio->duracion_minutos }} min)
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('servicioId') <span class="font-body-sm text-body-sm text-error block">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-xs">
                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Colaborador *</label>
                <div class="focus-ring flex items-center bg-surface border border-outline-variant rounded-lg transition-all duration-200">
                    <div class="px-md flex items-center border-r border-outline-variant bg-surface-container-low rounded-l-lg h-12">
                        <span class="material-symbols-outlined text-on-surface-variant" style="font-size: 20px;">badge</span>
                    </div>
                    <select wire:model="colaboradorId"
                            class="w-full h-12 px-md bg-transparent border-none focus:ring-0 font-body-md text-body-md text-on-surface appearance-none cursor-pointer">
                        <option value="">Seleccionar colaborador</option>
                        @foreach($colaboradores as $colaborador)
                            <option value="{{ $colaborador->id }}">{{ $colaborador->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                @error('colaboradorId') <span class="font-body-sm text-body-sm text-error block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
                <div class="space-y-xs">
                    <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Fecha *</label>
                    <div class="focus-ring flex items-center bg-surface border border-outline-variant rounded-lg transition-all duration-200">
                        <div class="px-md flex items-center border-r border-outline-variant bg-surface-container-low rounded-l-lg h-12">
                            <span class="material-symbols-outlined text-on-surface-variant" style="font-size: 20px;">event</span>
                        </div>
                        <input type="date"
                               wire:model="fecha"
                               min="{{ date('Y-m-d') }}"
                               class="w-full h-12 px-md bg-transparent border-none focus:ring-0 font-body-md text-body-md text-on-surface">
                    </div>
                    @error('fecha') <span class="font-body-sm text-body-sm text-error block">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-xs">
                    <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Hora *</label>
                    <div class="focus-ring flex items-center bg-surface border border-outline-variant rounded-lg transition-all duration-200">
                        <div class="px-md flex items-center border-r border-outline-variant bg-surface-container-low rounded-l-lg h-12">
                            <span class="material-symbols-outlined text-on-surface-variant" style="font-size: 20px;">schedule</span>
                        </div>
                        <input type="time"
                               wire:model="horaInicio"
                               step="900"
                               class="w-full h-12 px-md bg-transparent border-none focus:ring-0 font-body-md text-body-md text-on-surface">
                    </div>
                    @error('horaInicio') <span class="font-body-sm text-body-sm text-error block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="space-y-xs">
                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Nombre del acompañante</label>
                <div class="focus-ring flex items-center bg-surface border border-outline-variant rounded-lg transition-all duration-200">
                    <div class="px-md flex items-center border-r border-outline-variant bg-surface-container-low rounded-l-lg h-12">
                        <span class="material-symbols-outlined text-on-surface-variant" style="font-size: 20px;">group</span>
                    </div>
                    <input type="text"
                           wire:model="nombreAcompanante"
                           class="w-full h-12 px-md bg-transparent border-none focus:ring-0 font-body-md text-body-md text-on-surface placeholder:text-outline"
                           placeholder="Opcional">
                </div>
                @error('nombreAcompanante') <span class="font-body-sm text-body-sm text-error block">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-xs">
                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Observaciones</label>
                <textarea wire:model="observaciones"
                          rows="3"
                          class="w-full px-md py-md bg-surface border border-outline-variant rounded-lg focus:ring-0 focus:border-secondary font-body-md text-body-md text-on-surface placeholder:text-outline transition-all duration-200"
                          placeholder="Alguna observación..."></textarea>
                @error('observaciones') <span class="font-body-sm text-body-sm text-error block">{{ $message }}</span> @enderror
            </div>

            <button type="submit"
                    class="w-full h-14 bg-secondary text-on-secondary font-label-md text-label-md rounded-lg shadow-md hover:bg-[#005a3d] active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-sm disabled:opacity-60"
                    wire:loading.attr="disabled"
                    wire:target="agendarCita">
                <span wire:loading.remove wire:target="agendarCita" class="flex items-center gap-sm">
                    <span class="material-symbols-outlined" style="font-size: 20px;">calendar_month</span>
                    Agendar Cita
                </span>
                <span wire:loading wire:target="agendarCita" class="flex items-center gap-sm">
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Agendando...
                </span>
            </button>
        </form>
    </div>
    @endif

    {{-- HISTORIAL DE CITAS --}}
    @if($mostrarHistorial ?? false)
    <div class="glass-card rounded-xl p-lg">
        <div class="mb-md">
            <h3 class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant">Historial de citas</h3>
        </div>

        @if(($totalCitas ?? 0) > 0)
            <div class="space-y-md max-h-80 overflow-y-auto pr-sm">
                @foreach($citasAnteriores ?? [] as $cita)
                    <div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-md hover:shadow-sm transition-shadow">
                        <div class="flex items-start justify-between gap-md">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-sm flex-wrap">
                                    <span class="font-label-md text-label-md text-on-surface">{{ $cita->servicio->nombre ?? 'Servicio' }}</span>
                                    <span class="font-label-sm text-label-sm px-sm py-xs rounded-lg
                                        @if($cita->estado == 'atendida') bg-secondary-container text-on-secondary-container
                                        @elseif($cita->estado == 'cancelada') bg-error-container text-error
                                        @elseif($cita->estado == 'confirmada') bg-surface-container text-on-surface
                                        @elseif($cita->estado == 'en_curso') bg-secondary-container text-on-secondary-container
                                        @else bg-surface-container-low text-on-surface-variant @endif">
                                        {{ ucfirst($cita->estado ?? 'agendada') }}
                                    </span>
                                </div>
                                <div class="font-body-sm text-body-sm text-on-surface-variant mt-sm flex flex-wrap items-center gap-md">
                                    <span class="inline-flex items-center gap-xs">
                                        <span class="material-symbols-outlined" style="font-size: 16px;">event</span>
                                        {{ isset($cita->fecha) ? Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') : '' }}
                                    </span>
                                    <span class="inline-flex items-center gap-xs">
                                        <span class="material-symbols-outlined" style="font-size: 16px;">schedule</span>
                                        {{ $cita->hora_inicio ?? '' }} - {{ $cita->hora_fin ?? '' }}
                                    </span>
                                </div>
                                <div class="font-body-sm text-body-sm text-on-surface-variant mt-xs flex flex-wrap items-center gap-md">
                                    <span class="inline-flex items-center gap-xs">
                                        <span class="material-symbols-outlined" style="font-size: 16px;">person</span>
                                        {{ $cita->colaborador->nombre ?? 'Sin asignar' }}
                                    </span>
                                    @if($cita->monto_pagado ?? false)
                                        <span class="inline-flex items-center gap-xs">
                                            <span class="material-symbols-outlined" style="font-size: 16px;">payments</span>
                                            ${{ number_format($cita->monto_pagado, 2) }}
                                        </span>
                                    @endif
                                </div>
                                @if(($cita->estado ?? '') == 'cancelada' && ($cita->motivo_cancelacion ?? ''))
                                    <div class="font-body-sm text-body-sm text-error mt-sm flex items-start gap-xs">
                                        <span class="material-symbols-outlined shrink-0" style="font-size: 16px;">cancel</span>
                                        {{ $cita->motivo_cancelacion }}
                                    </div>
                                @endif
                            </div>
                            @if(in_array($cita->estado ?? '', ['agendada', 'confirmada']))
                                <button type="button"
                                        wire:click="cancelarCita({{ $cita->id }})"
                                        onclick="confirm('¿Cancelar esta cita?') || event.stopImmediatePropagation()"
                                        class="font-label-sm text-label-sm text-error hover:bg-error-container px-sm py-xs rounded-lg transition-colors shrink-0 flex items-center gap-xs">
                                    <span class="material-symbols-outlined" style="font-size: 16px;">close</span>
                                    Cancelar
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            @if(($totalCitas ?? 0) > 10)
                <p class="font-body-sm text-body-sm text-outline text-center mt-md">
                    Mostrando las últimas 10 citas. Total: {{ $totalCitas }}
                </p>
            @endif
        @else
            <div class="text-center py-xl">
                <div class="w-16 h-16 bg-surface-container-low rounded-full flex items-center justify-center mx-auto mb-md border border-outline-variant/40">
                    <span class="material-symbols-outlined text-outline" style="font-size: 32px;">event_busy</span>
                </div>
                <p class="font-body-md text-body-md text-on-surface-variant">No tienes citas registradas</p>
                <p class="font-body-sm text-body-sm text-outline mt-xs">Agenda tu primera cita</p>
            </div>
        @endif
    </div>
    @endif
</div>
