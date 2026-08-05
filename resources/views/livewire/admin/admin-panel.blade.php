<div class="min-h-screen bg-gray-100">
    @if($isAuthenticated)
        <div class="flex h-screen">
            <div class="w-64 bg-white shadow-lg flex flex-col">
                <div class="p-4 border-b">
                    <h2 class="text-xl font-bold text-gray-800">{{ $empresa->nombre }}</h2>
                    <p class="text-sm text-gray-500">Bienvenido, {{ $usuarioActual->nombre }}</p>
                    <span class="inline-block px-2 py-1 text-xs rounded-full mt-1 
                        @if($esAdmin) bg-blue-100 text-blue-800
                        @elseif($esRecepcionista) bg-green-100 text-green-800
                        @else bg-purple-100 text-purple-800 @endif">
                        {{ ucfirst($usuarioActual->rol) }}
                    </span>
                </div>

                <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                    <button wire:click="cambiarSeccion('dashboard')" 
                            class="w-full text-left px-4 py-2.5 rounded-lg transition flex items-center space-x-3
                                {{ $seccionActiva === 'dashboard' ? 'bg-blue-600 text-white' : 'hover:bg-gray-100' }}">
                        <span>📊</span>
                        <span>Dashboard</span>
                    </button>

                    @if($puedeGestionarCitas)
                    <button wire:click="cambiarSeccion('citas')" 
                            class="w-full text-left px-4 py-2.5 rounded-lg transition flex items-center space-x-3
                                {{ $seccionActiva === 'citas' ? 'bg-blue-600 text-white' : 'hover:bg-gray-100' }}">
                        <span>📅</span>
                        <span>Gestión de Citas</span>
                    </button>
                    @endif

                    @if($esAdmin)
                    <div class="pt-4 mt-4 border-t border-gray-200">
                        <p class="text-xs text-gray-400 uppercase font-semibold px-4 mb-2">Administración</p>
                        
                        <button wire:click="cambiarSeccion('clientes')" 
                                class="w-full text-left px-4 py-2 rounded-lg transition flex items-center space-x-3 hover:bg-gray-100
                                    {{ $seccionActiva === 'clientes' ? 'bg-blue-600 text-white' : '' }}">
                            <span>👥</span>
                            <span>Clientes</span>
                        </button>

                        <button wire:click="cambiarSeccion('colaboradores')" 
                                class="w-full text-left px-4 py-2 rounded-lg transition flex items-center space-x-3 hover:bg-gray-100
                                    {{ $seccionActiva === 'colaboradores' ? 'bg-blue-600 text-white' : '' }}">
                            <span>👤</span>
                            <span>Colaboradores</span>
                        </button>

                        <button wire:click="cambiarSeccion('servicios')" 
                                class="w-full text-left px-4 py-2 rounded-lg transition flex items-center space-x-3 hover:bg-gray-100
                                    {{ $seccionActiva === 'servicios' ? 'bg-blue-600 text-white' : '' }}">
                            <span>💇</span>
                            <span>Servicios</span>
                        </button>

                        <button wire:click="cambiarSeccion('comisiones')" 
                                class="w-full text-left px-4 py-2 rounded-lg transition flex items-center space-x-3 hover:bg-gray-100
                                    {{ $seccionActiva === 'comisiones' ? 'bg-blue-600 text-white' : '' }}">
                            <span>💰</span>
                            <span>Comisiones</span>
                        </button>
                    </div>
                    @endif
                </nav>

                <div class="p-4 border-t">
                    <button wire:click="logout" 
                            class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg transition flex items-center space-x-3">
                        <span>🚪</span>
                        <span>Cerrar sesión</span>
                    </button>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-6">
                @if($seccionActiva === 'dashboard')
                    <livewire:admin.dashboard :empresa="$empresa" wire:key="dashboard-{{ $empresa->id }}" />
                @elseif($seccionActiva === 'citas')
                    <livewire:admin.gestion-citas :empresa="$empresa" wire:key="citas-{{ $empresa->id }}" />
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-500">Sección en construcción...</p>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100">
            <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
                <div class="text-center mb-8">
                    @if($empresa->logo_url)
                        <img src="{{ $empresa->logo_url }}" 
                             alt="{{ $empresa->nombre }}" 
                             class="h-16 mx-auto mb-4 object-contain">
                    @endif
                    <h2 class="text-2xl font-bold text-gray-800">{{ $empresa->nombre }}</h2>
                    <p class="text-gray-500 text-sm mt-1">Acceso administrativo</p>
                </div>

                @if($error)
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-md mb-4">
                        {{ $error }}
                    </div>
                @endif

                @if($info)
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-md mb-4">
                        {{ $info }}
                    </div>
                @endif

                <form wire:submit="login" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Correo</label>
                        <input type="email" 
                               wire:model.live.debounce.300ms="email"
                               class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="trabajador@empresa.com">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                        <input type="password" 
                               wire:model.live.debounce.300ms="password"
                               class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="••••••••">
                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="remember" class="mr-2">
                            <span class="text-sm text-gray-600">Recordarme</span>
                        </label>
                    </div>

                    <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg font-medium transition"
                            wire:loading.attr="disabled">
                        <span wire:loading.remove>Iniciar sesión</span>
                        <span wire:loading>Verificando...</span>
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                    <p class="text-xs text-gray-400">© {{ date('Y') }} {{ $empresa->nombre }}</p>
                </div>
            </div>
        </div>
    @endif
</div>