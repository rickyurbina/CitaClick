<div class="flex min-h-screen bg-gray-100">

    <aside class="w-64 bg-gray-900 text-white flex flex-col">
        <div class="p-4 border-b border-gray-700">
            <h2 class="font-bold text-lg">CitaClick Admin</h2>
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <button wire:click="cambiarSeccion('inicio')"
                    class="w-full text-left px-3 py-2 rounded {{ $seccion === 'inicio' ? 'bg-blue-600' : 'hover:bg-gray-800' }}">
                Inicio
            </button>

            <button wire:click="cambiarSeccion('empresas')"
                    class="w-full text-left px-3 py-2 rounded {{ $seccion === 'empresas' ? 'bg-blue-600' : 'hover:bg-gray-800' }}">
                Empresas
            </button>

            <button wire:click="cambiarSeccion('planes')"
                    class="w-full text-left px-3 py-2 rounded {{ $seccion === 'planes' ? 'bg-blue-600' : 'hover:bg-gray-800' }}">
                Planes y pagos
            </button>
        </nav>

        <div class="p-4 border-t border-gray-700">
            <button wire:click="logout" class="text-red-400 hover:text-red-300 text-sm">
                Cerrar sesión
            </button>
        </div>
    </aside>

    <main class="flex-1 p-8">
        @switch($seccion)
            @case('inicio')
                <h1 class="text-2xl font-bold">Bienvenido, {{ Auth::guard('web')->user()->name }}</h1>
                @break

            @case('empresas')
                <livewire:super-admin.empresas />
                @break

            @case('planes')
                <livewire:super-admin.planes />
                @break
        @endswitch
    </main>

</div>