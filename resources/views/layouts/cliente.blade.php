@extends('layouts.app')

@section('body')
    <!-- SideNavBar (Cliente) -->
    <aside class="fixed left-0 top-0 h-full z-40 p-md h-full w-64 hidden md:flex flex-col bg-surface dark:bg-inverse-surface border-r border-outline-variant dark:border-outline">
        <div class="mb-3xl">
            <h1 class="font-headline-md text-headline-md font-bold text-primary">SecureCorp</h1>
            <p class="font-label-sm text-label-sm text-on-surface-variant">Cliente</p>
        </div>
        <nav class="flex-grow space-y-1">
            <a class="flex items-center gap-3 px-4 py-3 font-label-md text-label-md text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high transition-all duration-200 ease-in-out {{ request()->routeIs('cliente.servicios.*') ? 'bg-secondary-container dark:bg-on-secondary-fixed-variant text-on-secondary-container dark:text-secondary-fixed rounded-lg' : '' }}" href="{{ route('cliente.servicios.index') }}">
                <span class="material-symbols-outlined">inventory_2</span>
                <span>Catálogo</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 font-label-md text-label-md text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high transition-all duration-200 ease-in-out {{ request()->routeIs('cliente.agendar.*') ? 'bg-secondary-container dark:bg-on-secondary-fixed-variant text-on-secondary-container dark:text-secondary-fixed rounded-lg' : '' }}" href="{{ route('cliente.agendar.index') }}">
                <span class="material-symbols-outlined">calendar_today</span>
                <span>Agendar</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 font-label-md text-label-md text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high transition-all duration-200 ease-in-out" href="#">
                <span class="material-symbols-outlined">receipt_long</span>
                <span>Órdenes</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 font-label-md text-label-md text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high transition-all duration-200 ease-in-out" href="#">
                <span class="material-symbols-outlined">settings</span>
                <span>Configuración</span>
            </a>
        </nav>
        <div class="mt-auto border-t border-outline-variant pt-lg space-y-1">
            <a class="flex items-center gap-3 px-4 py-3 font-label-md text-label-md text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high transition-all duration-200 ease-in-out" href="#">
                <span class="material-symbols-outlined">help</span>
                <span>Ayuda</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 font-label-md text-label-md text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high transition-all duration-200 ease-in-out" href="#">
                <span class="material-symbols-outlined">logout</span>
                <span>Cerrar Sesión</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="md:pl-64 flex flex-col min-h-screen">
        <!-- TopAppBar -->
        <header class="sticky top-0 z-30 bg-surface dark:bg-inverse-surface border-b border-outline-variant dark:border-outline shadow-sm h-16 flex items-center">
            <div class="flex justify-between items-center w-full px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
                <div class="flex items-center gap-4">
                    <span class="md:hidden material-symbols-outlined text-primary cursor-pointer">menu</span>
                    <span class="font-headline-md text-headline-md font-headline-lg text-primary dark:text-inverse-primary">@yield('page_title', 'Cliente')</span>
                </div>
                <div class="flex items-center gap-md">
                    <div class="hidden md:flex items-center bg-surface-container-low px-4 py-2 rounded-full border border-outline-variant">
                        <span class="material-symbols-outlined text-on-surface-variant text-[20px]">search</span>
                        <input class="bg-transparent border-none focus:ring-0 text-body-sm font-body-sm ml-2 w-48" placeholder="Buscar..." type="text">
                    </div>
                    <div class="flex items-center gap-sm">
                        <button class="p-2 text-on-surface-variant hover:bg-surface-container-low rounded-full transition-colors cursor-pointer active:opacity-80">
                            <span class="material-symbols-outlined">notifications</span>
                        </button>
                        <button class="p-2 text-on-surface-variant hover:bg-surface-container-low rounded-full transition-colors cursor-pointer active:opacity-80">
                            <span class="material-symbols-outlined">help_outline</span>
                        </button>
                        <div class="w-8 h-8 rounded-full bg-surface-container-highest flex items-center justify-center border border-outline-variant ml-2 overflow-hidden">
                            <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCRr4E45wLLgOhZUNlo_LCTaqOwdEWYYsoLucxuccQ9HeOL4y0Zs4Z5XBKW8No8o1xYNFGUZLyx-Znx-zEyFmo1xRSdsj6NKQ9CLuOI71CQTXEJ5tke9J3zzyzFGMlTyjMByaLBC1v9Feifz9uTSQkG81D6F1xoqUQ1nI_UtMxp8s-rtB_PdAEDN1g6Dv7h8lPALi5zEyuhVNX0-HhGovkBToIjkdFpbFStit0u3_zYP-LtjgdPaOcUlA" alt="Avatar">
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-grow p-margin-mobile md:p-margin-desktop max-w-container-max w-full mx-auto">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="mt-auto py-lg border-t border-outline-variant bg-surface px-margin-desktop text-center md:text-left">
            <p class="font-label-sm text-label-sm text-on-surface-variant">© 2023 SecureCorp Enterprise Systems. Todos los derechos reservados.</p>
        </footer>
    </div>

    <!-- Mobile BottomNavBar -->
    <nav class="fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-2 pb-safe bg-surface dark:bg-inverse-surface h-16 md:hidden border-t border-outline-variant dark:border-outline shadow-lg">
        <a class="flex flex-col items-center justify-center text-on-surface-variant dark:text-surface-variant px-4 py-1 active:bg-surface-container-high transition-all" href="#">
            <span class="material-symbols-outlined">inventory_2</span>
            <span class="font-label-sm text-[10px]">Catálogo</span>
        </a>
        <a class="flex flex-col items-center justify-center bg-secondary-container dark:bg-on-secondary-fixed-variant text-on-secondary-container dark:text-secondary-fixed rounded-2xl px-4 py-1 active:bg-surface-container-high transition-all" href="#">
            <span class="material-symbols-outlined">event</span>
            <span class="font-label-sm text-[10px]">Agendar</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant dark:text-surface-variant px-4 py-1 active:bg-surface-container-high transition-all" href="#">
            <span class="material-symbols-outlined">person</span>
            <span class="font-label-sm text-[10px]">Perfil</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant dark:text-surface-variant px-4 py-1 active:bg-surface-container-high transition-all" href="#">
            <span class="material-symbols-outlined">more_horiz</span>
            <span class="font-label-sm text-[10px]">Menú</span>
        </a>
    </nav>
@endsection