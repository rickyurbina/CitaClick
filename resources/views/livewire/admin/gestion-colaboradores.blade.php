<div>
    {{-- MENSAJES --}}
    @if($mensaje)
        <div class="mb-md p-md rounded-lg border flex justify-between items-start gap-md
            {{ $tipoMensaje === 'success' ? 'bg-secondary-container/40 border-secondary text-on-secondary-container' : 'bg-error-container border-error text-error' }}">
            <span class="font-body-sm text-body-sm">{{ $mensaje }}</span>
            <button type="button" wire:click="$set('mensaje', null)" class="shrink-0" aria-label="Cerrar">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>
    @endif

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-md mb-xl">
        <div>
            <h2 class="font-headline-md text-headline-md text-on-surface">Equipo de Trabajo</h2>
            <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Gestiona los colaboradores y recepcionistas de la empresa</p>
        </div>
        @if($esAdmin)
        <div class="flex flex-wrap gap-2">
            <button wire:click="abrirCrear('recepcionista')" type="button" class="inline-flex items-center gap-sm px-md py-3 bg-primary-container text-on-primary-container font-label-md text-label-md rounded-lg hover:brightness-110 active:scale-95 transition-all shadow-md">
                <span class="material-symbols-outlined">person_add</span> Nuevo Recepcionista
            </button>
            <button wire:click="abrirCrear('colaborador')" type="button" class="inline-flex items-center gap-sm px-md py-3 bg-secondary text-on-secondary font-label-md text-label-md rounded-lg hover:brightness-110 active:scale-95 transition-all shadow-md">
                <span class="material-symbols-outlined">person_add</span> Nuevo Colaborador
            </button>
        </div>
        @endif
    </div>

    {{-- TARJETAS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-lg mb-xl">
        <div class="p-lg bg-surface border border-outline-variant rounded-xl shadow-sm flex items-center gap-lg">
            <div class="w-12 h-12 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
                <span class="material-symbols-outlined">group</span>
            </div>
            <div>
                <p class="text-label-sm text-on-surface-variant uppercase tracking-wider font-label-sm">Total Equipo</p>
                <h4 class="text-headline-md font-bold text-on-surface">{{ $totalColaboradores }}</h4>
            </div>
        </div>
        <div class="p-lg bg-surface border border-outline-variant rounded-xl shadow-sm flex items-center gap-lg">
            <div class="w-12 h-12 rounded-full bg-surface-container-high flex items-center justify-center text-secondary">
                <span class="material-symbols-outlined">check_circle</span>
            </div>
            <div>
                <p class="text-label-sm text-on-surface-variant uppercase tracking-wider font-label-sm">Usuarios Activos</p>
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
                        <th class="px-lg py-4 font-label-md text-label-md text-on-surface">Usuario</th>
                        <th class="px-lg py-4 font-label-md text-label-md text-on-surface">Rol</th>
                        <th class="px-lg py-4 font-label-md text-label-md text-on-surface">Contacto</th>
                        <th class="px-lg py-4 font-label-md text-label-md text-on-surface">Horario</th>
                        <th class="px-lg py-4 font-label-md text-label-md text-on-surface">Comisión</th>
                        <th class="px-lg py-4 font-label-md text-label-md text-on-surface">Estado</th>
                        <th class="px-lg py-4 font-label-md text-label-md text-on-surface text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($usuarios as $usuario)
                    <tr class="hover:bg-surface-container-low transition-colors group">
                        <td class="px-lg py-4">
                            <div class="flex items-center gap-md">
                                @if($usuario->foto_src)
                                    <div class="w-10 h-10 rounded-full overflow-hidden border border-outline-variant flex-shrink-0 bg-white">
                                        <img src="{{ $usuario->foto_src }}" alt="{{ $usuario->nombre }}" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-10 h-10 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center flex-shrink-0">
                                        <span class="material-symbols-outlined text-sm">person</span>
                                    </div>
                                @endif
                                <div>
                                    <span class="font-body-md font-semibold text-on-surface">{{ $usuario->nombre }}</span>
                                    <div class="font-body-sm text-body-sm text-on-surface-variant">ID: #{{ $usuario->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-lg py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium 
                                {{ $usuario->rol === 'recepcionista' ? 'bg-primary-container text-on-primary-container' : 'bg-secondary-container text-on-secondary-container' }}">
                                {{ ucfirst($usuario->rol) }}
                            </span>
                        </td>
                        <td class="px-lg py-4">
                            <div class="font-body-md text-body-md text-on-surface">{{ $usuario->email }}</div>
                            <div class="font-body-sm text-body-sm text-on-surface-variant">{{ $usuario->telefono ?? 'Sin teléfono' }}</div>
                        </td>
                        <td class="px-lg py-4 font-body-md text-body-md text-on-surface-variant">
                            @if($usuario->rol === 'colaborador')
                                @php
                                    $horario = $usuario->horario;
                                    $diasActivos = [];
                                    if ($horario) {
                                        foreach ($horario->configuracion as $dia => $data) {
                                            if ($data['activo']) {
                                                $diasActivos[] = ucfirst($dia) . ' ' . $data['inicio'] . '-' . $data['fin'];
                                            }
                                        }
                                    }
                                @endphp
                                @if(count($diasActivos) > 0)
                                    <span class="block text-xs">{{ implode(', ', array_slice($diasActivos, 0, 2)) }}</span>
                                    @if(count($diasActivos) > 2)
                                        <span class="text-xs text-on-surface-variant">+{{ count($diasActivos)-2 }} más</span>
                                    @endif
                                @else
                                    <span class="text-on-surface-variant">No definido</span>
                                @endif
                            @else
                                <span class="text-outline text-xs">Horario de oficina</span>
                            @endif
                        </td>
                        <td class="px-lg py-4 font-body-md text-body-md text-on-surface">
                            {{ $usuario->rol === 'colaborador' && $usuario->comision_porcentaje ? $usuario->comision_porcentaje . '%' : '-' }}
                        </td>
                        <td class="px-lg py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium @if($usuario->activo) bg-secondary-container text-on-secondary-container @else bg-error-container text-on-error-container @endif">
                                {{ $usuario->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="px-lg py-4 text-right">
                            <div class="flex justify-end gap-sm">
                                <button wire:click="abrirEditar({{ $usuario->id }})" class="p-2 text-on-surface-variant hover:bg-secondary-container hover:text-on-secondary-container rounded transition-colors" title="Editar"><span class="material-symbols-outlined">edit</span></button>
                                <button wire:click="toggleActivo({{ $usuario->id }})" class="p-2 text-on-surface-variant hover:bg-surface-container-high rounded transition-colors" title="{{ $usuario->activo ? 'Desactivar' : 'Activar' }}">
                                    @if($usuario->activo) <span class="material-symbols-outlined">block</span> @else <span class="material-symbols-outlined">check_circle</span> @endif
                                </button>
                                <button wire:click="eliminar({{ $usuario->id }})" class="p-2 text-on-surface-variant hover:bg-error-container hover:text-error rounded transition-colors" title="Eliminar"><span class="material-symbols-outlined">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-lg py-2xl text-center text-on-surface-variant"><span class="material-symbols-outlined text-4xl text-outline mb-3 block">group_off</span><p class="font-body-md text-body-md">No hay usuarios registrados</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-lg py-md border-t border-outline-variant bg-surface-container-low">{{ $usuarios->links() }}</div>
    </div>

    {{-- MODAL FORMULARIO --}}
    @if($mostrarModal)
    <div class="fixed inset-0 bg-on-surface/40 flex items-center justify-center z-50 p-4"
         x-data="{ open: true }"
         x-init="$watch('open', value => { if (!value) @this.cerrarModal(); })"
         @click.away="open = false">
        <div class="bg-surface-container-lowest rounded-xl border border-outline-variant max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-lg">
            <div class="sticky top-0 bg-surface-container-lowest z-10 px-lg py-md border-b border-outline-variant flex justify-between items-center">
                <h3 class="font-headline-md text-headline-md text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary">{{ $colaboradorIdEditar ? 'edit' : 'person_add' }}</span>
                    {{ $colaboradorIdEditar ? 'Editar' : 'Nuevo' }} {{ ucfirst($rol) }}
                </h3>
                <button type="button" wire:click="cerrarModal" class="p-2 text-on-surface-variant hover:bg-surface-container-high rounded-lg transition-colors"><span class="material-symbols-outlined">close</span></button>
            </div>
            <form wire:submit.prevent="guardar" class="p-lg space-y-md" enctype="multipart/form-data">
                <div class="flex flex-col items-center gap-sm pb-md border-b border-outline-variant">
                    <div class="relative group">
                        <div class="w-28 h-28 rounded-xl overflow-hidden border-2 border-dashed border-outline-variant bg-surface-container-low flex items-center justify-center">
                            @if($fotoPreviewUrl)
                                <img src="{{ $fotoPreviewUrl }}" alt="Vista previa" class="w-full h-full object-cover">
                            @else
                                <span class="material-symbols-outlined text-outline text-[40px]">add_a_photo</span>
                            @endif
                        </div>
                        <label class="absolute -bottom-2 -right-2 bg-primary text-on-primary p-2 rounded-full shadow-lg hover:scale-105 transition-transform cursor-pointer">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                            <input type="file" wire:model="fotoFile" accept="image/*" class="hidden">
                        </label>
                    </div>
                    <p class="font-label-sm text-label-sm text-on-surface-variant">Foto de perfil</p>
                    <div wire:loading wire:target="fotoFile" class="font-label-sm text-label-sm text-secondary">
                        Subiendo imagen...
                    </div>
                    @error('fotoFile') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                    @if($fotoExistente && !$fotoFile)
                        <button type="button" wire:click="$set('fotoExistente', null)" class="font-label-sm text-label-sm text-error hover:underline">Quitar foto</button>
                    @endif
                    @if($fotoFile)
                        <button type="button" wire:click="$set('fotoFile', null)" class="font-label-sm text-label-sm text-error hover:underline">Cancelar nueva foto</button>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
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
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
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
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                    @if($rol === 'colaborador')
                    <div class="flex flex-col gap-xs">
                        <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Comisión (%)</label>
                        <input type="number" step="0.01" min="0" max="100" wire:model="comision" class="w-full h-12 px-md border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all font-body-md text-body-md text-on-surface" placeholder="Ej: 10">
                        @error('comision') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                    </div>
                    @endif
                    <div class="flex items-center gap-2 {{ $rol === 'recepcionista' ? 'mt-6' : 'mt-6' }}">
                        <input type="checkbox" wire:model="activo" id="activo" class="w-4 h-4 text-secondary border-outline-variant rounded focus:ring-secondary">
                        <label for="activo" class="font-body-sm text-body-sm text-on-surface">Usuario Activo</label>
                    </div>
                </div>

                {{-- HORARIO Y SERVICIOS SOLO PARA COLABORADORES --}}
                @if($rol === 'colaborador')
                    <div class="border-t border-outline-variant pt-md">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-md gap-3">
                            <div>
                                <h4 class="font-label-md text-label-md text-on-surface">Horario semanal</h4>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">Activa los días y define el horario.</p>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <button type="button" wire:click="marcarTodosLosDias" class="px-3 py-1.5 text-xs font-semibold bg-secondary-container/50 text-on-secondary-container rounded-full hover:bg-secondary-container transition-all flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">done_all</span> Activar todos
                                </button>
                                <button type="button" wire:click="desmarcarTodosLosDias" class="px-3 py-1.5 text-xs font-semibold bg-surface-container-high text-on-surface-variant rounded-full hover:bg-error-container hover:text-error transition-all flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">remove_done</span> Desactivar todos
                                </button>
                            </div>
                        </div>
                        
                        <div class="flex flex-col gap-3 md:grid md:grid-cols-2">
                            @php
                                $diasEspañol = [
                                    'lunes' => 'Lunes',
                                    'martes' => 'Martes',
                                    'miercoles' => 'Miércoles',
                                    'jueves' => 'Jueves',
                                    'viernes' => 'Viernes',
                                    'sabado' => 'Sábado',
                                    'domingo' => 'Domingo',
                                ];
                            @endphp
                            @foreach($diasEspañol as $key => $label)
                            <div class="w-full p-3 border rounded-xl flex flex-col gap-3 transition-all duration-200 
                                {{ $diasHorario[$key]['activo'] ? 'bg-white border-secondary/40 shadow-sm' : 'bg-surface-container-lowest border-outline-variant opacity-70' }}">
                                
                                <div class="flex items-center justify-between">
                                    <label class="flex items-center gap-3 cursor-pointer select-none">
                                        <div class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" wire:model.live="diasHorario.{{ $key }}.activo" class="sr-only peer">
                                            <div class="w-10 h-5 bg-outline-variant/40 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-secondary"></div>
                                        </div>
                                        <span class="font-label-md text-label-md font-semibold {{ $diasHorario[$key]['activo'] ? 'text-on-surface' : 'text-on-surface-variant' }}">{{ $label }}</span>
                                    </label>
                                    
                                    @if($diasHorario[$key]['activo'])
                                        <button type="button" wire:click="aplicarHorarioATodos('{{ $key }}')" title="Copiar este horario a todos los días activos" class="p-1.5 text-on-surface-variant hover:text-secondary hover:bg-secondary-container/20 rounded transition-colors flex items-center justify-center">
                                            <span class="material-symbols-outlined text-[18px]">content_copy</span>
                                        </button>
                                    @endif
                                </div>
                                
                                <div class="flex items-center gap-2 {{ $diasHorario[$key]['activo'] ? '' : 'pointer-events-none opacity-50' }}">
                                    <input type="time" wire:model="diasHorario.{{ $key }}.inicio" class="w-full border border-outline-variant rounded-lg px-2 py-1.5 font-body-sm text-sm bg-white focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all cursor-pointer" {{ $diasHorario[$key]['activo'] ? '' : 'disabled' }}>
                                    <span class="text-on-surface-variant text-xs font-bold">a</span>
                                    <input type="time" wire:model="diasHorario.{{ $key }}.fin" class="w-full border border-outline-variant rounded-lg px-2 py-1.5 font-body-sm text-sm bg-white focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all cursor-pointer" {{ $diasHorario[$key]['activo'] ? '' : 'disabled' }}>
                                </div>
                                
                                @error("diasHorario.$key.inicio") <span class="text-error text-[10px]">{{ $message }}</span> @enderror
                                @error("diasHorario.$key.fin") <span class="text-error text-[10px]">{{ $message }}</span> @enderror
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex flex-col gap-xs pt-md border-t border-outline-variant">
                        <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Servicios que realiza *</label>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mb-2">Selecciona al menos un servicio</p>
                        <div class="space-y-2 max-h-40 overflow-y-auto border border-outline-variant rounded-lg p-2 bg-surface">
                            @foreach($serviciosDisponibles as $servicio)
                            <label class="flex items-center hover:bg-surface-container-low p-2 rounded cursor-pointer transition-colors">
                                <input type="checkbox" wire:model="serviciosSeleccionados" value="{{ $servicio->id }}" class="rounded border-outline-variant text-secondary focus:ring-secondary">
                                <span class="ml-2 font-body-sm text-body-sm text-on-surface">{{ $servicio->nombre }}</span>
                                <span class="ml-auto font-label-sm text-label-sm text-on-surface-variant">${{ number_format($servicio->precio, 2) }}</span>
                            </label>
                            @endforeach
                        </div>
                        @error('serviciosSeleccionados') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                    </div>
                @endif

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

    {{-- MODAL CONFIRMAR ELIMINACIÓN --}}
    @if($mostrarModalEliminar && $eliminarDetalles)
    <div class="fixed inset-0 bg-on-surface/60 flex items-center justify-center z-[60] p-4"
         wire:click.self="cancelarEliminacion">
        <div class="bg-surface-container-lowest rounded-xl border border-error max-w-lg w-full max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="bg-error-container px-lg py-md border-b border-error rounded-t-xl flex items-center gap-md">
                <div class="w-12 h-12 rounded-full bg-error text-on-error flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[28px]">warning</span>
                </div>
                <div>
                    <h3 class="font-headline-md text-headline-md text-error font-bold">Eliminar {{ $eliminarDetalles['rol'] }} permanentemente</h3>
                    <p class="font-body-sm text-body-sm text-on-error-container">Esta acción no se puede deshacer</p>
                </div>
            </div>

            <div class="p-lg space-y-md">
                <div class="bg-surface-container-low rounded-lg p-md border border-outline-variant">
                    <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-xs">Usuario</p>
                    <p class="font-body-md text-body-md text-on-surface font-semibold">{{ $eliminarDetalles['nombre'] }}</p>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">{{ $eliminarDetalles['email'] }}</p>
                </div>

                <div class="bg-error-container/60 border border-error rounded-lg p-md">
                    <p class="font-label-md text-label-md text-error font-bold mb-sm">⚠️ Se eliminarán TODOS los registros asociados:</p>
                    <ul class="space-y-1 font-body-sm text-body-sm text-on-surface">
                        @if($eliminarDetalles['citas'] > 0)
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-error text-[18px]">cancel</span>
                                <span><strong>{{ $eliminarDetalles['citas'] }}</strong> cita(s) asignada(s) al usuario</span>
                            </li>
                        @endif
                        @if($eliminarDetalles['citas_cobradas'] > 0)
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-error text-[18px]">payments</span>
                                <span><strong>{{ $eliminarDetalles['citas_cobradas'] }}</strong> cita(s) donde fue cobrador (se desvinculará)</span>
                            </li>
                        @endif
                        @if($eliminarDetalles['comisiones'] > 0)
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-error text-[18px]">attach_money</span>
                                <span><strong>{{ $eliminarDetalles['comisiones'] }}</strong> comisión(es) registrada(s)</span>
                            </li>
                        @endif
                        @if($eliminarDetalles['auditorias'] > 0)
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-error text-[18px]">history</span>
                                <span><strong>{{ $eliminarDetalles['auditorias'] }}</strong> registro(s) de auditoría</span>
                            </li>
                        @endif
                        @if($eliminarDetalles['redenciones'] > 0)
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-error text-[18px]">redeem</span>
                                <span><strong>{{ $eliminarDetalles['redenciones'] }}</strong> redención(es) de promociones</span>
                            </li>
                        @endif
                        @if($eliminarDetalles['horario'] > 0)
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-error text-[18px]">schedule</span>
                                <span>Horario semanal configurado</span>
                            </li>
                        @endif
                        @if($eliminarDetalles['servicios'] > 0)
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-error text-[18px]">link_off</span>
                                <span>Asignación de <strong>{{ $eliminarDetalles['servicios'] }}</strong> servicio(s)</span>
                            </li>
                        @endif
                        @if($eliminarDetalles['tiene_foto'])
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-error text-[18px]">image</span>
                                <span>Foto de perfil</span>
                            </li>
                        @endif
                        <li class="flex items-start gap-2">
                            <span class="material-symbols-outlined text-error text-[18px]">person_remove</span>
                            <span>La cuenta del usuario</span>
                        </li>
                    </ul>
                </div>

                <p class="font-body-sm text-body-sm text-on-surface-variant text-center italic">
                    Si necesitas conservar el historial, usa <strong>Desactivar</strong> en su lugar.
                </p>
            </div>

            <div class="px-lg py-md border-t border-outline-variant flex justify-end gap-sm">
                <button type="button" wire:click="cancelarEliminacion"
                        class="px-lg py-sm rounded-lg border border-outline-variant text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high transition-colors">
                    Cancelar
                </button>
                <button type="button" wire:click="ejecutarEliminacion"
                        class="px-lg py-sm rounded-lg bg-error text-on-error font-label-md text-label-md hover:opacity-90 transition-opacity flex items-center gap-2"
                        wire:loading.attr="disabled" wire:target="ejecutarEliminacion">
                    <span wire:loading.remove wire:target="ejecutarEliminacion" class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">delete_forever</span>
                        Sí, eliminar todo
                    </span>
                    <span wire:loading wire:target="ejecutarEliminacion" class="flex items-center gap-2">
                        <span class="material-symbols-outlined animate-spin text-[18px]">progress_activity</span>
                        Eliminando...
                    </span>
                </button>
            </div>
        </div>
    </div>
    @endif
</div>