<div class="min-h-screen bg-surface">
    @if($isAuthenticated)
        <aside class="fixed left-0 top-0 h-full z-40 p-md w-64 hidden md:flex flex-col bg-surface border-r border-outline-variant">
            <div class="mb-3xl">
                <h1 class="font-headline-md text-headline-md font-bold text-primary">{{ $empresa->nombre }}</h1>
                <p class="font-label-sm text-label-sm text-on-surface-variant mt-xs">Bienvenido, {{ $usuarioActual->nombre }}</p>
                <span class="inline-flex items-center mt-sm px-sm py-1 rounded-lg font-label-sm text-label-sm
                    @if($esAdmin) bg-secondary-container text-on-secondary-container
                    @elseif($esRecepcionista) bg-surface-container-high text-on-surface
                    @else bg-primary-container text-on-primary-container @endif">
                    {{ ucfirst($usuarioActual->rol) }}
                </span>
            </div>

            <nav class="flex-grow space-y-1 overflow-y-auto">
                {{-- Dashboard: SOLO admin (dueño) --}}
                @if($esAdmin)
                <button wire:click="cambiarSeccion('dashboard')"
                        type="button"
                        class="w-full flex items-center gap-3 px-4 py-3 font-label-md text-label-md transition-all duration-200 ease-in-out rounded-lg
                            {{ $seccionActiva === 'dashboard'
                                ? 'bg-secondary-container text-on-secondary-container'
                                : 'text-on-surface-variant hover:bg-surface-container-high' }}">
                    <span class="material-symbols-outlined">grid_view</span>
                    <span>Dashboard</span>
                </button>
                @endif

                {{-- Citas: todos los roles --}}
                @if($puedeGestionarCitas)
                <button wire:click="cambiarSeccion('citas')"
                        type="button"
                        class="w-full flex items-center gap-3 px-4 py-3 font-label-md text-label-md transition-all duration-200 ease-in-out rounded-lg
                            {{ $seccionActiva === 'citas'
                                ? 'bg-secondary-container text-on-secondary-container'
                                : 'text-on-surface-variant hover:bg-surface-container-high' }}">
                    <span class="material-symbols-outlined">calendar_today</span>
                    <span>Gestión de Citas</span>
                    @if($esColaborador)
                        <span class="ml-auto text-xs bg-secondary-container/50 text-on-secondary-container px-2 py-0.5 rounded-full">Mi vista</span>
                    @endif
                    @if($esRecepcionista)
                        <span class="ml-auto text-xs bg-secondary-container/50 text-on-secondary-container px-2 py-0.5 rounded-full">Recepción</span>
                    @endif
                </button>
                @endif

                {{-- Colaboradores y Servicios: solo admin (dueño) --}}
                @if($esAdmin)
                <button wire:click="cambiarSeccion('colaboradores')"
                        type="button"
                        class="w-full flex items-center gap-3 px-4 py-3 font-label-md text-label-md transition-all duration-200 ease-in-out rounded-lg
                            {{ $seccionActiva === 'colaboradores'
                                ? 'bg-secondary-container text-on-secondary-container'
                                : 'text-on-surface-variant hover:bg-surface-container-high' }}">
                    <span class="material-symbols-outlined">group</span>
                    <span>Colaboradores</span>
                </button>

                <button wire:click="cambiarSeccion('servicios')"
                        type="button"
                        class="w-full flex items-center gap-3 px-4 py-3 font-label-md text-label-md transition-all duration-200 ease-in-out rounded-lg
                            {{ $seccionActiva === 'servicios'
                                ? 'bg-secondary-container text-on-secondary-container'
                                : 'text-on-surface-variant hover:bg-surface-container-high' }}">
                    <span class="material-symbols-outlined">content_cut</span>
                    <span>Servicios</span>
                </button>
                @endif
            </nav>

            <div class="mt-auto border-t border-outline-variant pt-lg">
                <button wire:click="logout"
                        type="button"
                        class="w-full flex items-center gap-3 px-4 py-3 font-label-md text-label-md text-on-surface-variant hover:bg-surface-container-high transition-all duration-200 ease-in-out rounded-lg">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Cerrar sesión</span>
                </button>
            </div>
        </aside>

        {{-- Mobile nav --}}
        <div class="md:pl-64 flex flex-col min-h-screen">
            <header class="sticky top-0 z-30 bg-surface border-b border-outline-variant shadow-sm h-16 flex items-center md:hidden">
                <div class="flex justify-between items-center w-full px-margin-mobile">
                    <span class="font-headline-md text-headline-md text-primary">{{ $empresa->nombre }}</span>
                    <button wire:click="logout" type="button" class="p-2 text-on-surface-variant hover:bg-surface-container-low rounded-full transition-colors">
                        <span class="material-symbols-outlined">logout</span>
                    </button>
                </div>
            </header>

            <main class="flex-grow p-margin-mobile md:p-margin-desktop max-w-container-max w-full mx-auto pb-20 md:pb-margin-desktop">
                @if($seccionActiva === 'dashboard')
                    <livewire:admin.dashboard :empresa="$empresa" wire:key="dashboard-{{ $empresa->id }}" />
                @elseif($seccionActiva === 'citas')
                    <livewire:admin.gestion-citas :empresa="$empresa" wire:key="citas-{{ $empresa->id }}" />
                @elseif($seccionActiva === 'colaboradores')
                    <livewire:admin.gestion-colaboradores :empresa="$empresa" wire:key="colaboradores-{{ $empresa->id }}" />
                @elseif($seccionActiva === 'servicios')
                    <livewire:admin.gestion-servicios :empresa="$empresa" wire:key="servicios-{{ $empresa->id }}" />
                @else
                    <div class="text-center py-2xl">
                        <p class="font-body-md text-body-md text-on-surface-variant">Sección en construcción...</p>
                    </div>
                @endif
            </main>
        </div>

        {{-- Mobile bottom nav --}}
        <nav class="fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-2 pb-safe bg-surface h-16 md:hidden border-t border-outline-variant shadow-lg">
            {{-- Dashboard - solo admin --}}
            @if($esAdmin)
            <button wire:click="cambiarSeccion('dashboard')" type="button"
                    class="flex flex-col items-center justify-center px-4 py-1 transition-all
                        {{ $seccionActiva === 'dashboard' ? 'bg-secondary-container text-on-secondary-container rounded-2xl' : 'text-on-surface-variant' }}">
                <span class="material-symbols-outlined">grid_view</span>
                <span class="font-label-sm text-[10px]">Dashboard</span>
            </button>
            @endif

            {{-- Citas - para todos --}}
            @if($puedeGestionarCitas)
            <button wire:click="cambiarSeccion('citas')" type="button"
                    class="flex flex-col items-center justify-center px-4 py-1 transition-all
                        {{ $seccionActiva === 'citas' ? 'bg-secondary-container text-on-secondary-container rounded-2xl' : 'text-on-surface-variant' }}">
                <span class="material-symbols-outlined">event</span>
                <span class="font-label-sm text-[10px]">Citas</span>
                @if($esColaborador)
                    <span class="text-[8px] text-secondary">mi vista</span>
                @endif
                @if($esRecepcionista)
                    <span class="text-[8px] text-secondary">recepción</span>
                @endif
            </button>
            @endif

            {{-- Solo admin --}}
            @if($esAdmin)
            <button wire:click="cambiarSeccion('colaboradores')" type="button"
                    class="flex flex-col items-center justify-center px-4 py-1 transition-all
                        {{ $seccionActiva === 'colaboradores' ? 'bg-secondary-container text-on-secondary-container rounded-2xl' : 'text-on-surface-variant' }}">
                <span class="material-symbols-outlined">group</span>
                <span class="font-label-sm text-[10px]">Equipo</span>
            </button>
            <button wire:click="cambiarSeccion('servicios')" type="button"
                    class="flex flex-col items-center justify-center px-4 py-1 transition-all
                        {{ $seccionActiva === 'servicios' ? 'bg-secondary-container text-on-secondary-container rounded-2xl' : 'text-on-surface-variant' }}">
                <span class="material-symbols-outlined">content_cut</span>
                <span class="font-label-sm text-[10px]">Servicios</span>
            </button>
            @endif
        </nav>
    @else
        {{-- LOGIN (sin cambios) --}}
        <div class="min-h-screen flex items-center justify-center p-margin-mobile relative overflow-hidden">
            <div class="absolute inset-0 bg-surface pointer-events-none">
                <div class="absolute top-1/4 -left-20 w-72 h-72 bg-surface-container rounded-full blur-3xl opacity-60"></div>
                <div class="absolute bottom-1/4 -right-20 w-80 h-80 bg-secondary-container rounded-full blur-3xl opacity-40"></div>
            </div>

            <div class="w-full max-w-md z-10">
                <div class="flex flex-col items-center mb-xl">
                    @if($empresa->logo_url)
                        <img alt="{{ $empresa->nombre }}"
                             class="w-[160px] h-[160px] object-contain mb-md drop-shadow-sm"
                             src="{{ Storage::url($empresa->logo_url) }}">
                    @endif
                    <h1 class="font-headline-md text-headline-md text-primary tracking-tight">{{ $empresa->nombre }}</h1>
                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">Acceso administrativo</p>
                </div>

                <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg shadow-sm">
                    @if($error)
                        <div class="mb-md p-md rounded-lg border border-error bg-error-container text-on-error-container font-body-sm text-body-sm">
                            {{ $error }}
                        </div>
                    @endif

                    @if($info)
                        <div class="mb-md p-md rounded-lg border border-secondary bg-secondary-container text-on-secondary-container font-body-sm text-body-sm">
                            {{ $info }}
                        </div>
                    @endif

                    <form wire:submit="login" class="space-y-md">
                        <div class="space-y-xs">
                            <label class="font-label-sm text-label-sm text-on-surface-variant block ml-1" for="admin-email">Correo Electrónico</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-outline group-focus-within:text-secondary transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">mail</span>
                                </div>
                                <input type="email"
                                       id="admin-email"
                                       wire:model.live.debounce.300ms="email"
                                       class="w-full pl-10 pr-4 py-3 bg-white border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all"
                                       placeholder="trabajador@empresa.com"
                                       autocomplete="email"
                                       autofocus>
                            </div>
                            @error('email') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-xs">
                            <label class="font-label-sm text-label-sm text-on-surface-variant block ml-1" for="admin-password">Contraseña</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-outline group-focus-within:text-secondary transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">lock</span>
                                </div>
                                <input type="password"
                                       id="admin-password"
                                       wire:model.live.debounce.300ms="password"
                                       class="w-full pl-10 pr-4 py-3 bg-white border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all"
                                       placeholder="••••••••"
                                       autocomplete="current-password">
                            </div>
                            @error('password') <span class="text-error text-label-sm font-label-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center space-x-2 px-1">
                            <input type="checkbox"
                                   wire:model="remember"
                                   id="admin-remember"
                                   class="w-4 h-4 text-secondary border-outline-variant rounded focus:ring-secondary cursor-pointer">
                            <label class="font-body-sm text-body-sm text-on-surface-variant cursor-pointer select-none" for="admin-remember">Recordar mi sesión</label>
                        </div>

                        <button type="submit"
                                class="w-full bg-primary text-on-primary font-label-md text-label-md py-4 rounded-lg shadow-sm hover:opacity-90 active:scale-[0.98] transition-all duration-200 mt-md flex items-center justify-center gap-2"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove class="flex items-center gap-2">
                                <span>Iniciar Sesión</span>
                                <span class="material-symbols-outlined text-[18px]">login</span>
                            </span>
                            <span wire:loading class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px] animate-spin">progress_activity</span>
                                <span>Verificando...</span>
                            </span>
                        </button>
                    </form>
                </div>

                <div class="mt-2xl text-center opacity-50">
                    <p class="text-[10px] text-on-surface-variant">© {{ date('Y') }} {{ $empresa->nombre }}</p>
                </div>
            </div>
        </div>
    @endif
</div>