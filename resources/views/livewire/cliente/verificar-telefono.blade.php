<div>
    <div class="text-center mb-6">
        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
            </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-800">Verifica tu teléfono</h2>
        <p class="text-sm text-gray-500 mt-1">Ingresa tu número de teléfono para verificar si ya eres cliente</p>
    </div>

    <form wire:submit.prevent="verificar" class="space-y-4">
        <div>
            <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">
                Número de teléfono
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
                       placeholder="Ej: 5512345678"
                       class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                       autofocus
                       autocomplete="tel"
                       maxlength="20">
            </div>
            @error('telefono') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
            @enderror
            <p class="text-xs text-gray-400 mt-1">Ingresa el número sin espacios ni guiones</p>
        </div>

        <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition duration-200 flex items-center justify-center"
                wire:loading.attr="disabled"
                wire:target="verificar">
            <span wire:loading.remove wire:target="verificar">
                Verificar teléfono
            </span>
            <span wire:loading wire:target="verificar" class="flex items-center">
                <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                </svg>
                Verificando...
            </span>
        </button>
    </form>
</div>