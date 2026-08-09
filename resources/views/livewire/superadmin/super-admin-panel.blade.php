<div>
    @if($isAuthenticated)
        <div class="flex h-screen">
            <div class="w-64 bg-gradient-to-b from-gray-900 to-gray-800 text-white flex flex-col shadow-xl">
                <div class="p-4 border-b border-gray-700">
                    <h2 class="text-xl font-bold text-white">👑 CitaClick</h2>
                    <p class="text-sm text-gray-400">Panel SuperAdmin</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $usuarioActual->nombre ?? 'Administrador' }}</p>
                </div>

                <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                    <div class="w-full text-left px-4 py-2.5 rounded-lg bg-blue-600 text-white flex items-center space-x-3 cursor-default">
                        <span>📊</span>
                        <span>Dashboard</span>
                        <span class="ml-auto text-xs bg-white/20 px-2 py-0.5 rounded">Activo</span>
                    </div>
                </nav>

                <div class="p-4 border-t border-gray-700">
                    <button wire:click="logout" 
                            class="w-full text-left px-4 py-2 text-red-400 hover:bg-red-900/30 hover:text-red-300 rounded-lg transition flex items-center space-x-3">
                        <span>🚪</span>
                        <span>Cerrar sesión</span>
                    </button>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-6 bg-gray-100">
                <livewire:superadmin.dashboard wire:key="dashboard" />
            </div>
        </div>
    @else
        <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 to-gray-700">
            <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-600 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <span class="text-3xl">👑</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">CitaClick</h2>
                    <p class="text-gray-500 text-sm mt-1">Panel de Super Administrador</p>
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
                        <label class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                        <input type="email" 
                               wire:model.live.debounce.300ms="email"
                               class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="superadmin@citaclick.com">
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
                            <input type="checkbox" wire:model="remember" class="mr-2 rounded border-gray-300">
                            <span class="text-sm text-gray-600">Recordarme</span>
                        </label>
                    </div>

                    <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white py-2.5 rounded-lg font-medium transition flex items-center justify-center"
                            wire:loading.attr="disabled">
                        <span wire:loading.remove>Iniciar sesión</span>
                        <span wire:loading class="flex items-center">
                            <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                            </svg>
                            Verificando...
                        </span>
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                    <p class="text-xs text-gray-400">© {{ date('Y') }} CitaClick - Todos los derechos reservados</p>
                </div>
            </div>
        </div>
    @endif
</div>