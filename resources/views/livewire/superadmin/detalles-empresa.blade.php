<div>
    @if($mostrarModal && $empresa)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
         x-data="detallesEmpresa()"
         x-init="init()"
         @click.self="cerrar()">
        <div class="bg-white rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="sticky top-0 bg-white z-10 px-6 py-4 border-b border-gray-200 rounded-t-xl flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <span class="mr-2">🏢</span>
                    Detalles de la Empresa
                </h3>
                <button type="button" wire:click="cerrarModal" 
                        class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="p-6 space-y-6">
                <div class="flex items-center space-x-4">
                    @if($empresa->logo_url)
                        <img src="{{ Storage::url($empresa->logo_url) }}" alt="{{ $empresa->nombre }}" 
                             class="h-20 w-20 rounded-full object-cover border-2 border-gray-200">
                    @else
                        <div class="h-20 w-20 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                            <span class="text-white font-bold text-2xl">{{ substr($empresa->nombre, 0, 2) }}</span>
                        </div>
                    @endif
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $empresa->nombre }}</h2>
                        <p class="text-sm text-gray-500">{{ $empresa->slug }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Email de contacto</p>
                        <p class="font-medium">{{ $empresa->email_contacto }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Teléfono</p>
                        <p class="font-medium">{{ $empresa->telefono ?? 'No registrado' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Plan</p>
                        <p class="font-medium capitalize">{{ $empresa->plan }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Estatus</p>
                        <span class="px-2 py-1 text-xs rounded-full font-medium
                            @if($empresa->estatus == 'activo') bg-green-100 text-green-800
                            @elseif($empresa->estatus == 'prueba') bg-yellow-100 text-yellow-800
                            @elseif($empresa->estatus == 'suspendido') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($empresa->estatus) }}
                        </span>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Fecha de vencimiento</p>
                        <p class="font-medium">{{ $empresa->fecha_vencimiento ? $empresa->fecha_vencimiento->format('d/m/Y') : 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Fecha de registro</p>
                        <p class="font-medium">{{ $empresa->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">📊 Estadísticas</h4>
                    <div class="grid grid-cols-3 gap-3">
                        <div class="bg-blue-50 rounded-lg p-3 text-center">
                            <p class="text-2xl font-bold text-blue-600">{{ $empresa->users()->count() }}</p>
                            <p class="text-xs text-gray-500">Usuarios</p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-3 text-center">
                            <p class="text-2xl font-bold text-green-600">{{ $empresa->clientes()->count() }}</p>
                            <p class="text-xs text-gray-500">Clientes</p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-3 text-center">
                            <p class="text-2xl font-bold text-purple-600">{{ $empresa->citas()->count() }}</p>
                            <p class="text-xs text-gray-500">Citas</p>
                        </div>
                    </div>
                </div>

                @if($empresa->config)
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-2">⚙️ Configuración</h4>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <pre class="text-xs text-gray-600 whitespace-pre-wrap">{{ json_encode($empresa->config, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                </div>
                @endif
            </div>

            <div class="sticky bottom-0 bg-white px-6 py-4 border-t border-gray-200 rounded-b-xl flex justify-end">
                <button type="button" wire:click="cerrarModal" 
                        class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition">
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