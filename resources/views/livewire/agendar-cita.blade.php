<div>
    @if ($confirmado)
        <div class="text-center py-8">
            <div class="text-green-600 text-4xl mb-4">✓</div>
            <h2 class="text-xl font-bold mb-2">¡Cita agendada!</h2>
            <p class="text-gray-500">Te esperamos el {{ $fecha }} a las {{ $horaInicio }}.</p>
        </div>
    @else
        <h2 class="text-xl font-bold mb-4 text-center">Agenda tu cita</h2>

        @if ($error)
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ $error }}</div>
        @endif

        {{-- Paso 1: Servicio --}}
        <div class="mb-6">
            <label class="block text-sm font-medium mb-2">1. Elige un servicio</label>
            <div class="space-y-2">
                @foreach ($servicios as $servicio)
                    <button type="button"
                            wire:click="seleccionarServicio({{ $servicio->id }})"
                            class="w-full text-left px-4 py-3 border rounded {{ $servicioId === $servicio->id ? 'border-blue-600 bg-blue-50' : 'border-gray-200' }}">
                        <div class="flex justify-between">
                            <span>{{ $servicio->nombre }}</span>
                            <span class="text-gray-500">${{ $servicio->precio }} · {{ $servicio->duracion_minutos }} min</span>
                        </div>
                    </button>
                @endforeach
            </div>
            @error('servicioId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Paso 2: Colaborador (solo los que saben hacer el servicio elegido) --}}
        @if ($servicioId)
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">2. Elige a quién te atenderá</label>
                <div class="space-y-2">
                    @forelse ($colaboradores as $colaborador)
                        <button type="button"
                                wire:click="seleccionarColaborador({{ $colaborador->id }})"
                                class="w-full text-left px-4 py-3 border rounded {{ $colaboradorId === $colaborador->id ? 'border-blue-600 bg-blue-50' : 'border-gray-200' }}">
                            {{ $colaborador->nombre }}
                        </button>
                    @empty
                        <p class="text-gray-400 text-sm">Ningún colaborador ofrece este servicio por el momento.</p>
                    @endforelse
                </div>
                @error('colaboradorId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        @endif

        {{-- Paso 3: Fecha --}}
        @if ($colaboradorId)
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">3. Elige la fecha</label>
                <input type="date" wire:model.live="fecha" min="{{ now()->format('Y-m-d') }}"
                       class="w-full border rounded px-3 py-2">
                @error('fecha') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        @endif

        {{-- Paso 4: Horario (depende de colaborador + servicio + fecha) --}}
        @if ($fecha)
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">4. Elige un horario</label>
                <div class="grid grid-cols-3 gap-2">
                    @forelse ($horariosDisponibles as $hora)
                        <button type="button"
                                wire:click="seleccionarHorario('{{ $hora }}')"
                                class="px-3 py-2 border rounded text-sm {{ $horaInicio === $hora ? 'border-blue-600 bg-blue-50' : 'border-gray-200' }}">
                            {{ $hora }}
                        </button>
                    @empty
                        <p class="text-gray-400 text-sm col-span-3">No hay horarios disponibles ese día.</p>
                    @endforelse
                </div>
                @error('horaInicio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        @endif

        {{-- Acompañante (opcional) + Confirmar --}}
        @if ($horaInicio)
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">¿Vienes con alguien? (opcional)</label>
                <input type="text" wire:model="nombreAcompanante" placeholder="Nombre del acompañante"
                       class="w-full border rounded px-3 py-2">
            </div>

            <button wire:click="confirmarCita"
                    class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700"
                    wire:loading.attr="disabled">
                <span wire:loading.remove>Confirmar cita</span>
                <span wire:loading>Agendando...</span>
            </button>
        @endif
    @endif
</div>