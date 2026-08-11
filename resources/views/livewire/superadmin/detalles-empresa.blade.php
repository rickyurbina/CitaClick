<div>
    @if($mostrarModal && $empresa)
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-md"
         x-data="detallesEmpresa()"
         x-init="init()"
         @click.self="cerrar()">
        <div class="bg-surface-container-lowest border border-outline-variant rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-sm">
            <div class="sticky top-0 z-10 px-xl py-lg border-b border-outline-variant bg-surface-container-low/30 rounded-t-lg flex justify-between items-center">
                <div>
                    <h3 class="font-headline-md text-headline-md text-on-surface">Detalles de la Empresa</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">Información completa y estadísticas operativas</p>
                </div>
                <button type="button"
                        wire:click="cerrarModal"
                        class="w-8 h-8 rounded flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <div class="p-xl space-y-lg">
                <div class="flex items-center gap-lg">
                    @if($empresa->logo_url)
                        <div class="w-20 h-20 rounded-xl overflow-hidden border border-outline-variant flex-shrink-0 bg-white">
                            <img src="{{ Storage::url($empresa->logo_url) }}" alt="{{ $empresa->nombre }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-20 h-20 rounded-xl bg-primary flex items-center justify-center flex-shrink-0">
                            <span class="text-on-primary font-headline-md">{{ substr($empresa->nombre, 0, 2) }}</span>
                        </div>
                    @endif
                    <div>
                        <h2 class="font-headline-md text-headline-md text-on-surface">{{ $empresa->nombre }}</h2>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">{{ $empresa->slug }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                    <div class="bg-surface-container-low p-md rounded-lg border border-outline-variant">
                        <p class="font-label-sm text-label-sm text-on-surface-variant mb-xs">Email de contacto</p>
                        <p class="font-body-md text-body-md text-on-surface">{{ $empresa->email_contacto }}</p>
                    </div>
                    <div class="bg-surface-container-low p-md rounded-lg border border-outline-variant">
                        <p class="font-label-sm text-label-sm text-on-surface-variant mb-xs">Teléfono</p>
                        <p class="font-body-md text-body-md text-on-surface">{{ $empresa->telefono ?? 'No registrado' }}</p>
                    </div>
                    <div class="bg-surface-container-low p-md rounded-lg border border-outline-variant">
                        <p class="font-label-sm text-label-sm text-on-surface-variant mb-xs">Plan</p>
                        <p class="font-body-md text-body-md text-on-surface capitalize">{{ $empresa->plan }}</p>
                    </div>
                    <div class="bg-surface-container-low p-md rounded-lg border border-outline-variant">
                        <p class="font-label-sm text-label-sm text-on-surface-variant mb-xs">Estatus</p>
                        <span class="inline-block px-sm py-1 rounded-full font-label-sm
                            @if($empresa->estatus == 'activo') bg-secondary-container text-on-secondary-container
                            @elseif($empresa->estatus == 'prueba') bg-surface-container-high text-on-surface
                            @elseif($empresa->estatus == 'suspendido') bg-error-container text-on-error-container
                            @else bg-surface-container text-on-surface-variant @endif">
                            {{ ucfirst($empresa->estatus) }}
                        </span>
                    </div>
                    <div class="bg-surface-container-low p-md rounded-lg border border-outline-variant">
                        <p class="font-label-sm text-label-sm text-on-surface-variant mb-xs">Fecha de vencimiento</p>
                        <p class="font-body-md text-body-md text-on-surface">{{ $empresa->fecha_vencimiento ? $empresa->fecha_vencimiento->format('d/m/Y') : 'N/A' }}</p>
                    </div>
                    <div class="bg-surface-container-low p-md rounded-lg border border-outline-variant">
                        <p class="font-label-sm text-label-sm text-on-surface-variant mb-xs">Fecha de registro</p>
                        <p class="font-body-md text-body-md text-on-surface">{{ $empresa->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div>
                    <h4 class="font-label-md text-label-md text-on-surface mb-md flex items-center gap-sm">
                        <span class="material-symbols-outlined text-[20px] text-primary">analytics</span>
                        Estadísticas
                    </h4>
                    <div class="grid grid-cols-3 gap-md">
                        <div class="bg-surface-container-lowest p-md rounded-lg border border-outline-variant text-center">
                            <div class="p-xs bg-primary/10 rounded inline-flex mb-sm">
                                <span class="material-symbols-outlined text-primary text-[20px]">group</span>
                            </div>
                            <p class="font-headline-md text-headline-md font-bold text-on-surface">{{ $empresa->users()->count() }}</p>
                            <p class="font-label-sm text-label-sm text-on-surface-variant">Usuarios</p>
                        </div>
                        <div class="bg-surface-container-lowest p-md rounded-lg border border-outline-variant text-center">
                            <div class="p-xs bg-secondary-container rounded inline-flex mb-sm">
                                <span class="material-symbols-outlined text-secondary text-[20px]">person</span>
                            </div>
                            <p class="font-headline-md text-headline-md font-bold text-on-surface">{{ $empresa->clientes()->count() }}</p>
                            <p class="font-label-sm text-label-sm text-on-surface-variant">Clientes</p>
                        </div>
                        <div class="bg-surface-container-lowest p-md rounded-lg border border-outline-variant text-center">
                            <div class="p-xs bg-surface-container rounded inline-flex mb-sm">
                                <span class="material-symbols-outlined text-on-surface-variant text-[20px]">event</span>
                            </div>
                            <p class="font-headline-md text-headline-md font-bold text-on-surface">{{ $empresa->citas()->count() }}</p>
                            <p class="font-label-sm text-label-sm text-on-surface-variant">Citas</p>
                        </div>
                    </div>
                </div>

                @if($empresa->config)
                <div>
                    <h4 class="font-label-md text-label-md text-on-surface mb-md flex items-center gap-sm">
                        <span class="material-symbols-outlined text-[20px] text-primary">settings</span>
                        Configuración
                    </h4>
                    <div class="bg-surface-container-low p-md rounded-lg border border-outline-variant">
                        <pre class="font-body-sm text-body-sm text-on-surface-variant whitespace-pre-wrap">{{ json_encode($empresa->config, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                </div>
                @endif
            </div>

            <div class="sticky bottom-0 bg-surface-container-lowest px-xl py-lg border-t border-outline-variant rounded-b-lg flex justify-end">
                <button type="button"
                        wire:click="cerrarModal"
                        class="px-xl py-2.5 rounded-lg border border-outline-variant text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high transition-colors active:scale-[0.98]">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
    @endif

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('detallesEmpresa', () => ({
                init() {
                    document.body.style.overflow = 'hidden';
                },
                cerrar() {
                    @this.cerrarModal();
                },
                destroy() {
                    document.body.style.overflow = 'auto';
                }
            }));
        });

        document.addEventListener('livewire:initialized', () => {
            @this.on('modal-cerrado', () => {
                document.body.style.overflow = 'auto';
            });
            @this.on('modal-abierto', () => {
                document.body.style.overflow = 'hidden';
            });
        });
    </script>
    @endpush
</div>
