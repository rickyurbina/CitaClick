<div>
    <div class="text-center mb-lg">
        <div class="w-16 h-16 bg-surface-container-low rounded-full flex items-center justify-center mx-auto mb-md border border-outline-variant/40">
            <span class="material-symbols-outlined text-secondary" style="font-size: 32px;">call</span>
        </div>
        <h2 class="font-headline-md text-headline-md text-on-surface">Verifica tu teléfono</h2>
        <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">
            Ingresa tu número de teléfono para verificar si ya eres cliente
        </p>
    </div>

    <form wire:submit.prevent="verificar" class="space-y-lg">
        <div class="space-y-xs">
            <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider" for="telefono">
                Número de Teléfono
            </label>
            <div class="focus-ring flex items-center bg-surface border border-outline-variant rounded-lg transition-all duration-200">
                <div class="px-md flex items-center gap-sm border-r border-outline-variant bg-surface-container-low rounded-l-lg h-12">
                    <span class="material-symbols-outlined text-on-surface-variant" style="font-size: 20px;">call</span>
                    <span class="font-label-md text-label-md text-on-surface">+52</span>
                </div>
                <input type="tel"
                       id="telefono"
                       wire:model="telefono"
                       placeholder="55 1234 5678"
                       class="w-full h-12 px-md bg-transparent border-none focus:ring-0 font-body-md text-body-md text-on-surface placeholder:text-outline"
                       autofocus
                       autocomplete="tel"
                       maxlength="20">
            </div>
            @error('telefono')
                <span class="font-body-sm text-body-sm text-error mt-xs block">{{ $message }}</span>
            @enderror
            <p class="font-body-sm text-body-sm text-outline mt-xs">Ingresa el número sin espacios ni guiones</p>
        </div>

        <button type="submit"
                class="w-full h-14 bg-secondary text-on-secondary font-label-md text-label-md rounded-lg shadow-md hover:bg-[#005a3d] active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-sm disabled:opacity-60"
                wire:loading.attr="disabled"
                wire:target="verificar">
            <span wire:loading.remove wire:target="verificar" class="flex items-center gap-sm">
                Continuar
                <span class="material-symbols-outlined" style="font-size: 20px;">arrow_forward</span>
            </span>
            <span wire:loading wire:target="verificar" class="flex items-center gap-sm">
                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Verificando...
            </span>
        </button>
    </form>
</div>
