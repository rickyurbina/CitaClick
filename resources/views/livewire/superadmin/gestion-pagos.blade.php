<div>
    {{-- ==================== HEADER ==================== --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-md mb-xl">
        <div>
            <h2 class="font-headline-md text-headline-md text-on-surface">Gestión de Pagos</h2>
            <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Registra y administra los pagos de las empresas</p>
        </div>
        <button wire:click="abrirCrear" type="button"
                class="inline-flex items-center gap-sm px-lg py-3 bg-secondary text-on-secondary font-label-md text-label-md rounded-lg hover:brightness-110 active:scale-95 transition-all shadow-md">
            <span class="material-symbols-outlined">add</span>
            Nuevo Pago
        </button>
    </div>

    {{-- ==================== TARJETAS DE MÉTRICAS ==================== --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-lg mb-xl">
        <div class="p-lg bg-surface border border-outline-variant rounded-xl shadow-sm flex items-center gap-lg">
            <div class="w-12 h-12 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
                <span class="material-symbols-outlined">payments</span>
            </div>
            <div>
                <p class="text-label-sm text-on-surface-variant uppercase tracking-wider font-label-sm">Ingresos Totales</p>
                <h4 class="text-headline-md font-bold text-on-surface">${{ number_format($totalIngresos, 2) }}</h4>
            </div>
        </div>
        <div class="p-lg bg-surface border border-outline-variant rounded-xl shadow-sm flex items-center gap-lg">
            <div class="w-12 h-12 rounded-full bg-primary-container flex items-center justify-center text-on-primary-container">
                <span class="material-symbols-outlined">calendar_month</span>
            </div>
            <div>
                <p class="text-label-sm text-on-surface-variant uppercase tracking-wider font-label-sm">Ingresos del Mes</p>
                <h4 class="text-headline-md font-bold text-on-surface">${{ number_format($ingresosMes, 2) }}</h4>
            </div>
        </div>
        <div class="p-lg bg-surface border border-outline-variant rounded-xl shadow-sm flex items-center gap-lg">
            <div class="w-12 h-12 rounded-full bg-error-container flex items-center justify-center text-on-error-container">
                <span class="material-symbols-outlined">pending</span>
            </div>
            <div>
                <p class="text-label-sm text-on-surface-variant uppercase tracking-wider font-label-sm">Pagos Pendientes</p>
                <h4 class="text-headline-md font-bold text-on-surface">{{ $pagosPendientes }}</h4>
            </div>
        </div>
    </div>

    {{-- ==================== FILTROS ==================== --}}
    <div class="bg-surface border border-outline-variant rounded-xl shadow-sm p-lg mb-xl">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-md">
            <div class="flex flex-col gap-xs">
                <label class="font-label-sm text-label-sm text-on-surface-variant">Empresa</label>
                <select wire:model.live="filtroEmpresa" class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface bg-surface-container-lowest focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                    <option value="">Todas</option>
                    @foreach($empresas as $empresa)
                        <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col gap-xs">
                <label class="font-label-sm text-label-sm text-on-surface-variant">Plan</label>
                <select wire:model.live="filtroPlan" class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface bg-surface-container-lowest focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                    <option value="">Todos</option>
                    @foreach($planesList as $plan)
                        <option value="{{ $plan }}">{{ ucfirst($plan) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col gap-xs">
                <label class="font-label-sm text-label-sm text-on-surface-variant">Estatus</label>
                <select wire:model.live="filtroEstatus" class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface bg-surface-container-lowest focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                    <option value="">Todos</option>
                    <option value="pagado">Pagado</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="fallido">Fallido</option>
                </select>
            </div>
            <div class="flex flex-col gap-xs">
                <label class="font-label-sm text-label-sm text-on-surface-variant">Desde</label>
                <input type="date" wire:model.live="filtroFechaDesde" class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface bg-surface-container-lowest focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
            </div>
            <div class="flex flex-col gap-xs">
                <label class="font-label-sm text-label-sm text-on-surface-variant">Hasta</label>
                <input type="date" wire:model.live="filtroFechaHasta" class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface bg-surface-container-lowest focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
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

    {{-- ==================== TABLA / TARJETAS RESPONSIVE ==================== --}}
    <div class="bg-surface rounded-xl border border-outline-variant overflow-hidden shadow-sm">
        <div class="px-lg py-md border-b border-outline-variant">
            <div class="flex justify-between items-center">
                <span class="font-label-sm text-label-sm text-on-surface-variant">Total: {{ $pagos->total() }}</span>
            </div>
        </div>

        <!-- Vista en tabla para pantallas grandes -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low border-b border-outline-variant">
                        <th class="px-lg py-md font-label-md text-label-md text-on-surface-variant">Empresa</th>
                        <th class="px-lg py-md font-label-md text-label-md text-on-surface-variant">Plan</th>
                        <th class="px-lg py-md font-label-md text-label-md text-on-surface-variant">Monto</th>
                        <th class="px-lg py-md font-label-md text-label-md text-on-surface-variant">Fecha Pago</th>
                        <th class="px-lg py-md font-label-md text-label-md text-on-surface-variant">Vencimiento</th>
                        <th class="px-lg py-md font-label-md text-label-md text-on-surface-variant">Estatus</th>
                        <th class="px-lg py-md font-label-md text-label-md text-on-surface-variant text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($pagos as $pago)
                    <tr class="hover:bg-surface-container-low transition-colors">
                        <td class="px-lg py-4 font-body-md text-body-md text-on-surface">{{ $pago->empresa->nombre }}</td>
                        <td class="px-lg py-4 font-body-md text-body-md text-on-surface">{{ ucfirst($pago->plan) }}</td>
                        <td class="px-lg py-4 font-body-md text-body-md text-on-surface font-semibold text-secondary">${{ number_format($pago->monto, 2) }}</td>
                        <td class="px-lg py-4 font-body-md text-body-md text-on-surface">{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                        <td class="px-lg py-4 font-body-md text-body-md text-on-surface">{{ $pago->fecha_vencimiento->format('d/m/Y') }}</td>
                        <td class="px-lg py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                @if($pago->estatus == 'pagado') bg-secondary-container text-on-secondary-container
                                @elseif($pago->estatus == 'pendiente') bg-surface-container-high text-on-surface
                                @else bg-error-container text-on-error-container @endif">
                                {{ ucfirst($pago->estatus) }}
                            </span>
                        </td>
                        <td class="px-lg py-4 text-right">
                            <div class="flex justify-end gap-sm">
                                <button wire:click="abrirEditar({{ $pago->id }})" class="p-2 text-on-surface-variant hover:bg-secondary-container hover:text-on-secondary-container rounded transition-colors" title="Editar"><span class="material-symbols-outlined">edit</span></button>
                                <button wire:click="eliminar({{ $pago->id }})" onclick="confirm('¿Eliminar este pago?') || event.stopImmediatePropagation()" class="p-2 text-on-surface-variant hover:bg-error-container hover:text-error rounded transition-colors" title="Eliminar"><span class="material-symbols-outlined">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-lg py-2xl text-center text-on-surface-variant"><span class="material-symbols-outlined text-4xl text-outline mb-3 block">payments</span><p class="font-body-md text-body-md">No hay pagos registrados</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Vista en tarjetas para móviles -->
        <div class="md:hidden divide-y divide-outline-variant">
            @forelse($pagos as $pago)
            <div class="p-4 space-y-2 hover:bg-surface-container-low transition-colors">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-body-md font-semibold text-on-surface">{{ $pago->empresa->nombre }}</div>
                        <div class="font-body-sm text-body-sm text-on-surface-variant">{{ ucfirst($pago->plan) }}</div>
                    </div>
                    <span class="px-2 py-1 rounded-full text-xs font-medium
                        @if($pago->estatus == 'pagado') bg-secondary-container text-on-secondary-container
                        @elseif($pago->estatus == 'pendiente') bg-surface-container-high text-on-surface
                        @else bg-error-container text-on-error-container @endif">
                        {{ ucfirst($pago->estatus) }}
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-1 text-sm text-on-surface-variant">
                    <div><span class="font-medium">Monto:</span> <span class="text-secondary font-semibold">${{ number_format($pago->monto, 2) }}</span></div>
                    <div><span class="font-medium">Vencimiento:</span> {{ $pago->fecha_vencimiento->format('d/m/Y') }}</div>
                    <div><span class="font-medium">Fecha Pago:</span> {{ $pago->fecha_pago->format('d/m/Y') }}</div>
                    <div><span class="font-medium">Método:</span> {{ $pago->metodo_pago ?? 'N/A' }}</div>
                </div>
                <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-outline-variant/40">
                    <button wire:click="abrirEditar({{ $pago->id }})" class="px-3 py-1.5 text-xs rounded-lg bg-surface-container-high text-on-surface hover:bg-secondary-container transition-colors">Editar</button>
                    <button wire:click="eliminar({{ $pago->id }})" onclick="confirm('¿Eliminar este pago?') || event.stopImmediatePropagation()" class="px-3 py-1.5 text-xs rounded-lg bg-error-container text-error hover:bg-error-container/80 transition-colors">Eliminar</button>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-on-surface-variant">
                <span class="material-symbols-outlined text-4xl text-outline block mb-2">payments</span>
                <p class="font-body-md">No hay pagos registrados</p>
            </div>
            @endforelse
        </div>

        <div class="px-lg py-md bg-surface-container-low border-t border-outline-variant">{{ $pagos->links() }}</div>
    </div>

    {{-- ==================== MODAL FORMULARIO ==================== --}}
    @if($mostrarModal)
    <div class="fixed inset-0 bg-on-surface/40 flex items-center justify-center z-50 p-4"
         x-data="{ open: true }"
         x-init="$watch('open', value => { if (!value) @this.cerrarModal(); })"
         @click.away="open = false">
        <div class="bg-surface-container-lowest rounded-xl border border-outline-variant max-w-lg w-full max-h-[90vh] overflow-y-auto shadow-lg">
            <div class="sticky top-0 bg-surface-container-lowest z-10 px-lg py-md border-b border-outline-variant flex justify-between items-center">
                <h3 class="font-headline-md text-headline-md text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary">{{ $modo === 'editar' ? 'edit' : 'add' }}</span>
                    {{ $modo === 'editar' ? 'Editar Pago' : 'Nuevo Pago' }}
                </h3>
                <button type="button" wire:click="cerrarModal" class="p-2 text-on-surface-variant hover:bg-surface-container-high rounded-lg transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            {{-- Mostrar errores de validación --}}
            @if($errors->any())
                <div class="mx-lg mt-4 p-3 bg-error-container border border-error rounded-lg text-error text-sm">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form wire:submit.prevent="guardar" class="p-lg space-y-md">
                <div class="flex flex-col gap-xs">
                    <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Empresa *</label>
                    <select wire:model="empresaId" class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                        <option value="">Seleccionar empresa</option>
                        @foreach($empresas as $empresa)
                            <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                        @endforeach
                    </select>
                    @error('empresaId') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-xs">
                    <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Plan *</label>
                    <select wire:model="plan" class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                        <option value="basico">Básico</option>
                        <option value="pro">Pro</option>
                        <option value="empresa">Empresa</option>
                    </select>
                    @error('plan') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-xs">
                    <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Monto *</label>
                    <input type="number" step="0.01" min="0" wire:model="monto" class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                    @error('monto') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-md">
                    <div class="flex flex-col gap-xs">
                        <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Fecha Pago *</label>
                        <input type="date" wire:model="fechaPago" class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                        @error('fechaPago') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-xs">
                        <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Vencimiento *</label>
                        <input type="date" wire:model="fechaVencimiento" class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                        @error('fechaVencimiento') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex flex-col gap-xs">
                    <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Método de pago</label>
                    <select wire:model="metodoPago" class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                        <option value="">No especificado</option>
                        <option value="efectivo">Efectivo</option>
                        <option value="transferencia">Transferencia</option>
                        <option value="tarjeta">Tarjeta</option>
                        <option value="paypal">PayPal</option>
                    </select>
                    @error('metodoPago') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-xs">
                    <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Referencia</label>
                    <input type="text" wire:model="referencia" class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none" placeholder="Número de transacción, voucher...">
                    @error('referencia') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-xs">
                    <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Estatus</label>
                    <select wire:model="estatus" class="w-full border border-outline-variant rounded-lg p-2 font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none">
                        <option value="pagado">Pagado</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="fallido">Fallido</option>
                    </select>
                    @error('estatus') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end gap-sm pt-md border-t border-outline-variant">
                    <button type="button" wire:click="cerrarModal" class="px-lg py-sm rounded-lg border border-outline-variant text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high transition-colors">Cancelar</button>
                    <button type="submit" class="px-lg py-sm rounded-lg bg-secondary text-on-secondary font-label-md text-label-md hover:opacity-90 transition-opacity" wire:loading.attr="disabled">
                        <span wire:loading.remove>{{ $modo === 'editar' ? 'Actualizar' : 'Guardar' }}</span>
                        <span wire:loading>
                            <svg class="animate-spin h-5 w-5 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Guardando...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>