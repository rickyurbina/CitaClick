<div>
    @if($isAuthenticated)
        <aside class="fixed left-0 top-0 h-full w-64 bg-surface border-r border-outline-variant flex flex-col py-lg z-50">
            <div class="px-md mb-xl flex items-center gap-sm">
                <div class="w-10 h-10 rounded bg-primary flex items-center justify-center text-on-primary">
                    <span class="material-symbols-outlined">admin_panel_settings</span>
                </div>
                <div>
                    <h1 class="font-headline-md text-headline-md font-bold text-primary leading-tight">AdminPanel</h1>
                    <p class="font-label-sm text-label-sm text-on-surface-variant">Gestión Corporativa</p>
                </div>
            </div>

            <nav class="flex-1 space-y-1">
                <button type="button"
                        wire:click="cambiarSeccion('dashboard')"
                        class="w-full flex items-center gap-md px-md py-sm font-label-md transition-colors
                            {{ $seccionActiva === 'dashboard'
                                ? 'bg-secondary-container text-on-secondary-container border-l-4 border-primary'
                                : 'text-on-surface-variant hover:bg-surface-container-high border-l-4 border-transparent' }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span>Dashboard</span>
                </button>
                <button type="button"
                        wire:click="cambiarSeccion('pagos')"
                        class="w-full flex items-center gap-md px-md py-sm font-label-md transition-colors
                            {{ $seccionActiva === 'pagos'
                                ? 'bg-secondary-container text-on-secondary-container border-l-4 border-primary'
                                : 'text-on-surface-variant hover:bg-surface-container-high border-l-4 border-transparent' }}">
                    <span class="material-symbols-outlined">payments</span>
                    <span>Pagos</span>
                </button>
            </nav>

            <div class="mt-auto px-md py-lg border-t border-outline-variant">
                <div class="flex items-center gap-md mb-md px-md">
                    <div class="w-10 h-10 rounded-full border border-primary/20 overflow-hidden bg-surface-container-high flex items-center justify-center">
                        <span class="material-symbols-outlined text-on-surface-variant">person</span>
                    </div>
                    <div class="min-w-0">
                        <p class="font-label-md text-on-surface leading-tight truncate">{{ $usuarioActual->nombre ?? 'Administrador' }}</p>
                        <p class="font-label-sm text-on-surface-variant">Superusuario</p>
                    </div>
                </div>
                <button type="button"
                        wire:click="logout"
                        class="w-full flex items-center gap-md text-on-surface-variant px-md py-sm hover:bg-surface-container-high transition-colors font-label-md rounded">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Cerrar Sesión</span>
                </button>
            </div>
        </aside>

        <header class="ml-64 flex justify-between items-center h-16 px-lg bg-surface-container-lowest sticky top-0 z-40 shadow-sm border-b border-outline-variant">
            <div class="flex items-center gap-xl flex-1">
                <h2 class="font-headline-md text-headline-md text-primary font-bold">
                    {{ $seccionActiva === 'pagos' ? 'Gestión de Pagos' : 'Panel Admin' }}
                </h2>
            </div>
            <div class="flex items-center gap-md">
                <div class="text-right hidden sm:block">
                    <p class="font-label-md text-on-surface leading-tight">{{ $usuarioActual->nombre ?? 'Administrador' }}</p>
                    <p class="font-label-sm text-on-surface-variant">Superusuario</p>
                </div>
                <div class="w-10 h-10 rounded-full border border-primary/20 overflow-hidden bg-surface-container-high flex items-center justify-center">
                    <span class="material-symbols-outlined text-on-surface-variant">person</span>
                </div>
            </div>
        </header>

        <main class="ml-64 p-lg">
            @if($seccionActiva === 'dashboard')
                <livewire:superadmin.dashboard wire:key="dashboard" />
            @elseif($seccionActiva === 'pagos')
                <livewire:superadmin.gestion-pagos wire:key="pagos" />
            @endif
        </main>
    @else
        <div class="min-h-screen flex items-center justify-center p-md bg-surface"
             style="background-color: #f8f9ff; background-image: radial-gradient(#e2e8f0 0.5px, transparent 0.5px); background-size: 24px 24px;">
            <div class="w-full max-w-[440px]">
                <div class="login-card bg-white w-full rounded-lg p-xl border border-outline-variant">
                    <div class="text-center mb-xl">
                        <h1 class="font-headline-lg text-headline-lg text-primary tracking-tight">AdminPanel</h1>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-xs">Gestión Corporativa</p>
                    </div>

                    @if($error)
                        <div class="mb-md p-md rounded-lg border border-outline-variant bg-error-container text-on-error-container font-body-sm">
                            {{ $error }}
                        </div>
                    @endif

                    @if($info)
                        <div class="mb-md p-md rounded-lg border border-outline-variant bg-secondary-container text-on-secondary-container font-body-sm">
                            {{ $info }}
                        </div>
                    @endif

                    <form wire:submit="login" class="space-y-lg">
                        <div class="space-y-xs">
                            <label class="font-label-md text-label-md text-on-surface" for="email">Correo Electrónico</label>
                            <div class="relative group">
                                <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">mail</span>
                                <input type="email"
                                       id="email"
                                       wire:model.live.debounce.300ms="email"
                                       class="w-full h-[40px] pl-[44px] pr-md border border-outline-variant rounded-lg bg-white font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all"
                                       placeholder="nombre@empresa.com">
                            </div>
                            @error('email') <span class="text-error font-label-sm text-label-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-xs">
                            <label class="font-label-md text-label-md text-on-surface" for="password">Contraseña</label>
                            <div class="relative group">
                                <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">lock</span>
                                <input type="password"
                                       id="password"
                                       wire:model.live.debounce.300ms="password"
                                       class="w-full h-[40px] pl-[44px] pr-md border border-outline-variant rounded-lg bg-white font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all"
                                       placeholder="••••••••">
                            </div>
                            @error('password') <span class="text-error font-label-sm text-label-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center gap-sm">
                            <input type="checkbox"
                                   id="remember"
                                   wire:model="remember"
                                   class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary/20">
                            <label class="font-body-sm text-body-sm text-on-surface-variant cursor-pointer select-none" for="remember">Recordarme en este dispositivo</label>
                        </div>

                        <button type="submit"
                                class="w-full h-[40px] bg-primary text-on-primary font-label-md text-label-md rounded-lg hover:opacity-90 active:scale-[0.98] transition-all flex items-center justify-center gap-sm"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove>Iniciar Sesión</span>
                            <span wire:loading class="flex items-center gap-sm">
                                <span class="material-symbols-outlined animate-spin text-[20px]">progress_activity</span>
                                Verificando...
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
