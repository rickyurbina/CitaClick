<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">📅 Gestión de Citas</h2>
        <div class="flex space-x-2">
            @if($puedeCrearServicios ?? false)
                <button wire:click="abrirCrearServicio" 
                        class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nuevo Servicio
                </button>
            @endif

            @if($puedeCrearColaboradores ?? false)
                <button wire:click="abrirCrearColaborador" 
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    Nuevo Colaborador
                </button>
            @endif

            @if($puedeGestionar ?? false)
                <button wire:click="abrirCrearCita" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nueva Cita
                </button>
            @endif
        </div>
    </div>

    <!-- Tarjetas de métricas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-sm text-gray-500">Citas de Hoy</div>
            <div class="text-2xl font-bold">{{ $citasHoy }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-sm text-gray-500">Ingresos de Hoy</div>
            <div class="text-2xl font-bold text-green-600">${{ number_format($ingresosHoy, 2) }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-sm text-gray-500">Total Citas</div>
            <div class="text-2xl font-bold">{{ $citas->total() }}</div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <div>
                <label class="text-sm text-gray-600">Fecha</label>
                <input type="date" wire:model.live="filtroFecha" class="w-full border rounded-lg p-2 text-sm">
            </div>
            <div>
                <label class="text-sm text-gray-600">Estado</label>
                <select wire:model.live="filtroEstado" class="w-full border rounded-lg p-2 text-sm">
                    <option value="">Todos</option>
                    <option value="agendada">Agendada</option>
                    <option value="confirmada">Confirmada</option>
                    <option value="en_curso">En curso</option>
                    <option value="atendida">Atendida</option>
                    <option value="cancelada">Cancelada</option>
                    <option value="no_asistio">No asistió</option>
                </select>
            </div>
            <div>
                <label class="text-sm text-gray-600">Colaborador</label>
                <select wire:model.live="filtroColaborador" class="w-full border rounded-lg p-2 text-sm">
                    <option value="">Todos</option>
                    @foreach($colaboradores as $colab)
                        <option value="{{ $colab->id }}">{{ $colab->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm text-gray-600">Buscar cliente</label>
                <input type="text" wire:model.live.debounce.300ms="buscarCliente" 
                       placeholder="Nombre o teléfono..." 
                       class="w-full border rounded-lg p-2 text-sm">
            </div>
        </div>
        <div class="mt-3">
            <button wire:click="limpiarFiltros" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-1 rounded-lg text-sm">
                Limpiar filtros
            </button>
        </div>
    </div>

    <!-- Tabla de citas -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Servicio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Colaborador</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha/Hora</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($citas as $cita)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $cita->cliente->nombre }}</div>
                            <div class="text-xs text-gray-500">{{ $cita->cliente->telefono }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $cita->servicio->nombre }}</div>
                            <div class="text-xs text-gray-500">{{ $cita->servicio->duracion_minutos }} min</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $cita->colaborador->nombre }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $cita->fecha }}</div>
                            <div class="text-xs text-gray-500">{{ $cita->hora_inicio }} - {{ $cita->hora_fin }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($cita->estado == 'agendada') bg-yellow-100 text-yellow-800
                                @elseif($cita->estado == 'confirmada') bg-blue-100 text-blue-800
                                @elseif($cita->estado == 'en_curso') bg-purple-100 text-purple-800
                                @elseif($cita->estado == 'atendida') bg-green-100 text-green-800
                                @elseif($cita->estado == 'cancelada') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($cita->estado) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium {{ $cita->pagado ? 'text-green-600' : 'text-red-600' }}">
                                ${{ number_format($cita->monto_pagado ?? 0, 2) }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $cita->pagado ? 'Pagado' : 'Pendiente' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                @if($puedeGestionar ?? false)
                                    <button wire:click="editarCita({{ $cita->id }})" 
                                            class="text-blue-600 hover:text-blue-900">
                                        Editar
                                    </button>
                                    <button wire:click="eliminarCita({{ $cita->id }})" 
                                            onclick="confirm('¿Eliminar esta cita?') || event.stopImmediatePropagation()"
                                            class="text-red-600 hover:text-red-900">
                                        Eliminar
                                    </button>
                                @endif
                                
                                @if($esColaborador ?? false)
                                    <button wire:click="cambiarEstado({{ $cita->id }}, 'en_curso')" 
                                            class="text-purple-600 hover:text-purple-900 text-xs">
                                        En curso
                                    </button>
                                    <button wire:click="cambiarEstado({{ $cita->id }}, 'atendida')" 
                                            class="text-green-600 hover:text-green-900 text-xs">
                                        Atendida
                                    </button>
                                @endif

                                @if($puedeGestionar ?? false)
                                    <div class="relative group">
                                        <button class="text-gray-600 hover:text-gray-900 text-xs">
                                            Estados ▾
                                        </button>
                                        <div class="absolute hidden group-hover:block bg-white shadow-lg rounded-lg p-2 z-10 min-w-32">
                                            @foreach(['agendada', 'confirmada', 'en_curso', 'atendida', 'cancelada', 'no_asistio'] as $estado)
                                                <button wire:click="cambiarEstado({{ $cita->id }}, '{{ $estado }}')" 
                                                        class="block w-full text-left px-3 py-1 text-sm hover:bg-gray-100 rounded">
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
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            No hay citas registradas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t">
            {{ $citas->links() }}
        </div>
    </div>

    <!-- ==================== MODAL CITA ==================== -->
    @if($mostrarModalCita)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <h3 class="text-lg font-bold mb-4">
                    {{ $citaIdEditar ? 'Editar Cita' : 'Nueva Cita' }}
                </h3>
                
                <form wire:submit.prevent="guardarCita">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cliente *</label>
                            <select wire:model="clienteId" class="w-full border rounded-lg p-2">
                                <option value="">Seleccionar cliente</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }} - {{ $cliente->telefono }}</option>
                                @endforeach
                            </select>
                            @error('clienteId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

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
                                    <option value="{{ $colaborador->id }}">
                                        {{ $colaborador->nombre }}
                                        @if($colaborador->comision_porcentaje)
                                            ({{ $colaborador->comision_porcentaje }}% comisión)
                                        @endif
                                    </option>
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
                            <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                            <select wire:model="estado" class="w-full border rounded-lg p-2">
                                <option value="agendada">Agendada</option>
                                <option value="confirmada">Confirmada</option>
                                <option value="en_curso">En curso</option>
                                <option value="atendida">Atendida</option>
                                <option value="cancelada">Cancelada</option>
                                <option value="no_asistio">No asistió</option>
                            </select>
                            @error('estado') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Monto</label>
                            <input type="number" step="0.01" min="0" wire:model="montoPagado" 
                                   class="w-full border rounded-lg p-2">
                            @error('montoPagado') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Método de pago</label>
                            <select wire:model="metodoPago" class="w-full border rounded-lg p-2">
                                <option value="">No especificado</option>
                                <option value="efectivo">Efectivo</option>
                                <option value="transferencia">Transferencia</option>
                                <option value="tarjeta">Tarjeta</option>
                            </select>
                            @error('metodoPago') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" wire:model="pagado" id="pagado" class="rounded border-gray-300">
                            <label for="pagado" class="ml-2 text-sm text-gray-700">¿Pagado?</label>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                        <button type="button" wire:click="cerrarModalCita" 
                                class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
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
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <h3 class="text-lg font-bold mb-4">
                    {{ $colaboradorIdEditar ? 'Editar Colaborador' : 'Nuevo Colaborador' }}
                </h3>
                
                <form wire:submit.prevent="guardarColaborador">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                            <input type="text" wire:model="colaboradorNombre" 
                                   class="w-full border rounded-lg p-2">
                            @error('colaboradorNombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" wire:model="colaboradorEmail" 
                                   class="w-full border rounded-lg p-2">
                            @error('colaboradorEmail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                            <input type="text" wire:model="colaboradorTelefono" 
                                   class="w-full border rounded-lg p-2">
                            @error('colaboradorTelefono') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                {{ $colaboradorIdEditar ? 'Nueva Contraseña (opcional)' : 'Contraseña *' }}
                            </label>
                            <input type="password" wire:model="colaboradorPassword" 
                                   class="w-full border rounded-lg p-2">
                            @error('colaboradorPassword') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            @if($colaboradorIdEditar)
                                <p class="text-xs text-gray-500 mt-1">Dejar en blanco para mantener la contraseña actual</p>
                            @endif
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Comisión (%)</label>
                            <input type="number" step="0.01" min="0" max="100" wire:model="colaboradorComision" 
                                   class="w-full border rounded-lg p-2" placeholder="Ej: 10">
                            @error('colaboradorComision') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Hora inicio</label>
                                <input type="time" wire:model="colaboradorHorarioInicio" 
                                       class="w-full border rounded-lg p-2">
                                @error('colaboradorHorarioInicio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Hora fin</label>
                                <input type="time" wire:model="colaboradorHorarioFin" 
                                       class="w-full border rounded-lg p-2">
                                @error('colaboradorHorarioFin') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Servicios del colaborador -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Servicios que puede realizar *
                            </label>
                            <p class="text-xs text-gray-500 mb-2">Selecciona uno o varios servicios</p>
                            
                            <div class="space-y-2 max-h-40 overflow-y-auto border rounded-lg p-2">
                                @foreach($serviciosAll as $servicio)
                                    <label class="flex items-center hover:bg-gray-50 p-1 rounded cursor-pointer">
                                        <input type="checkbox" 
                                               wire:model="colaboradorServicios" 
                                               value="{{ $servicio->id }}"
                                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="ml-2 text-sm">
                                            {{ $servicio->nombre }}
                                            <span class="text-gray-400 text-xs">
                                                ({{ $servicio->duracion_minutos }} min - ${{ number_format($servicio->precio, 2) }})
                                            </span>
                                            @if(!$servicio->activo)
                                                <span class="text-red-400 text-xs">(Inactivo)</span>
                                            @endif
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            
                            @error('colaboradorServicios') 
                                <span class="text-red-500 text-sm block mt-1">{{ $message }}</span> 
                            @enderror
                            
                            @if(count($colaboradorServicios) > 0)
                                <div class="mt-2 flex flex-wrap gap-1">
                                    @foreach($colaboradorServicios as $servicioId)
                                        @php
                                            $servicio = $serviciosAll->firstWhere('id', $servicioId);
                                        @endphp
                                        @if($servicio)
                                            <span class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                                {{ $servicio->nombre }}
                                                <button type="button" 
                                                        wire:click="$set('colaboradorServicios', {{ json_encode(array_diff($colaboradorServicios, [$servicioId])) }})"
                                                        class="ml-1 text-blue-600 hover:text-blue-800">
                                                    ×
                                                </button>
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" wire:model="colaboradorActivo" id="colaboradorActivo" class="rounded border-gray-300">
                            <label for="colaboradorActivo" class="ml-2 text-sm text-gray-700">Activo</label>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                        <button type="button" wire:click="cerrarModalColaborador" 
                                class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg">
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
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <h3 class="text-lg font-bold mb-4">
                    {{ $servicioIdEditar ? 'Editar Servicio' : 'Nuevo Servicio' }}
                </h3>
                
                <form wire:submit.prevent="guardarServicio">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                            <input type="text" wire:model="servicioNombre" 
                                   class="w-full border rounded-lg p-2" placeholder="Ej: Corte de cabello">
                            @error('servicioNombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Duración (minutos) *</label>
                            <input type="number" min="5" step="5" wire:model="servicioDuracion" 
                                   class="w-full border rounded-lg p-2" placeholder="30">
                            @error('servicioDuracion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Precio *</label>
                            <input type="number" step="0.01" min="0" wire:model="servicioPrecio" 
                                   class="w-full border rounded-lg p-2" placeholder="0.00">
                            @error('servicioPrecio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Puntos que genera</label>
                            <input type="number" min="0" wire:model="servicioPuntos" 
                                   class="w-full border rounded-lg p-2" placeholder="10">
                            @error('servicioPuntos') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            <p class="text-xs text-gray-500 mt-1">Puntos que recibe el cliente al agendar esta cita</p>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" wire:model="servicioActivo" id="servicioActivo" class="rounded border-gray-300">
                            <label for="servicioActivo" class="ml-2 text-sm text-gray-700">Activo</label>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                        <button type="button" wire:click="cerrarModalServicio" 
                                class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg">
                            {{ $servicioIdEditar ? 'Actualizar' : 'Guardar' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>