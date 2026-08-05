<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-gray-100 p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl transition-all duration-300">
        <div class="p-6 md:p-8">
            <!-- Logo / Header -->
            <div class="text-center mb-6">
                @if($empresa->logo_url)
                    <img src="{{ $empresa->logo_url }}" 
                         alt="{{ $empresa->nombre }}" 
                         class="h-16 mx-auto mb-3 object-contain">
                @endif
                <h1 class="text-2xl font-bold text-gray-800">{{ $empresa->nombre }}</h1>
                <p class="text-sm text-gray-500 mt-1">
                    @if($step === 'verificar')
                        Verifica tu número de teléfono para agendar tu cita
                    @elseif($step === 'registro')
                        Completa tus datos para continuar
                    @elseif($step === 'agendar')
                        Agenda tu cita con nosotros
                    @endif
                </p>
            </div>

            <!-- Barra de progreso -->
            <div class="flex items-center justify-between mb-6 px-2">
                <div class="flex items-center flex-1">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold 
                            {{ $step === 'verificar' ? 'bg-blue-600 text-white' : 'bg-green-500 text-white' }}">
                            1
                        </div>
                        <span class="ml-2 text-sm {{ $step === 'verificar' ? 'text-blue-600 font-semibold' : 'text-gray-600' }}">
                            Verificar
                        </span>
                    </div>
                    <div class="flex-1 h-0.5 mx-3 {{ $step === 'verificar' ? 'bg-gray-300' : 'bg-green-500' }}"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold 
                            {{ $step === 'registro' ? 'bg-blue-600 text-white' : ($step === 'agendar' ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600') }}">
                            2
                        </div>
                        <span class="ml-2 text-sm {{ $step === 'registro' ? 'text-blue-600 font-semibold' : ($step === 'agendar' ? 'text-green-600' : 'text-gray-400') }}">
                            Registro
                        </span>
                    </div>
                    <div class="flex-1 h-0.5 mx-3 {{ $step === 'agendar' ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold 
                            {{ $step === 'agendar' ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600' }}">
                            3
                        </div>
                        <span class="ml-2 text-sm {{ $step === 'agendar' ? 'text-blue-600 font-semibold' : 'text-gray-400' }}">
                            Agendar
                        </span>
                    </div>
                </div>
            </div>

            <!-- Mensajes -->
            @if($mensaje)
                <div class="mb-4 p-4 rounded-lg border-l-4 
                    {{ $tipoMensaje === 'success' ? 'bg-green-50 border-green-500 text-green-700' : '' }}
                    {{ $tipoMensaje === 'error' ? 'bg-red-50 border-red-500 text-red-700' : '' }}
                    {{ $tipoMensaje === 'warning' ? 'bg-yellow-50 border-yellow-500 text-yellow-700' : '' }}
                    {{ $tipoMensaje === 'info' ? 'bg-blue-50 border-blue-500 text-blue-700' : '' }}
                    flex justify-between items-start">
                    <div class="flex items-start">
                        @if($tipoMensaje === 'success')
                            <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        @elseif($tipoMensaje === 'error')
                            <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        @elseif($tipoMensaje === 'warning')
                            <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        @else
                            <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                        <span class="text-sm">{{ $mensaje }}</span>
                    </div>
                    <button wire:click="$dispatch('limpiar-mensaje')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Contenido dinámico -->
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