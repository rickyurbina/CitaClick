<div>
    <!-- Info del cliente -->
    <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg p-4 mb-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Bienvenido</p>
                <h3 class="text-lg font-bold text-gray-800">{{ $cliente->nombre }}</h3>
                <p class="text-sm text-gray-600">📱 {{ $cliente->telefono }}</p>
            </div>
            <div class="text-right">
                <div class="flex space-x-3">
                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">
                        👍 {{ $puntosBuenos ?? 0 }}
                    </span>
                    <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full">
                        👎 {{ $puntosMalos ?? 0 }}
                    </span>
                </div>
                @if(isset($cliente) && $cliente->estaBloqueado())
                    <span class="text-xs bg-red-500 text-white px-2 py-1 rounded-full block mt-1">
                        🚫 Bloqueado hasta {{ $cliente->bloqueado_hasta->format('d/m/Y') }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Botones de navegación -->
    <div class="flex space-x-2 mb-4">
        <button wire:click="mostrarFormularioCita" 
                class="flex-1 px-3 py-2 rounded-lg text-sm font-medium transition
                    {{ $mostrarFormulario ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            📝 Nueva Cita
        </button>
        <button wire:click="verHistorial" 
                class="flex-1 px-3 py-2 rounded-lg text-sm font-medium transition
                    {{ $mostrarHistorial ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            📋 Historial ({{ $totalCitas ?? 0 }})
        </button>
        <button wire:click="volver" 
                class="px-3 py-2 rounded-lg text-sm font-medium bg-gray-200 hover:bg-gray-300 text-gray-700 transition">
            ⬅️
        </button>
    </div>

    <!-- FORMULARIO DE CITA -->
    @if($mostrarFormulario ?? false)
    <div class="border-t pt-4">
        <form wire:submit.prevent="agendarCita" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Servicio *</label>
                <select wire:model="servicioId" class="w-full border rounded-lg p-2">
                    <option value="">Seleccionar servicio</option>
                    @foreach($servicios as $servicio)
                        <option value="{{ $servicio->id }}">
                            {{ $servicio->nombre }} - ${{ number_format($servicio->precio, 2) }}
                            ({{ $servicio->duracion_minutos }} min)
                        </option>
                    @endforeach
                </select>
                @error('servicioId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Colaborador *</label>
                <select wire:model="colaboradorId" class="w-full border rounded-lg p-2">
                    <option value="">Seleccionar colaborador</option>
                    @foreach($colaboradores as $colaborador)
                        <option value="{{ $colaborador->id }}">{{ $colaborador->nombre }}</option>
                    @endforeach
                </select>
                @error('colaboradorId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha *</label>
                    <input type="date" wire:model="fecha" min="{{ date('Y-m-d') }}" 
                           class="w-full border rounded-lg p-2">
                    @error('fecha') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hora *</label>
                    <input type="time" wire:model="horaInicio" step="900"
                           class="w-full border rounded-lg p-2">
                    @error('horaInicio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del acompañante</label>
                <input type="text" wire:model="nombreAcompanante" 
                       class="w-full border rounded-lg p-2" placeholder="Opcional">
                @error('nombreAcompanante') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                <textarea wire:model="observaciones" rows="2" 
                          class="w-full border rounded-lg p-2" placeholder="Alguna observación..."></textarea>
                @error('observaciones') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition flex items-center justify-center"
                    wire:loading.attr="disabled"
                    wire:target="agendarCita">
                <span wire:loading.remove wire:target="agendarCita">
                    📅 Agendar Cita
                </span>
                <span wire:loading wire:target="agendarCita" class="flex items-center">
                    <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                    </svg>
                    Agendando...
                </span>
            </button>
        </form>
    </div>
    @endif

    <!-- HISTORIAL DE CITAS -->
    @if($mostrarHistorial ?? false)
    <div class="border-t pt-4">
        @if(($totalCitas ?? 0) > 0)
            <div class="space-y-3 max-h-80 overflow-y-auto pr-2">
                @foreach($citasAnteriores ?? [] as $cita)
                    <div class="bg-gray-50 rounded-lg p-3 hover:shadow-md transition">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <span class="font-medium text-gray-800">{{ $cita->servicio->nombre ?? 'Servicio' }}</span>
                                    <span class="text-xs px-2 py-0.5 rounded-full 
                                        @if($cita->estado == 'atendida') bg-green-100 text-green-800
                                        @elseif($cita->estado == 'cancelada') bg-red-100 text-red-800
                                        @elseif($cita->estado == 'confirmada') bg-blue-100 text-blue-800
                                        @elseif($cita->estado == 'en_curso') bg-purple-100 text-purple-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($cita->estado ?? 'agendada') }}
                                    </span>
                                </div>
                                <div class="text-sm text-gray-600 mt-1">
                                    📅 {{ isset($cita->fecha) ? Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') : '' }}
                                    🕐 {{ $cita->hora_inicio ?? '' }} - {{ $cita->hora_fin ?? '' }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    👤 {{ $cita->colaborador->nombre ?? 'Sin asignar' }}
                                    @if($cita->monto_pagado ?? false)
                                        💰 ${{ number_format($cita->monto_pagado, 2) }}
                                    @endif
                                </div>
                                @if(($cita->estado ?? '') == 'cancelada' && ($cita->motivo_cancelacion ?? ''))
                                    <div class="text-xs text-red-500 mt-1">❌ {{ $cita->motivo_cancelacion }}</div>
                                @endif
                            </div>
                            @if(in_array($cita->estado ?? '', ['agendada', 'confirmada']))
                                <button wire:click="cancelarCita({{ $cita->id }})" 
                                        onclick="confirm('¿Cancelar esta cita?') || event.stopImmediatePropagation()"
                                        class="text-red-600 hover:text-red-800 text-sm font-medium">
                                    Cancelar
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            @if(($totalCitas ?? 0) > 10)
                <p class="text-xs text-gray-400 text-center mt-2">
                    Mostrando las últimas 10 citas. Total: {{ $totalCitas }}
                </p>
            @endif
        @else
            <div class="text-center py-8">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-gray-500">No tienes citas registradas</p>
                <p class="text-sm text-gray-400">¡Agenda tu primera cita!</p>
            </div>
        @endif
    </div>
    @endif
</div>