<div>
    @if($mostrarModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" 
         x-data="formularioEmpresa()" 
         x-init="init()"
         @click.self="cerrar()">
        <div class="bg-white rounded-xl max-w-lg w-full max-h-[90vh] overflow-y-auto shadow-2xl transform transition-all duration-300 scale-100">
            <div class="sticky top-0 bg-white z-10 px-6 py-4 border-b border-gray-200 rounded-t-xl flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <span class="mr-2">{{ $modo === 'editar' ? '✏️' : '🏢' }}</span>
                    {{ $modo === 'editar' ? 'Editar Empresa' : 'Nueva Empresa' }}
                </h3>
                <button type="button" wire:click="cerrarModal" 
                        class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="guardar" enctype="multipart/form-data" class="p-6 space-y-4">
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">
                        Nombre de la empresa *
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <input type="text" 
                               id="nombre"
                               wire:model="nombre" 
                               class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               placeholder="Ej: Beauty Salon S.A."
                               autofocus>
                    </div>
                    @error('nombre') 
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                    @enderror
                </div>

                <div>
                    <label for="emailContacto" class="block text-sm font-medium text-gray-700 mb-1">
                        Email de contacto *
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input type="email" 
                               id="emailContacto"
                               wire:model="emailContacto" 
                               class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               placeholder="contacto@empresa.com">
                    </div>
                    @error('emailContacto') 
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                    @enderror
                </div>

                <div>
                    <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">
                        Teléfono
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <input type="tel" 
                               id="telefono"
                               wire:model="telefono" 
                               class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               placeholder="5512345678">
                    </div>
                    @error('telefono') 
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Logo de la empresa
                    </label>
                    
                    @if($logoExistente && $modo === 'editar' && !$logoFile)
                        <div class="mb-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img src="{{ Storage::url($logoExistente) }}" 
                                         alt="Logo actual" 
                                         class="h-12 w-12 object-contain rounded border border-gray-200">
                                    <span class="ml-3 text-sm text-gray-600">Logo actual</span>
                                </div>
                                <button type="button" 
                                        wire:click="$set('logoExistente', null)"
                                        class="text-sm text-red-600 hover:text-red-800">
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    @endif

                    <div class="relative">
                        <div class="flex items-center justify-center w-full">
                            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="mb-1 text-sm text-gray-500">
                                        <span class="font-semibold">Haz clic para subir</span> o arrastra y suelta
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        PNG, JPG, SVG, WEBP (Máx. 2MB)
                                    </p>
                                </div>
                                <input type="file" 
                                       wire:model="logoFile" 
                                       accept="image/*"
                                       class="hidden">
                            </label>
                        </div>
                    </div>

                    @if($logoFile)
                        <div class="mt-3 p-3 bg-green-50 rounded-lg border border-green-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img src="{{ $logoFile->temporaryUrl() }}" 
                                         alt="Vista previa" 
                                         class="h-12 w-12 object-contain rounded border border-gray-200">
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-700">{{ $logoFile->getClientOriginalName() }}</p>
                                        <p class="text-xs text-gray-500">{{ round($logoFile->getSize() / 1024) }} KB</p>
                                    </div>
                                </div>
                                <button type="button" 
                                        wire:click="$set('logoFile', null)"
                                        class="text-sm text-red-600 hover:text-red-800">
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    @endif

                    @error('logoFile') 
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                    @enderror
                    <p class="text-xs text-gray-400 mt-1">Formatos permitidos: JPG, PNG, SVG, WEBP. Tamaño máximo: 2MB</p>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="plan" class="block text-sm font-medium text-gray-700 mb-1">
                            Plan *
                        </label>
                        <select id="plan" wire:model="plan" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="basico">🟢 Básico</option>
                            <option value="pro">🔵 Pro</option>
                            <option value="empresa">🟣 Empresa</option>
                        </select>
                        @error('plan') 
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>
                    <div>
                        <label for="estatus" class="block text-sm font-medium text-gray-700 mb-1">
                            Estatus *
                        </label>
                        <select id="estatus" wire:model="estatus" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="activo">✅ Activo</option>
                            <option value="prueba">🟡 Prueba</option>
                            <option value="inactivo">⭕ Inactivo</option>
                            <option value="suspendido">🚫 Suspendido</option>
                        </select>
                        @error('estatus') 
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="fechaVencimiento" class="block text-sm font-medium text-gray-700 mb-1">
                        Fecha de vencimiento
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input type="date" 
                               id="fechaVencimiento"
                               wire:model="fechaVencimiento" 
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                               class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    @error('fechaVencimiento') 
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                    @enderror
                    <p class="text-xs text-gray-400 mt-1">Dejar en blanco si no aplica</p>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" wire:click="cerrarModal" 
                            class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition flex items-center"
                            wire:loading.attr="disabled"
                            wire:target="guardar">
                        <span wire:loading.remove wire:target="guardar">
                            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ $modo === 'editar' ? 'Actualizar' : 'Guardar' }}
                        </span>
                        <span wire:loading wire:target="guardar" class="flex items-center">
                            <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                            </svg>
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