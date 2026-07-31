<div>
    <h2 class="text-2xl font-bold mb-6 text-center">Crea tu cuenta</h2>

    <form wire:submit="registrar">
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Teléfono</label>
            <input type="tel" wire:model="telefono" maxlength="10"
                   class="w-full border rounded px-3 py-2">
            @error('telefono') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Nombre completo</label>
            <input type="text" wire:model="nombre"
                   class="w-full border rounded px-3 py-2">
            @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Fecha de nacimiento</label>
            <input type="date" wire:model="fecha_nacimiento"
                   class="w-full border rounded px-3 py-2">
            @error('fecha_nacimiento') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Correo (opcional)</label>
            <input type="email" wire:model="email"
                   class="w-full border rounded px-3 py-2">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Crear cuenta y continuar
        </button>
    </form>

    <button wire:click="volver" class="text-sm text-gray-500 mt-4 block text-center w-full">
        ← Volver
    </button>
</div>