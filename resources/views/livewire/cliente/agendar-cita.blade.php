<div>
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
            <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">
                Selecciona servicio, colaborador y horario.
            </p>
        </div>

        <form wire:submit.prevent="agendarCita" class="space-y-lg">
            {{-- SERVICIO --}}
            <div class="space-y-xs">
                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Servicio *</label>
                <div class="focus-ring flex items-center bg-surface border border-outline-variant rounded-lg transition-all duration-200">
                    <div class="px-md flex items-center border-r border-outline-variant bg-surface-container-low rounded-l-lg h-12">
                        <span class="material-symbols-outlined text-on-surface-variant" style="font-size: 20px;">spa</span>
                    </div>
                    <select wire:model.live="servicioId"
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
                    <select wire:model.live="colaboradorId"
                            class="w-full h-12 px-md bg-transparent border-none focus:ring-0 font-body-md text-body-md text-on-surface appearance-none cursor-pointer">
                        <option value="">Seleccionar colaborador</option>
                        @foreach($colaboradores as $colaborador)
                            <option value="{{ $colaborador->id }}">{{ $colaborador->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                @error('colaboradorId') <span class="font-body-sm text-body-sm text-error block">{{ $message }}</span> @enderror
            </div>

            {{-- CALENDARIO --}}
            <div class="space-y-xs">
                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">
                    Selecciona un día disponible
                    @if($servicioId && $colaboradorId)
                        <span class="normal-case font-body-sm text-body-sm text-outline ml-sm">
                            (Duración: {{ $duracionServicio }} min)
                        </span>
                    @endif
                </label>

                @if(!$servicioId || !$colaboradorId)
                    <div class="bg-surface-container-low rounded-lg p-4 text-center text-on-surface-variant font-body-sm text-body-sm">
                        <span class="material-symbols-outlined inline-block mr-2" style="font-size: 18px;">info</span>
                        Selecciona un servicio y un colaborador para ver los días disponibles
                    </div>
                @elseif(count($diasDisponibles) === 0)
                    <div class="bg-surface-container-low rounded-lg p-4 text-center text-on-surface-variant font-body-sm text-body-sm">
                        <span class="material-symbols-outlined inline-block mr-2" style="font-size: 18px;">event_busy</span>
                        No hay días disponibles en los próximos 60 días.
                    </div>
                @else
                    {{-- CALENDARIO HÍBRIDO: Blade para los días, Alpine para la navegación --}}
                    <div x-data="{
                        mes: new Date().getMonth(),
                        año: new Date().getFullYear(),
                        fechaSeleccionada: '{{ $this->fecha }}',
                        diasDisponibles: {{ json_encode($diasDisponibles) }},
                        hoy: new Date().getDate(),
                        mesActual: new Date().getMonth(),
                        añoActual: new Date().getFullYear(),

                        cambiarMes(dir) {
                            const fecha = new Date(this.año, this.mes + dir, 1);
                            this.mes = fecha.getMonth();
                            this.año = fecha.getFullYear();
                            @this.actualizarMes(this.mes, this.año);
                        },

                        get titulo() {
                            const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                            return meses[this.mes] + ' ' + this.año;
                        }
                    }" x-init="() => { mes = {{ $mesCalendario ?? date('n') - 1 }}; año = {{ $anoCalendario ?? date('Y') }}; }" 
                    class="bg-white border border-outline-variant rounded-xl p-4">
                        
                        {{-- Navegación --}}
                        <div class="flex items-center justify-between mb-3">
                            <button type="button" 
                                    @click="cambiarMes(-1)" 
                                    class="p-2 hover:bg-gray-100 rounded-lg transition">
                                <span class="material-symbols-outlined text-gray-600" style="font-size: 20px;">chevron_left</span>
                            </button>
                            <span class="font-semibold text-gray-800" x-text="titulo"></span>
                            <button type="button" 
                                    @click="cambiarMes(1)" 
                                    class="p-2 hover:bg-gray-100 rounded-lg transition">
                                <span class="material-symbols-outlined text-gray-600" style="font-size: 20px;">chevron_right</span>
                            </button>
                        </div>

                        {{-- Días de la semana --}}
                        <div class="grid grid-cols-7 gap-1 mb-3">
                            <div class="text-center text-xs font-medium text-gray-400 uppercase">L</div>
                            <div class="text-center text-xs font-medium text-gray-400 uppercase">M</div>
                            <div class="text-center text-xs font-medium text-gray-400 uppercase">X</div>
                            <div class="text-center text-xs font-medium text-gray-400 uppercase">J</div>
                            <div class="text-center text-xs font-medium text-gray-400 uppercase">V</div>
                            <div class="text-center text-xs font-medium text-gray-400 uppercase">S</div>
                            <div class="text-center text-xs font-medium text-gray-400 uppercase">D</div>
                        </div>

                        {{-- Días del mes --}}
                        <div class="grid grid-cols-7 gap-1">
                            @php
                                $mesActual = $mesCalendario ?? date('n');
                                $añoActual = $anoCalendario ?? date('Y');
                                $primerDia = date('w', mktime(0,0,0, $mesActual, 1, $añoActual));
                                $diasEnMes = date('t', mktime(0,0,0, $mesActual, 1, $añoActual));
                                $offset = $primerDia == 0 ? 6 : $primerDia - 1;
                                $fechaHoy = date('Y-m-d');
                            @endphp
                            
                            @for($i = 0; $i < 42; $i++)
                                @php
                                    $diaNumero = $i - $offset + 1;
                                    $esValido = $diaNumero >= 1 && $diaNumero <= $diasEnMes;
                                    $fechaStr = date('Y-m-d', strtotime($añoActual . '-' . $mesActual . '-' . $diaNumero));
                                    $diaDisponible = collect($diasDisponibles)->firstWhere('fecha', $fechaStr);
                                    $esHoy = $fechaStr == $fechaHoy;
                                    $esPasado = strtotime($fechaStr) < strtotime($fechaHoy);
                                    $esSeleccionado = $fechaStr == $this->fecha;
                                    $tieneEspacios = $diaDisponible && $diaDisponible['espacios'] > 0;
                                @endphp
                                
                                <div class="aspect-square flex items-center justify-center w-full">
                                    @if($esValido)
                                        <button type="button"
                                                @if($tieneEspacios && !$esPasado)
                                                    wire:click="seleccionarFecha('{{ $fechaStr }}')"
                                                @else
                                                    disabled
                                                @endif
                                                class="w-full h-full rounded-lg text-sm transition flex items-center justify-center relative
                                                    @if($esSeleccionado && $tieneEspacios) 
                                                        bg-secondary text-on-secondary shadow-md scale-95
                                                    @elseif($esHoy && $tieneEspacios && !$esPasado) 
                                                        border-2 border-secondary text-secondary hover:bg-secondary-container
                                                    @elseif($tieneEspacios && !$esPasado) 
                                                        border border-outline-variant hover:bg-secondary-container hover:border-secondary cursor-pointer text-on-surface
                                                    @else
                                                        text-gray-300 cursor-not-allowed opacity-40 line-through
                                                    @endif
                                                ">
                                            {{ $diaNumero }}
                                            
                                            @if($tieneEspacios && !$esPasado && !$esSeleccionado)
                                                <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-green-500 rounded-full"></span>
                                            @endif
                                            @if($esSeleccionado && $tieneEspacios)
                                                <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-white rounded-full border border-secondary"></span>
                                            @endif
                                        </button>
                                    @else
                                        <div class="w-full h-full"></div>
                                    @endif
                                </div>
                            @endfor
                        </div>

                        {{-- Leyenda --}}
                        <div class="flex items-center gap-4 mt-3 pt-3 border-t border-gray-100">
                            <span class="flex items-center gap-1 text-xs text-gray-600">
                                <span class="w-3 h-3 rounded-full bg-secondary inline-block"></span>
                                Seleccionado
                            </span>
                            <span class="flex items-center gap-1 text-xs text-gray-600">
                                <span class="w-3 h-3 rounded-full bg-green-500 inline-block"></span>
                                Disponible
                            </span>
                            <span class="flex items-center gap-1 text-xs text-gray-400">
                                <span class="w-3 h-3 rounded-full border border-gray-300 inline-block"></span>
                                Sin espacios
                            </span>
                            <span class="flex items-center gap-1 text-xs text-gray-400">
                                <span class="w-3 h-3 rounded-full bg-gray-200 inline-block"></span>
                                No disponible
                            </span>
                        </div>
                    </div>
                @endif

                @error('fecha') 
                    <span class="font-body-sm text-body-sm text-error block mt-xs">{{ $message }}</span> 
                @enderror
            </div>

            {{-- HORAS DISPONIBLES --}}
            @if($fecha && count($horasDisponibles) > 0)
            <div class="space-y-xs">
                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">
                    Horas disponibles para {{ Carbon\Carbon::parse($fecha)->format('d/m/Y') }}
                </label>
                <div class="grid grid-cols-3 gap-1">
                    @foreach($horasDisponibles as $hora)
                        <button type="button"
                                @if($hora['disponible'])
                                    wire:click="seleccionarHora('{{ $hora['inicio'] }}')"
                                @else
                                    disabled
                                @endif
                                class="py-2 rounded-lg text-sm transition text-center
                                    @if($hora['inicio'] === $horaInicio && $hora['disponible'])
                                        bg-secondary text-on-secondary shadow-md scale-95
                                    @elseif($hora['disponible'])
                                        border border-outline-variant hover:bg-secondary-container hover:border-secondary text-on-surface cursor-pointer
                                    @else
                                        bg-surface-container-low text-outline cursor-not-allowed opacity-50 line-through
                                    @endif
                                ">
                            {{ $hora['inicio'] }}
                            @if(!$hora['disponible'])
                                <span class="block text-[10px]">ocupado</span>
                            @endif
                        </button>
                    @endforeach
                </div>
                @error('horaInicio') <span class="font-body-sm text-body-sm text-error block mt-xs">{{ $message }}</span> @enderror
            </div>
            @endif

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

    {{-- HISTORIAL --}}
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

<style>
    [x-cloak] { display: none !important; }
</style>