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

    <div class="flex justify-between items-end mb-lg">
        <div>
            <nav class="flex items-center gap-xs text-on-surface-variant font-label-sm mb-xs">
                <span class="hover:text-primary">Dashboard</span>
                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                <span class="text-primary font-bold">Empresas</span>
            </nav>
            <h3 class="font-headline-lg text-headline-lg text-on-surface">Listado Maestro</h3>
            <p class="text-on-surface-variant font-body-md mt-xs">Administra los parámetros de facturación y contacto de tus empresas aliadas.</p>
        </div>
        <div class="flex gap-md">
            <button type="button"
                    wire:click="abrirCrearEmpresa"
                    class="flex items-center gap-sm px-lg py-sm bg-primary text-on-primary rounded font-label-md hover:opacity-90 transition-all shadow-sm">
                <span class="material-symbols-outlined">add</span>
                Nueva Empresa
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-lg mb-xl">
        <div class="bg-surface-container-lowest p-md border border-outline-variant rounded shadow-sm">
            <div class="flex justify-between items-start mb-sm">
                <div class="p-xs bg-primary/10 rounded">
                    <span class="material-symbols-outlined text-primary">store</span>
                </div>
            </div>
            <p class="text-on-surface-variant font-label-sm">Negocios Totales</p>
            <p class="text-headline-md font-bold text-on-surface">{{ $stats['totalEmpresas'] }}</p>
        </div>
        <div class="bg-surface-container-lowest p-md border border-outline-variant rounded shadow-sm">
            <div class="flex justify-between items-start mb-sm">
                <div class="p-xs bg-secondary-container rounded">
                    <span class="material-symbols-outlined text-secondary">task_alt</span>
                </div>
            </div>
            <p class="text-on-surface-variant font-label-sm">Activos</p>
            <p class="text-headline-md font-bold text-on-surface">{{ $stats['empresasActivas'] }}</p>
        </div>
        <div class="bg-surface-container-lowest p-md border border-outline-variant rounded shadow-sm">
            <div class="flex justify-between items-start mb-sm">
                <div class="p-xs bg-surface-container rounded">
                    <span class="material-symbols-outlined text-on-surface-variant">pending</span>
                </div>
            </div>
            <p class="text-on-surface-variant font-label-sm">En Prueba</p>
            <p class="text-headline-md font-bold text-on-surface">{{ $stats['empresasPrueba'] }}</p>
        </div>
        <div class="bg-surface-container-lowest p-md border border-outline-variant rounded shadow-sm">
            <div class="flex justify-between items-start mb-sm">
                <div class="p-xs bg-error-container rounded">
                    <span class="material-symbols-outlined text-error">block</span>
                </div>
            </div>
            <p class="text-on-surface-variant font-label-sm">Suspendidas</p>
            <p class="text-headline-md font-bold text-on-surface">{{ $stats['empresasSuspendidas'] }}</p>
        </div>
        <div class="bg-surface-container-lowest p-md border border-outline-variant rounded shadow-sm">
            <div class="flex justify-between items-start mb-sm">
                <div class="p-xs bg-primary/10 rounded">
                    <span class="material-symbols-outlined text-primary">payments</span>
                </div>
            </div>
            <p class="text-on-surface-variant font-label-sm">Cobros Mes</p>
            <p class="text-headline-md font-bold text-on-surface">${{ number_format($stats['cobroMes'] ?? 0, 2) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-lg mb-xl">
        <div class="bg-surface-container-lowest p-md border border-outline-variant rounded shadow-sm">
            <p class="text-on-surface-variant font-label-sm">Empresas Inactivas</p>
            <p class="text-headline-md font-bold text-on-surface">{{ $stats['empresasInactivas'] ?? 0 }}</p>
        </div>
        <div class="bg-surface-container-lowest p-md border border-outline-variant rounded shadow-sm">
            <p class="text-on-surface-variant font-label-sm mb-sm">Empresas por Plan</p>
            <div class="flex gap-lg">
                @foreach(['basico' => 'Básico', 'pro' => 'Pro', 'empresa' => 'Empresa'] as $plan => $label)
                    <div>
                        <p class="font-label-sm text-on-surface-variant">{{ $label }}</p>
                        <p class="font-headline-md text-headline-md font-bold text-on-surface">{{ $stats['empresasPorPlan'][$plan] ?? 0 }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-surface-container-lowest p-lg border border-outline-variant rounded-xl shadow-sm mb-xl">
        <h3 class="font-headline-md text-headline-md text-on-surface mb-lg">Crecimiento de Empresas (Últimos 6 meses)</h3>
        <div class="flex items-end gap-md h-48">
            @foreach($stats['crecimientoMensual'] as $index => $cantidad)
                <div class="flex-1 flex flex-col items-center">
                    <div class="w-full bg-surface-container rounded-t relative"
                         style="height: {{ $stats['totalEmpresas'] > 0 ? ($cantidad / $stats['totalEmpresas'] * 100) + 20 : 20 }}px">
                        <div class="w-full bg-primary rounded-t absolute bottom-0"
                             style="height: {{ $stats['totalEmpresas'] > 0 ? $cantidad / $stats['totalEmpresas'] * 100 : 0 }}%">
                            <span class="absolute -top-5 left-1/2 transform -translate-x-1/2 font-label-sm text-label-sm font-bold text-primary">
                                {{ $cantidad }}
                            </span>
                        </div>
                    </div>
                    <span class="font-label-sm text-label-sm text-on-surface-variant mt-xs">{{ $stats['labelsCrecimiento'][$index] ?? '' }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant overflow-hidden shadow-sm">
        <div class="px-lg py-md border-b border-outline-variant flex justify-between items-center bg-surface-container-low/30">
            <h3 class="font-headline-md text-headline-md text-on-surface">Listado de Empresas</h3>
            <span class="font-body-sm text-on-surface-variant">Total: {{ $empresas->total() }}</span>
        </div>

        <div class="p-lg border-b border-outline-variant bg-surface-container-low/20">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-md">
                <div>
                    <label class="font-label-sm text-label-sm text-on-surface-variant mb-xs block">Buscar</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">search</span>
                        <input type="text"
                               wire:model.live.debounce.300ms="filtroBuscar"
                               placeholder="Nombre, email o slug..."
                               class="w-full h-10 pl-10 pr-md bg-surface-container-lowest border border-outline-variant rounded-lg font-body-sm text-on-surface focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                    </div>
                </div>
                <div>
                    <label class="font-label-sm text-label-sm text-on-surface-variant mb-xs block">Plan</label>
                    <select wire:model.live="filtroPlan"
                            class="w-full h-10 px-md bg-surface-container-lowest border border-outline-variant rounded-lg font-body-sm text-on-surface">
                        <option value="">Todos</option>
                        @foreach($planes as $plan)
                            <option value="{{ $plan }}">{{ ucfirst($plan) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="font-label-sm text-label-sm text-on-surface-variant mb-xs block">Estatus</label>
                    <select wire:model.live="filtroEstatus"
                            class="w-full h-10 px-md bg-surface-container-lowest border border-outline-variant rounded-lg font-body-sm text-on-surface">
                        <option value="">Todos</option>
                        @foreach($estatuses as $estatus)
                            <option value="{{ $estatus }}">{{ ucfirst($estatus) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="button"
                            wire:click="limpiarFiltros"
                            class="w-full h-10 flex items-center justify-center gap-sm px-md border border-outline-variant rounded-lg font-label-md text-on-surface-variant hover:bg-surface-container transition-colors">
                        <span class="material-symbols-outlined text-[18px]">filter_alt_off</span>
                        Limpiar filtros
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low border-b border-outline-variant">
                        <th class="px-lg py-md font-label-sm text-on-surface-variant uppercase tracking-wider">Empresa</th>
                        <th class="px-lg py-md font-label-sm text-on-surface-variant uppercase tracking-wider">Contacto</th>
                        <th class="px-lg py-md font-label-sm text-on-surface-variant uppercase tracking-wider">Plan</th>
                        <th class="px-lg py-md font-label-sm text-on-surface-variant uppercase tracking-wider text-center">Estatus</th>
                        <th class="px-lg py-md font-label-sm text-on-surface-variant uppercase tracking-wider">Vencimiento</th>
                        <th class="px-lg py-md font-label-sm text-on-surface-variant uppercase tracking-wider text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($empresas as $empresa)
                    <tr class="hover:bg-surface-container/50 transition-colors group">
                        <td class="px-lg py-md">
                            <div class="flex items-center gap-md">
                                @if($empresa->logo_src)
                                    <div class="w-10 h-10 rounded-full overflow-hidden border border-outline-variant flex-shrink-0 bg-white">
                                        <img src="{{ $empresa->logo_src }}" alt="{{ $empresa->nombre }}"
                                             class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center flex-shrink-0">
                                        <span class="text-on-primary font-label-md">{{ substr($empresa->nombre, 0, 2) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-label-md text-on-surface group-hover:text-primary transition-colors">{{ $empresa->nombre }}</p>
                                    <p class="font-body-sm text-on-surface-variant">{{ $empresa->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-lg py-md">
                            <p class="font-body-md text-on-surface">{{ $empresa->email_contacto }}</p>
                            <p class="font-body-sm text-on-surface-variant">{{ $empresa->telefono ?? 'Sin teléfono' }}</p>
                        </td>
                        <td class="px-lg py-md">
                            <span class="px-sm py-1 rounded-full font-label-sm
                                @if($empresa->plan == 'basico') bg-surface-container text-on-surface-variant
                                @elseif($empresa->plan == 'pro') bg-primary/10 text-primary
                                @else bg-secondary-container text-on-secondary-container @endif">
                                {{ ucfirst($empresa->plan) }}
                            </span>
                        </td>
                        <td class="px-lg py-md text-center">
                            <select wire:change="cambiarEstatus({{ $empresa->id }}, $event.target.value)"
                                    class="font-label-sm rounded-full px-sm py-1 border-0 cursor-pointer focus:ring-2 focus:ring-primary/20
                                        @if($empresa->estatus == 'activo') bg-secondary-container text-on-secondary-container
                                        @elseif($empresa->estatus == 'prueba') bg-surface-container-high text-on-surface
                                        @elseif($empresa->estatus == 'suspendido') bg-error-container text-on-error-container
                                        @else bg-surface-container text-on-surface-variant @endif">
                                @foreach($estatuses as $estatus)
                                    <option value="{{ $estatus }}" {{ $empresa->estatus == $estatus ? 'selected' : '' }}>
                                        {{ ucfirst($estatus) }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-lg py-md font-body-md text-on-surface">
                            {{ $empresa->fecha_vencimiento ? $empresa->fecha_vencimiento->format('d/m/Y') : 'N/A' }}
                        </td>
                        <td class="px-lg py-md text-right">
                            <div class="flex justify-end gap-sm">
                                <button type="button"
                                        wire:click="verDetallesEmpresa({{ $empresa->id }})"
                                        class="w-8 h-8 rounded hover:bg-primary/10 text-primary transition-all flex items-center justify-center"
                                        title="Ver detalles">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                </button>
                                <button type="button"
                                        wire:click="abrirEditarEmpresa({{ $empresa->id }})"
                                        class="w-8 h-8 rounded hover:bg-primary/10 text-primary transition-all flex items-center justify-center"
                                        title="Editar empresa">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </button>
                                <button type="button"
                                        wire:click="eliminarEmpresa({{ $empresa->id }})"
                                        class="w-8 h-8 rounded hover:bg-error-container text-error transition-all flex items-center justify-center"
                                        title="Eliminar empresa">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-lg py-xl text-center">
                            <span class="material-symbols-outlined text-[48px] text-outline mb-md block">storefront</span>
                            <p class="font-body-md text-on-surface-variant">No hay empresas registradas</p>
                            <p class="font-body-sm text-on-surface-variant mt-xs">Haz clic en "Nueva Empresa" para crear una</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-lg py-md bg-surface-container-lowest border-t border-outline-variant">
            {{ $empresas->links() }}
        </div>
    </div>

    {{-- MODAL DE CONFIRMACIÓN DE ELIMINACIÓN --}}
    @if($mostrarModalEliminar && $eliminarDetalles)
    <div class="fixed inset-0 bg-on-surface/60 flex items-center justify-center z-[60] p-4"
         wire:click.self="cancelarEliminacion">
        <div class="bg-surface-container-lowest rounded-xl border border-error max-w-lg w-full max-h-[90vh] overflow-y-auto shadow-2xl">
            {{-- Header rojo --}}
            <div class="bg-error-container px-lg py-md border-b border-error rounded-t-xl flex items-center gap-md">
                <div class="w-12 h-12 rounded-full bg-error text-on-error flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[28px]">warning</span>
                </div>
                <div>
                    <h3 class="font-headline-md text-headline-md text-error font-bold">Eliminar empresa permanentemente</h3>
                    <p class="font-body-sm text-body-sm text-on-error-container">Esta acción no se puede deshacer</p>
                </div>
            </div>

            <div class="p-lg space-y-md">
                {{-- Datos de la empresa --}}
                <div class="bg-surface-container-low rounded-lg p-md border border-outline-variant">
                    <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-xs">Empresa</p>
                    <p class="font-body-md text-body-md text-on-surface font-semibold">{{ $eliminarDetalles['nombre'] }}</p>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">{{ $eliminarDetalles['slug'] }} · {{ $eliminarDetalles['email'] }}</p>
                    <div class="flex gap-sm mt-sm">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium capitalize
                            @if($eliminarDetalles['plan'] == 'basico') bg-surface-container text-on-surface-variant
                            @elseif($eliminarDetalles['plan'] == 'pro') bg-primary/10 text-primary
                            @else bg-secondary-container text-on-secondary-container @endif">
                            Plan: {{ $eliminarDetalles['plan'] }}
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium capitalize
                            @if($eliminarDetalles['estatus'] == 'activo') bg-secondary-container text-on-secondary-container
                            @elseif($eliminarDetalles['estatus'] == 'prueba') bg-surface-container-high text-on-surface
                            @elseif($eliminarDetalles['estatus'] == 'suspendido') bg-error-container text-on-error-container
                            @else bg-surface-container text-on-surface-variant @endif">
                            {{ $eliminarDetalles['estatus'] }}
                        </span>
                    </div>
                </div>

                {{-- Advertencia con desglose --}}
                <div class="bg-error-container/60 border border-error rounded-lg p-md">
                    <p class="font-label-md text-label-md text-error font-bold mb-sm">⚠️ Se eliminarán TODOS los registros asociados:</p>
                    <ul class="space-y-1 font-body-sm text-body-sm text-on-surface">
                        @if($eliminarDetalles['users'] > 0)
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-error text-[18px]">group</span>
                                <span><strong>{{ $eliminarDetalles['users'] }}</strong> usuario(s) (admins, recepcionistas, colaboradores)</span>
                            </li>
                        @endif
                        @if($eliminarDetalles['clientes'] > 0)
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-error text-[18px]">person</span>
                                <span><strong>{{ $eliminarDetalles['clientes'] }}</strong> cliente(s)</span>
                            </li>
                        @endif
                        @if($eliminarDetalles['servicios'] > 0)
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-error text-[18px]">content_cut</span>
                                <span><strong>{{ $eliminarDetalles['servicios'] }}</strong> servicio(s) (y sus imágenes)</span>
                            </li>
                        @endif
                        @if($eliminarDetalles['citas'] > 0)
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-error text-[18px]">event</span>
                                <span><strong>{{ $eliminarDetalles['citas'] }}</strong> cita(s)</span>
                            </li>
                        @endif
                        @if($eliminarDetalles['comisiones'] > 0)
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-error text-[18px]">attach_money</span>
                                <span><strong>{{ $eliminarDetalles['comisiones'] }}</strong> comisión(es)</span>
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
                        @if($eliminarDetalles['lista_espera'] > 0)
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-error text-[18px]">hourglass_empty</span>
                                <span><strong>{{ $eliminarDetalles['lista_espera'] }}</strong> registro(s) en lista de espera</span>
                            </li>
                        @endif
                        @if($eliminarDetalles['notificaciones'] > 0)
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-error text-[18px]">notifications</span>
                                <span><strong>{{ $eliminarDetalles['notificaciones'] }}</strong> notificación(es)</span>
                            </li>
                        @endif
                        @if($eliminarDetalles['promociones'] > 0)
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-error text-[18px]">local_offer</span>
                                <span><strong>{{ $eliminarDetalles['promociones'] }}</strong> promoción(es)</span>
                            </li>
                        @endif
                        @if($eliminarDetalles['pagos'] > 0)
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-error text-[18px]">receipt_long</span>
                                <span><strong>{{ $eliminarDetalles['pagos'] }}</strong> pago(s) de la empresa</span>
                            </li>
                        @endif
                        @if($eliminarDetalles['tiene_logo'])
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-error text-[18px]">image</span>
                                <span>Logo de la empresa</span>
                            </li>
                        @endif
                        <li class="flex items-start gap-2">
                            <span class="material-symbols-outlined text-error text-[18px]">storefront</span>
                            <span>La empresa en sí</span>
                        </li>
                    </ul>
                </div>

                <p class="font-body-sm text-body-sm text-on-surface-variant text-center italic">
                    Si solo quieres bloquear el acceso temporalmente, cambia el estatus a <strong>Suspendido</strong> en lugar de eliminar.
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

    @livewire(\App\Livewire\SuperAdmin\FormularioEmpresa::class)
    @livewire(\App\Livewire\SuperAdmin\DetallesEmpresa::class)
</div>