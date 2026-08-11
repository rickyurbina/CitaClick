<div>
    <div class="text-center mb-lg">
        <div class="w-16 h-16 bg-secondary-container/50 rounded-full flex items-center justify-center mx-auto mb-md border border-secondary/20">
            <span class="material-symbols-outlined text-secondary" style="font-size: 32px;">person_add</span>
        </div>
        <h2 class="font-headline-md text-headline-md text-on-surface">Regístrate como cliente</h2>
        <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">
            Completa tus datos para continuar con el agendamiento
        </p>
    </div>

    <form wire:submit.prevent="registrar" class="space-y-lg">
        <div class="space-y-xs">
            <label for="nombre" class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">
                Nombre completo *
            </label>
            <div class="focus-ring flex items-center bg-surface border border-outline-variant rounded-lg transition-all duration-200">
                <div class="px-md flex items-center border-r border-outline-variant bg-surface-container-low rounded-l-lg h-12">
                    <span class="material-symbols-outlined text-on-surface-variant" style="font-size: 20px;">badge</span>
                </div>
                <input type="text"
                       id="nombre"
                       wire:model="nombre"
                       placeholder="Ej: Juan Pérez"
                       class="w-full h-12 px-md bg-transparent border-none focus:ring-0 font-body-md text-body-md text-on-surface placeholder:text-outline"
                       autofocus>
            </div>
            @error('nombre')
                <span class="font-body-sm text-body-sm text-error mt-xs block">{{ $message }}</span>
            @enderror
        </div>

        <div class="space-y-xs">
            <label for="telefono_registro" class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">
                Número de teléfono *
            </label>
            <div class="flex items-center bg-surface-container-low border border-outline-variant rounded-lg">
                <div class="px-md flex items-center gap-sm border-r border-outline-variant h-12">
                    <span class="material-symbols-outlined text-on-surface-variant" style="font-size: 20px;">call</span>
                    <span class="font-label-md text-label-md text-on-surface">+52</span>
                </div>
                <input type="tel"
                       id="telefono_registro"
                       wire:model="telefono"
                       class="w-full h-12 px-md bg-transparent border-none focus:ring-0 font-body-md text-body-md text-on-surface-variant"
                       readonly>
            </div>
            @error('telefono')
                <span class="font-body-sm text-body-sm text-error mt-xs block">{{ $message }}</span>
            @enderror
            <p class="font-body-sm text-body-sm text-outline mt-xs">El teléfono no puede ser modificado</p>
        </div>

        <div class="space-y-xs">
            <label for="fechaNacimiento" class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">
                Fecha de nacimiento <span class="normal-case tracking-normal text-outline">(opcional)</span>
            </label>
            <div class="focus-ring flex items-center bg-surface border border-outline-variant rounded-lg transition-all duration-200">
                <div class="px-md flex items-center border-r border-outline-variant bg-surface-container-low rounded-l-lg h-12">
                    <span class="material-symbols-outlined text-on-surface-variant" style="font-size: 20px;">cake</span>
                </div>
                <input type="date"
                       id="fechaNacimiento"
                       wire:model="fechaNacimiento"
                       max="{{ date('Y-m-d') }}"
                       min="1900-01-01"
                       class="w-full h-12 px-md bg-transparent border-none focus:ring-0 font-body-md text-body-md text-on-surface">
            </div>
            @error('fechaNacimiento')
                <span class="font-body-sm text-body-sm text-error mt-xs block">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex items-start gap-sm">
            <input type="checkbox"
                   id="aceptaTerminos"
                   wire:model="aceptaTerminos"
                   class="mt-1 rounded border-outline-variant text-secondary focus:ring-secondary">
            <label for="aceptaTerminos" class="font-body-sm text-body-sm text-on-surface-variant">
                Acepto los <a href="#" class="text-secondary font-label-sm hover:underline">términos y condiciones</a> de la empresa
            </label>
        </div>
        @error('aceptaTerminos')
            <span class="font-body-sm text-body-sm text-error block">{{ $message }}</span>
        @enderror

        <div class="flex gap-md pt-xs">
            <button type="button"
                    wire:click="volver"
                    class="flex-1 h-12 border border-outline-variant text-on-surface-variant font-label-md text-label-md rounded-lg hover:bg-surface-container-low active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-sm">
                <span class="material-symbols-outlined" style="font-size: 20px;">arrow_back</span>
                Volver
            </button>
            <button type="submit"
                    class="flex-1 h-12 bg-secondary text-on-secondary font-label-md text-label-md rounded-lg shadow-md hover:bg-[#005a3d] active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-sm disabled:opacity-60"
                    wire:loading.attr="disabled"
                    wire:target="registrar">
                <span wire:loading.remove wire:target="registrar" class="flex items-center gap-sm">
                    Registrarme
                    <span class="material-symbols-outlined" style="font-size: 20px;">arrow_forward</span>
                </span>
                <span wire:loading wire:target="registrar" class="flex items-center gap-sm">
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Registrando...
                </span>
            </button>
        </div>
    </form>
</div>
