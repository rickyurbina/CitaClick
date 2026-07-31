<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">

        @if ($step === 'verificar')
            <livewire:verificar-telefono :empresa="$empresa" :key="'verificar-'.$empresa->id" />

        @elseif ($step === 'registro')
            <livewire:registro-cliente :empresa="$empresa" :key="'registro-'.$empresa->id" />

        @elseif ($step === 'agendar')
            <livewire:agendar-cita :empresa="$empresa" :cliente-id="$clienteId" :key="'agendar-'.$empresa->id" />
        @endif

    </div>
</div>