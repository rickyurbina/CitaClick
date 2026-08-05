<div>
    <div class="text-center mb-6">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-800">Regístrate como cliente</h2>
        <p class="text-sm text-gray-500 mt-1">Completa tus datos para continuar con el agendamiento</p>
    </div>

    <form wire:submit.prevent="registrar" class="space-y-4">
        <div>
            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">
                Nombre completo *
            </label>
            <input type="text" 
                   id="nombre"
                   wire:model="nombre" 
                   placeholder="Ej: Juan Pérez"
                   class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                   autofocus>
            @error('nombre') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        <div>
            <label for="telefono_registro" class="block text-sm font-medium text-gray-700 mb-1">
                Número de teléfono *
            </label>
            <input type="tel" 
                   id="telefono_registro"
                   wire:model="telefono" 
                   class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition bg-gray-50"
                   readonly>
            @error('telefono') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
            @enderror
            <p class="text-xs text-gray-400 mt-1">El teléfono no puede ser modificado</p>
        </div>

        <div>
            <label for="fechaNacimiento" class="block text-sm font-medium text-gray-700 mb-1">
                Fecha de nacimiento <span class="text-gray-400">(opcional)</span>
            </label>
            <input type="date" 
                   id="fechaNacimiento"
                   wire:model="fechaNacimiento" 
                   max="{{ date('Y-m-d') }}"
                   min="1900-01-01"
                   class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
            @error('fechaNacimiento') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        <div class="flex items-start">
            <input type="checkbox" 
                   id="aceptaTerminos"
                   wire:model="aceptaTerminos" 
                   class="mt-1 rounded border-gray-300 text-green-600 focus:ring-green-500">
            <label for="aceptaTerminos" class="ml-2 text-sm text-gray-600">
                Acepto los <a href="#" class="text-green-600 hover:underline">términos y condiciones</a> de la empresa
            </label>
        </div>
        @error('aceptaTerminos') 
            <span class="text-red-500 text-sm block">{{ $message }}</span> 
        @enderror

        <div class="flex space-x-3">
            <button type="button" 
                    wire:click="volver"
                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 rounded-lg font-medium transition">
                Volver
            </button>
            <button type="submit" 
                    class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-medium transition flex items-center justify-center"
                    wire:loading.attr="disabled"
                    wire:target="registrar">
                <span wire:loading.remove wire:target="registrar">
                    Registrarme
                </span>
                <span wire:loading wire:target="registrar" class="flex items-center">
                    <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                    </svg>
                    Registrando...
                </span>
            </button>
        </div>
    </form>
</div>