<!-- resources/views/livewire/admin/dashboard.blade.php -->
<div class="flex min-h-screen bg-gray-100">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-gray-900 text-white flex flex-col">
        <div class="p-4 border-b border-gray-700">
            <h2 class="font-bold text-lg">{{ $empresa->nombre }}</h2>
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <button wire:click="cambiarSeccion('inicio')"
                    class="w-full text-left px-3 py-2 rounded {{ $seccion === 'inicio' ? 'bg-blue-600' : 'hover:bg-gray-800' }}">
                Inicio
            </button>

            <button wire:click="cambiarSeccion('ganancias')"
                    class="w-full text-left px-3 py-2 rounded {{ $seccion === 'ganancias' ? 'bg-blue-600' : 'hover:bg-gray-800' }}">
                Ganancias
            </button>

            <button wire:click="cambiarSeccion('citas')"
                    class="w-full text-left px-3 py-2 rounded {{ $seccion === 'citas' ? 'bg-blue-600' : 'hover:bg-gray-800' }}">
                Citas
            </button>

            <button wire:click="cambiarSeccion('empleados')"
                    class="w-full text-left px-3 py-2 rounded {{ $seccion === 'empleados' ? 'bg-blue-600' : 'hover:bg-gray-800' }}">
                Empleados
            </button>
        </nav>

        <div class="p-4 border-t border-gray-700">
            <button wire:click="logout" class="text-red-400 hover:text-red-300 text-sm">
                Cerrar sesión
            </button>
        </div>
    </aside>

    {{-- CONTENIDO --}}
    <main class="flex-1 p-8">
        @if ($seccion === 'inicio')
            <h1 class="text-2xl font-bold">Bienvenido, {{ Auth::guard('web')->user()->name }}</h1>
            <p class="text-gray-500 mt-2">Panel general de {{ $empresa->nombre }}</p>

        @elseif ($seccion === 'ganancias')
            <livewire:admin.ganancias :empresa="$empresa" :key="'ganancias-'.$empresa->id" />
        @endif
    </main>

</div>
