<div>
    <h2 class="text-2xl font-bold mb-2 text-center">{{ $empresa->nombre }}</h2>
    <p class="text-gray-500 text-center mb-6">Ingresa tu número para agendar tu cita</p>

    <form wire:submit="verificar">
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Número de teléfono</label>
            <input type="tel" wire:model="telefono" maxlength="10"
                   class="w-full border rounded px-3 py-2">
            @error('telefono') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700"
                wire:loading.attr="disabled">
            <span wire:loading.remove>Continuar</span>
            <span wire:loading>Verificando...</span>
        </button>
    </form>
</div>