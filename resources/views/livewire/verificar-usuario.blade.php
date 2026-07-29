<!-- resources/views/livewire/admin/admin-flow.blade.php -->
<div>
    @if (Auth::guard('web')->check() && Auth::guard('web')->user()->empresa_id === $empresa->id)
        <livewire:dashboard :empresa="$empresa" :key="$empresa->id" />
    @else
    <div>
        {{-- LOGIN --}}
        <div class="min-h-screen flex items-center justify-center bg-gray-100">
            <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
                <h2 class="text-2xl font-bold mb-2 text-center">{{ $empresa->nombre }}</h2>
                <p class="text-gray-500 text-center mb-6">Acceso administrativo</p>

                @if ($error)
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                        {{ $error }}
                    </div>
                @endif

                <form wire:submit="login">
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Correo</label>
                        <input type="email" wire:model="email"
                            class="w-full border rounded px-3 py-2">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Contraseña</label>
                        <input type="password" wire:model="password"
                            class="w-full border rounded px-3 py-2">
                        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4 flex items-center">
                        <input type="checkbox" wire:model="remember" id="remember" class="mr-2">
                        <label for="remember" class="text-sm">Recordarme</label>
                    </div>

                    <button type="submit"
                            class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700"
                            wire:loading.attr="disabled">
                        <span wire:loading.remove>Entrar</span>
                        <span wire:loading>Entrando...</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>