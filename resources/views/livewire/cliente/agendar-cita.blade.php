<div class="space-y-lg">
    {{-- HEADER CLIENTE --}}
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

    {{-- NAVEGACIÓN --}}
    <div class="flex gap-sm">
        <button type="button"
                wire:click="mostrarFormularioCita"
                wire:loading.attr="disabled"
                class="flex-1 px-md py-sm rounded-lg font-label-md text-label-md transition-all duration-200 flex items-center justify-center gap-sm
                    {{ $mostrarFormulario ? 'bg-secondary text-on-secondary shadow-md' : 'bg-surface-container-low text-on-surface-variant border border-outline-variant hover:bg-surface-container' }}
                    disabled:opacity-50">
            <span wire:loading.remove wire:target="mostrarFormularioCita">
                <span class="material-symbols-outlined" style="font-size: 18px;">event_available</span>
                Nueva Cita
            </span>
            <span wire:loading wire:target="mostrarFormularioCita" class="flex items-center gap-2">
                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Cargando...
            </span>
        </button>
        <button type="button"
                wire:click="verHistorial"
                wire:loading.attr="disabled"
                class="flex-1 px-md py-sm rounded-lg font-label-md text-label-md transition-all duration-200 flex items-center justify-center gap-sm
                    {{ $mostrarHistorial ? 'bg-secondary text-on-secondary shadow-md' : 'bg-surface-container-low text-on-surface-variant border border-outline-variant hover:bg-surface-container' }}
                    disabled:opacity-50">
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
            {{-- SERVICIO --}}
            <div class="space-y-xs">
                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Servicio *</label>
                <div class="focus-ring flex items-center bg-surface border border-outline-variant rounded-lg transition-all duration-200">
                    <div class="px-md flex items-center border-r border-outline-variant bg-surface-container-low rounded-l-lg h-12">
                        <span class="material-symbols-outlined text-on-surface-variant" style="font-size: 20px;">spa</span>
                    </div>
                    {{-- CAMBIADO: wire:model.live con debounce de 300ms --}}
                    <select wire:model.live.debounce.300ms="servicioId"
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

            {{-- COLABORADOR --}}
            <div class="space-y-xs">
                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Colaborador *</label>
                <div class="focus-ring flex items-center bg-surface border border-outline-variant rounded-lg transition-all duration-200">
                    <div class="px-md flex items-center border-r border-outline-variant bg-surface-container-low rounded-l-lg h-12">
                        <span class="material-symbols-outlined text-on-surface-variant" style="font-size: 20px;">badge</span>
                    </div>
                    {{-- CAMBIADO: wire:model.live con debounce de 300ms --}}
                    <select wire:model.live.debounce.300ms="colaboradorId"
                            class="w-full h-12 px-md bg-transparent border-none focus:ring-0 font-body-md text-body-md text-on-surface appearance-none cursor-pointer">
                        <option value="">Seleccionar colaborador</option>
                        @foreach($colaboradores as $colaborador)
                            <option value="{{ $colaborador->id }}">{{ $colaborador->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                @error('colaboradorId') <span class="font-body-sm text-body-sm text-error block">{{ $message }}</span> @enderror
            </div>

            {{-- ==================== CALENDARIO ==================== --}}
            <div class="space-y-xs">
                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Fecha y hora *</label>

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
                        <div class="relative" x-data="{ 
                            abierto: false,
                            toggle() {
                                this.abierto = !this.abierto;
                                if (this.abierto) {
                                    setTimeout(() => {
                                        const el = this.$el.querySelector('.calendario-contenedor');
                                        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                    }, 200);
                                }
                            }
                        }" wire:key="calendario-{{ $colaboradorId }}-{{ $servicioId }}">
                            
                            {{-- Botón selector --}}
                            <button type="button" @click="toggle()" 
                                class="w-full h-14 md:h-12 px-md bg-surface border-2 border-outline-variant rounded-lg hover:bg-surface-container-low transition-all duration-200 flex items-center justify-between font-body-md text-body-md text-on-surface active:scale-[0.98]">
                                <span class="flex items-center gap-sm">
                                    <span class="material-symbols-outlined text-on-surface-variant" style="font-size: 24px;">event</span>
                                    <span class="text-base md:text-sm font-medium">
                                        {{ $fecha ? date('d/m/Y', strtotime($fecha)) : 'Seleccionar fecha' }}
                                    </span>
                                    <span x-show="$wire.horaInicio" class="text-on-surface-variant text-sm font-normal" x-text="'- ' + $wire.horaInicio"></span>
                                </span>
                                <span class="material-symbols-outlined text-on-surface-variant text-2xl" x-text="abierto ? 'expand_less' : 'expand_more'"></span>
                            </button>

                            {{-- Desplegable del calendario --}}
                            <div x-show="abierto" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" 
                                class="calendario-contenedor absolute z-50 mt-sm bg-surface-container-lowest border border-outline-variant rounded-xl shadow-xl p-md w-full min-w-[300px] max-w-md mx-auto left-1/2 -translate-x-1/2 md:left-0 md:translate-x-0"
                                @click.away="abierto = false">

                                {{-- Cabecera del mes --}}
                                <div class="flex items-center justify-between mb-sm">
                                    <button type="button" wire:click="cambiarMes(-1)" 
                                        class="p-3 md:p-2 rounded-lg hover:bg-surface-container transition-colors active:scale-90 touch-manipulation">
                                        <span class="material-symbols-outlined text-on-surface-variant text-2xl">chevron_left</span>
                                    </button>
                                    <span class="font-headline-md text-headline-md text-on-surface text-base md:text-lg font-bold">
                                        {{ \Carbon\Carbon::create($añoActual, $mesActual, 1)->translatedFormat('F Y') }}
                                    </span>
                                    <button type="button" wire:click="cambiarMes(1)" 
                                        class="p-3 md:p-2 rounded-lg hover:bg-surface-container transition-colors active:scale-90 touch-manipulation">
                                        <span class="material-symbols-outlined text-on-surface-variant text-2xl">chevron_right</span>
                                    </button>
                                </div>

                                {{-- Días de la semana --}}
                                <div class="grid grid-cols-7 gap-1 mb-2">
                                    <div class="text-center font-label-sm text-label-sm text-outline uppercase text-[10px] md:text-xs font-bold">L</div>
                                    <div class="text-center font-label-sm text-label-sm text-outline uppercase text-[10px] md:text-xs font-bold">M</div>
                                    <div class="text-center font-label-sm text-label-sm text-outline uppercase text-[10px] md:text-xs font-bold">X</div>
                                    <div class="text-center font-label-sm text-label-sm text-outline uppercase text-[10px] md:text-xs font-bold">J</div>
                                    <div class="text-center font-label-sm text-label-sm text-outline uppercase text-[10px] md:text-xs font-bold">V</div>
                                    <div class="text-center font-label-sm text-label-sm text-outline uppercase text-[10px] md:text-xs font-bold">S</div>
                                    <div class="text-center font-label-sm text-label-sm text-outline uppercase text-[10px] md:text-xs font-bold">D</div>
                                </div>

                                {{-- Cuadrícula de días --}}
                                <div class="grid grid-cols-7 gap-1">
                                    @foreach($diasCalendario as $dia)
                                        @if($dia === null)
                                            <div class="aspect-square"></div>
                                        @else
                                            <button type="button"
                                                wire:click="seleccionarFecha('{{ $dia['fecha'] }}')"
                                                wire:loading.attr="disabled"
                                                @if($dia['esPasado'] || !$dia['disponible']) disabled @endif
                                                class="aspect-square rounded-lg text-sm md:text-base transition-all duration-200 flex items-center justify-center relative
                                                    w-full h-full min-h-[44px] md:min-h-[40px]
                                                    {{ $dia['esSeleccionado'] ? 'bg-secondary text-on-secondary shadow-md scale-95' : '' }}
                                                    {{ $dia['esHoy'] && !$dia['esSeleccionado'] && $dia['disponible'] ? 'border-2 border-secondary text-secondary font-bold hover:bg-secondary-container' : '' }}
                                                    {{ $dia['disponible'] && !$dia['esSeleccionado'] && !$dia['esHoy'] ? 'border border-outline-variant hover:bg-secondary-container hover:border-secondary cursor-pointer text-on-surface active:scale-95' : '' }}
                                                    {{ !$dia['disponible'] && !$dia['esPasado'] && !$dia['esSeleccionado'] ? 'bg-surface-container-low text-on-surface-variant cursor-not-allowed opacity-60' : '' }}
                                                    {{ $dia['esPasado'] ? 'text-gray-300 cursor-not-allowed opacity-40 line-through' : '' }}
                                                    touch-manipulation
                                                    disabled:opacity-50
                                                ">
                                                {{ $dia['dia'] }}
                                                @if($dia['disponible'] && !$dia['esPasado'] && !$dia['esSeleccionado'])
                                                    <span class="absolute -top-0.5 -right-0.5 w-3 h-3 md:w-2.5 md:h-2.5 bg-green-500 rounded-full border border-white shadow-sm"></span>
                                                @endif
                                                @if($dia['esSeleccionado'])
                                                    <span class="absolute -top-0.5 -right-0.5 w-3 h-3 md:w-2.5 md:h-2.5 bg-white rounded-full border-2 border-secondary"></span>
                                                @endif
                                                @if(!$dia['disponible'] && !$dia['esPasado'] && !$dia['esSeleccionado'])
                                                    <span class="absolute -top-0.5 -right-0.5 w-3 h-3 md:w-2.5 md:h-2.5 bg-red-400 rounded-full border border-white shadow-sm"></span>
                                                @endif
                                            </button>
                                        @endif
                                    @endforeach
                                </div>

                                {{-- Leyenda --}}
                                <div class="flex flex-wrap items-center justify-center gap-3 mt-3 pt-3 border-t border-outline-variant/40">
                                    <span class="flex items-center gap-1.5 font-body-sm text-body-sm text-on-surface-variant text-xs">
                                        <span class="w-3 h-3 rounded-full bg-secondary inline-block"></span>
                                        Seleccionado
                                    </span>
                                    <span class="flex items-center gap-1.5 font-body-sm text-body-sm text-on-surface-variant text-xs">
                                        <span class="w-3 h-3 rounded-full border-2 border-outline-variant inline-block"></span>
                                        Disponible
                                    </span>
                                    <span class="flex items-center gap-1.5 font-body-sm text-body-sm text-outline text-xs">
                                        <span class="w-3 h-3 rounded-full bg-surface-container-low border border-outline-variant inline-block"></span>
                                        Ocupado
                                    </span>
                                    <span class="flex items-center gap-1.5 font-body-sm text-body-sm text-gray-400 text-xs">
                                        <span class="w-3 h-3 rounded-full border border-gray-300 bg-gray-100 inline-block"></span>
                                        Pasado
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Horas disponibles --}}
                        <div class="mt-4 pt-3 border-t border-outline-variant/40">
                            <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider text-xs mb-2 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">schedule</span>
                                Horas disponibles 
                                <span class="normal-case font-body-sm text-body-sm text-outline">(Duración: {{ $duracionServicio }} min)</span>
                            </p>
                            
                            @if(count($horasDisponibles) > 0)
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

            {{-- ACOMPAÑANTE --}}
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

            {{-- OBSERVACIONES --}}
            <div class="space-y-xs">
                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Observaciones</label>
                <textarea wire:model="observaciones"
                          rows="3"
                          class="w-full px-md py-md bg-surface border border-outline-variant rounded-lg focus:ring-0 focus:border-secondary font-body-md text-body-md text-on-surface placeholder:text-outline transition-all duration-200"
                          placeholder="Alguna observación..."></textarea>
                @error('observaciones') <span class="font-body-sm text-body-sm text-error block">{{ $message }}</span> @enderror
            </div>

            {{-- BOTÓN AGENDAR --}}
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
                                        {{ isset($cita->fecha) ? \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') : '' }}
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
                                @php $puedeCancelar = $cita->puedeCancelar('cliente'); @endphp
                                @if($puedeCancelar)
                                    <button type="button"
                                            wire:click="cancelarCita({{ $cita->id }})"
                                            onclick="confirm('¿Cancelar esta cita?') || event.stopImmediatePropagation()"
                                            class="font-label-sm text-label-sm text-error hover:bg-error-container px-sm py-xs rounded-lg transition-colors shrink-0 flex items-center gap-xs">
                                        <span class="material-symbols-outlined" style="font-size: 16px;">close</span>
                                        Cancelar
                                    </button>
                                @else
                                    <span class="text-xs text-on-surface-variant opacity-50" title="Solo 24 horas antes">
                                        🔒 No disponible
                                    </span>
                                @endif
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

<style>
    [x-cloak] { display: none !important; }
    .touch-manipulation { touch-action: manipulation; }
</style>