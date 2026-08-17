<div>
    @if($mostrarModal)
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-md"
         x-data="formularioEmpresa()"
         x-init="init()"
         @click.self="cerrar()">
        <div class="bg-surface-container-lowest border border-outline-variant rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-sm transform transition-all duration-300">
            <div class="sticky top-0 z-10 px-xl py-lg border-b border-outline-variant bg-surface-container-low/30 rounded-t-lg flex justify-between items-start">
                <div>
                    <h3 class="font-headline-md text-headline-md text-on-surface">
                        {{ $modo === 'editar' ? 'Editar Empresa' : 'Información del Negocio' }}
                    </h3>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-xs">
                        {{ $modo === 'editar' ? 'Actualice los campos requeridos de la entidad comercial.' : 'Complete todos los campos requeridos para registrar una nueva entidad comercial en la plataforma.' }}
                    </p>
                </div>
                <button type="button"
                        wire:click="cerrarModal"
                        class="w-8 h-8 rounded flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form wire:submit.prevent="guardar" enctype="multipart/form-data" class="p-xl">
                <div class="grid grid-cols-12 gap-xl">
                    <div class="col-span-12 lg:col-span-4 flex flex-col items-center justify-start text-center border-r-0 lg:border-r border-outline-variant lg:pr-xl pb-xl lg:pb-0">
                        <div class="relative group w-full flex flex-col items-center">
                            @if($logoExistente && $modo === 'editar' && !$logoFile)
                                <div class="relative mb-md">
                                    <div class="w-32 h-32 rounded-xl bg-surface-container flex items-center justify-center border-2 border-outline-variant overflow-hidden">
                                        <img src="{{ asset('storage/' . ltrim(str_replace('\\', '/', $logoExistente), '/')) }}"
                                             alt="Logo actual"
                                             class="w-full h-full object-contain">
                                    </div>
                                    <label class="absolute -bottom-2 -right-2 bg-primary text-on-primary p-2 rounded-full shadow-lg hover:scale-105 transition-transform active:scale-95 cursor-pointer">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                        <input type="file"
                                               wire:model="logoFile"
                                               accept="image/*"
                                               class="hidden">
                                    </label>
                                </div>
                                <button type="button"
                                        wire:click="$set('logoExistente', null)"
                                        class="font-label-sm text-label-sm text-error hover:underline mb-sm">
                                    Eliminar logo
                                </button>
                            @elseif($logoFile)
                                <div class="w-32 h-32 rounded-xl bg-surface-container flex items-center justify-center border-2 border-outline-variant mb-md overflow-hidden">
                                    <img src="{{ $logoFile->temporaryUrl() }}"
                                         alt="Vista previa"
                                         class="w-full h-full object-contain">
                                </div>
                                <div class="mb-md text-center">
                                    <p class="font-label-sm text-label-sm text-on-surface">{{ $logoFile->getClientOriginalName() }}</p>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">{{ round($logoFile->getSize() / 1024) }} KB</p>
                                    <button type="button"
                                            wire:click="$set('logoFile', null)"
                                            class="font-label-sm text-label-sm text-error hover:underline mt-xs">
                                        Eliminar
                                    </button>
                                </div>
                            @else
                                <div class="relative mb-md">
                                    <label class="relative group cursor-pointer block">
                                        <div class="w-32 h-32 rounded-xl bg-surface-container flex items-center justify-center border-2 border-dashed border-outline-variant overflow-hidden transition-all group-hover:border-primary">
                                            <span class="material-symbols-outlined text-outline group-hover:text-primary text-[40px]">add_a_photo</span>
                                        </div>
                                        <span class="absolute -bottom-2 -right-2 bg-primary text-on-primary p-2 rounded-full shadow-lg hover:scale-105 transition-transform active:scale-95 pointer-events-none">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </span>
                                        <input type="file"
                                               wire:model="logoFile"
                                               accept="image/*"
                                               class="hidden">
                                    </label>
                                </div>
                            @endif

                            <h4 class="font-label-md text-label-md text-on-surface mt-md">Logo del Negocio</h4>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">Formatos aceptados: PNG, JPG, SVG, WEBP. Max: 2MB.</p>
                            @error('logoFile')
                                <span class="text-error font-label-sm text-label-sm mt-xs block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-xl w-full text-left space-y-lg">
                            <div>
                                <label for="estatus" class="block font-label-md text-label-md text-on-surface-variant mb-xs">Estado del Negocio *</label>
                                <select id="estatus"
                                        wire:model="estatus"
                                        class="w-full h-10 px-md bg-surface-container-lowest border border-outline-variant rounded-lg text-body-md appearance-none cursor-pointer">
                                    <option value="activo">Activo</option>
                                    <option value="prueba">Prueba</option>
                                    <option value="inactivo">Inactivo</option>
                                    <option value="suspendido">Suspendido</option>
                                </select>
                                @error('estatus')
                                    <span class="text-error font-label-sm text-label-sm mt-xs block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="p-md rounded-lg bg-surface-container-low border border-outline-variant/50">
                                <div class="flex items-center gap-sm mb-xs">
                                    <span class="material-symbols-outlined text-primary text-[20px]">info</span>
                                    <span class="font-label-sm text-label-sm text-primary uppercase tracking-tight">Nota de Auditoría</span>
                                </div>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">El cambio de estado a "Inactivo" o "Suspendido" restringirá el acceso a los módulos operativos de forma inmediata.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 lg:col-span-8 grid grid-cols-1 md:grid-cols-2 gap-lg">
                        <div class="col-span-1 md:col-span-2">
                            <label for="nombre" class="block font-label-md text-label-md text-on-surface-variant mb-xs">
                                Nombre del Negocio <span class="text-error">*</span>
                            </label>
                            <input type="text"
                                   id="nombre"
                                   wire:model="nombre"
                                   class="w-full h-10 px-md bg-white border border-outline-variant rounded-lg text-body-md text-on-surface focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
                                   placeholder="Ej. Soluciones Corporativas S.A."
                                   autofocus>
                            @error('nombre')
                                <span class="text-error font-label-sm text-label-sm mt-xs block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label for="emailContacto" class="block font-label-md text-label-md text-on-surface-variant mb-xs">
                                Email de contacto <span class="text-error">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[18px]">mail</span>
                                <input type="email"
                                       id="emailContacto"
                                       wire:model="emailContacto"
                                       class="w-full h-10 pl-10 pr-md bg-white border border-outline-variant rounded-lg text-body-md text-on-surface focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
                                       placeholder="contacto@empresa.com">
                            </div>
                            @error('emailContacto')
                                <span class="text-error font-label-sm text-label-sm mt-xs block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="telefono" class="block font-label-md text-label-md text-on-surface-variant mb-xs">Teléfono de Oficina</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[18px]">call</span>
                                <input type="tel"
                                       id="telefono"
                                       wire:model="telefono"
                                       class="w-full h-10 pl-10 pr-md bg-white border border-outline-variant rounded-lg text-body-md text-on-surface focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
                                       placeholder="+52 (55) 0000-0000">
                            </div>
                            @error('telefono')
                                <span class="text-error font-label-sm text-label-sm mt-xs block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="plan" class="block font-label-md text-label-md text-on-surface-variant mb-xs">Plan *</label>
                            <select id="plan"
                                    wire:model="plan"
                                    class="w-full h-10 px-md bg-white border border-outline-variant rounded-lg text-body-md appearance-none cursor-pointer">
                                <option value="basico">Básico</option>
                                <option value="pro">Pro</option>
                                <option value="empresa">Empresa</option>
                            </select>
                            @error('plan')
                                <span class="text-error font-label-sm text-label-sm mt-xs block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label for="fechaVencimiento" class="block font-label-md text-label-md text-on-surface-variant mb-xs">Fecha de vencimiento</label>
                            <div class="relative max-w-md">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[18px]">calendar_today</span>
                                <input type="date"
                                       id="fechaVencimiento"
                                       wire:model="fechaVencimiento"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       class="w-full h-10 pl-10 pr-md bg-white border border-outline-variant rounded-lg text-body-md text-on-surface focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                            </div>
                            @error('fechaVencimiento')
                                <span class="text-error font-label-sm text-label-sm mt-xs block">{{ $message }}</span>
                            @enderror
                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">Dejar en blanco si no aplica</p>
                        </div>
                    </div>
                </div>

                <div class="mt-xl flex items-center justify-end gap-md pt-xl border-t border-outline-variant">
                    <button type="button"
                            wire:click="cerrarModal"
                            class="px-xl py-2.5 rounded-lg border border-outline-variant text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high transition-colors active:scale-[0.98]">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-xl py-2.5 rounded-lg bg-primary text-on-primary font-label-md text-label-md shadow-sm hover:opacity-90 transition-all active:scale-[0.98] flex items-center gap-sm"
                            wire:loading.attr="disabled"
                            wire:target="guardar">
                        <span wire:loading.remove wire:target="guardar" class="flex items-center gap-sm">
                            <span class="material-symbols-outlined text-[20px]">save</span>
                            {{ $modo === 'editar' ? 'Actualizar' : 'Guardar Registro' }}
                        </span>
                        <span wire:loading wire:target="guardar" class="flex items-center gap-sm">
                            <span class="material-symbols-outlined animate-spin text-[20px]">progress_activity</span>
                            Guardando...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('formularioEmpresa', () => ({
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
