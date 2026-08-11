<div class="relative min-h-screen flex items-center justify-center p-margin-mobile md:p-margin-desktop bg-surface">
    <div class="bg-mesh"></div>

    <div class="w-full {{ $step === 'agendar' ? 'max-w-4xl' : 'max-w-[420px]' }} animate-in fade-in slide-in-from-bottom-4 duration-700">
        {{-- Logo / Header --}}
        <div class="flex flex-col items-center mb-xl">
            @if($empresa->logo_url)
                <div class="w-[160px] h-[160px] md:w-[200px] md:h-[200px] flex items-center justify-center bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/30 p-md mb-lg">
                    <img src="{{ $empresa->logo_url }}"
                         alt="{{ $empresa->nombre }}"
                         class="w-full h-full object-contain">
                </div>
            @endif
            <h1 class="font-headline-lg-mobile text-headline-lg-mobile md:font-headline-lg md:text-headline-lg text-primary text-center">
                {{ $empresa->nombre }}
            </h1>
            <p class="font-body-md text-body-md text-on-surface-variant text-center mt-xs">
                @if($step === 'verificar')
                    Verifica tu número de teléfono para agendar tu cita
                @elseif($step === 'registro')
                    Completa tus datos para continuar
                @elseif($step === 'agendar')
                    Agenda tu cita con nosotros
                @endif
            </p>
        </div>

        {{-- Progress steps --}}
        <div class="flex items-center justify-between mb-xl px-xs">
            <div class="flex items-center flex-1">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-label-sm text-label-sm
                        {{ $step === 'verificar' ? 'bg-secondary text-on-secondary' : 'bg-secondary-container text-on-secondary-container' }}">
                        @if($step !== 'verificar')
                            <span class="material-symbols-outlined" style="font-size: 18px;">check</span>
                        @else
                            1
                        @endif
                    </div>
                    <span class="ml-sm font-label-sm text-label-sm hidden sm:inline
                        {{ $step === 'verificar' ? 'text-secondary' : 'text-on-surface-variant' }}">
                        Verificar
                    </span>
                </div>

                <div class="flex-1 h-0.5 mx-sm {{ $step === 'verificar' ? 'bg-outline-variant' : 'bg-secondary' }}"></div>

                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-label-sm text-label-sm
                        {{ $step === 'registro' ? 'bg-secondary text-on-secondary' : ($step === 'agendar' ? 'bg-secondary-container text-on-secondary-container' : 'bg-surface-container border border-outline-variant text-on-surface-variant') }}">
                        @if($step === 'agendar')
                            <span class="material-symbols-outlined" style="font-size: 18px;">check</span>
                        @else
                            2
                        @endif
                    </div>
                    <span class="ml-sm font-label-sm text-label-sm hidden sm:inline
                        {{ $step === 'registro' ? 'text-secondary' : ($step === 'agendar' ? 'text-on-surface-variant' : 'text-outline') }}">
                        Registro
                    </span>
                </div>

                <div class="flex-1 h-0.5 mx-sm {{ $step === 'agendar' ? 'bg-secondary' : 'bg-outline-variant' }}"></div>

                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-label-sm text-label-sm
                        {{ $step === 'agendar' ? 'bg-secondary text-on-secondary' : 'bg-surface-container border border-outline-variant text-on-surface-variant' }}">
                        3
                    </div>
                    <span class="ml-sm font-label-sm text-label-sm hidden sm:inline
                        {{ $step === 'agendar' ? 'text-secondary' : 'text-outline' }}">
                        Agendar
                    </span>
                </div>
            </div>
        </div>

        {{-- Card container --}}
        <div class="login-card bg-surface-container-lowest border border-outline-variant p-xl rounded-xl">
            {{-- Messages --}}
            @if($mensaje)
                <div class="mb-lg p-md rounded-lg border flex justify-between items-start gap-md
                    {{ $tipoMensaje === 'success' ? 'bg-secondary-container/40 border-secondary text-on-secondary-container' : '' }}
                    {{ $tipoMensaje === 'error' ? 'bg-error-container border-error text-error' : '' }}
                    {{ $tipoMensaje === 'warning' ? 'bg-surface-container-low border-outline text-on-surface' : '' }}
                    {{ $tipoMensaje === 'info' ? 'bg-surface-container-low border-outline-variant text-on-surface' : '' }}">
                    <div class="flex items-start gap-sm">
                        @if($tipoMensaje === 'success')
                            <span class="material-symbols-outlined shrink-0" style="font-size: 20px;">check_circle</span>
                        @elseif($tipoMensaje === 'error')
                            <span class="material-symbols-outlined shrink-0" style="font-size: 20px;">error</span>
                        @elseif($tipoMensaje === 'warning')
                            <span class="material-symbols-outlined shrink-0" style="font-size: 20px;">warning</span>
                        @else
                            <span class="material-symbols-outlined shrink-0" style="font-size: 20px;">info</span>
                        @endif
                        <span class="font-body-sm text-body-sm">{{ $mensaje }}</span>
                    </div>
                    <button type="button"
                            wire:click="$dispatch('limpiar-mensaje')"
                            class="text-on-surface-variant hover:text-on-surface transition-colors shrink-0"
                            aria-label="Cerrar mensaje">
                        <span class="material-symbols-outlined" style="font-size: 18px;">close</span>
                    </button>
                </div>
            @endif

            {{-- Dynamic step content --}}
            @if($step === 'verificar')
                <livewire:cliente.verificar-telefono :empresa="$empresa" :key="'verificar-'.$empresa->id" />
            @elseif($step === 'registro')
                <livewire:cliente.registro-cliente :empresa="$empresa" :telefono="$telefono" :key="'registro-'.$empresa->id" />
            @elseif($step === 'agendar')
                <livewire:cliente.agendar-cita :empresa="$empresa" :cliente-id="$clienteId" :key="'agendar-'.$empresa->id" />
            @endif
        </div>
    </div>
</div>
