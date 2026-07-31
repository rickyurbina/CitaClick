@extends('layouts.app')

@section('body')
    <aside class="fixed left-0 top-0 h-full w-64 bg-surface dark:bg-inverse-surface border-r border-outline-variant dark:border-outline flex flex-col h-full py-lg z-50">
        <div class="px-md mb-xl flex items-center gap-sm">
            <div class="w-10 h-10 rounded bg-primary flex items-center justify-center text-on-primary">
                <span class="material-symbols-outlined">admin_panel_settings</span>
            </div>
            <div>
                <h1 class="font-headline-md text-headline-md font-bold text-primary dark:text-inverse-primary leading-tight">AdminPanel</h1>
                <p class="font-label-sm text-label-sm text-on-surface-variant">Gestión Corporativa</p>
            </div>
        </div>
        <nav class="flex-1 space-y-1">
            <a class="flex items-center gap-md text-on-surface-variant dark:text-surface-variant px-md py-sm hover:bg-surface-container-high transition-colors font-label-md {{ request()->routeIs('admin.dashboard') ? 'bg-secondary-container dark:bg-secondary text-on-secondary-container dark:text-on-secondary border-l-4 border-primary' : '' }}" href="{{ route('admin.dashboard') }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span>Dashboard</span>
            </a>
            <a class="flex items-center gap-md text-on-surface-variant dark:text-surface-variant px-md py-sm hover:bg-surface-container-high transition-colors font-label-md {{ request()->routeIs('admin.negocios.*') ? 'bg-secondary-container dark:bg-secondary text-on-secondary-container dark:text-on-secondary border-l-4 border-primary' : '' }}" href="{{ route('admin.negocios.index') }}">
                <span class="material-symbols-outlined">storefront</span>
                <span>Negocios</span>
            </a>
            <a class="flex items-center gap-md text-on-surface-variant dark:text-surface-variant px-md py-sm hover:bg-surface-container-high transition-colors font-label-md {{ request()->routeIs('admin.clientes.*') ? 'bg-secondary-container dark:bg-secondary text-on-secondary-container dark:text-on-secondary border-l-4 border-primary' : '' }}" href="#">
                <span class="material-symbols-outlined">group</span>
                <span>Clientes</span>
            </a>
            <a class="flex items-center gap-md text-on-surface-variant dark:text-surface-variant px-md py-sm hover:bg-surface-container-high transition-colors font-label-md {{ request()->routeIs('admin.finanzas.*') ? 'bg-secondary-container dark:bg-secondary text-on-secondary-container dark:text-on-secondary border-l-4 border-primary' : '' }}" href="#">
                <span class="material-symbols-outlined">payments</span>
                <span>Finanzas</span>
            </a>
            <a class="flex items-center gap-md text-on-surface-variant dark:text-surface-variant px-md py-sm hover:bg-surface-container-high transition-colors font-label-md {{ request()->routeIs('admin.reportes.*') ? 'bg-secondary-container dark:bg-secondary text-on-secondary-container dark:text-on-secondary border-l-4 border-primary' : '' }}" href="#">
                <span class="material-symbols-outlined">analytics</span>
                <span>Reportes</span>
            </a>
            <a class="flex items-center gap-md text-on-surface-variant dark:text-surface-variant px-md py-sm hover:bg-surface-container-high transition-colors font-label-md {{ request()->routeIs('admin.configuracion.*') ? 'bg-secondary-container dark:bg-secondary text-on-secondary-container dark:text-on-secondary border-l-4 border-primary' : '' }}" href="#">
                <span class="material-symbols-outlined">settings</span>
                <span>Configuración</span>
            </a>
        </nav>
        <div class="mt-auto px-md py-lg border-t border-outline-variant">
            <a href="{{ route('admin.negocios.create') }}" class="w-full mb-md bg-primary text-on-primary font-label-md py-sm rounded hover:opacity-90 transition-opacity flex items-center justify-center gap-sm">
                <span class="material-symbols-outlined text-[20px]">add_circle</span>
                Nuevo Negocio
            </a>
            <div class="space-y-1">
                <a class="flex items-center gap-md text-on-surface-variant dark:text-surface-variant px-md py-sm hover:bg-surface-container-high transition-colors font-label-md" href="#">
                    <span class="material-symbols-outlined">help</span>
                    <span>Ayuda</span>
                </a>
                <a class="flex items-center gap-md text-on-surface-variant dark:text-surface-variant px-md py-sm hover:bg-surface-container-high transition-colors font-label-md" href="#">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Cerrar Sesión</span>
                </a>
            </div>
        </div>
    </aside>

    <header class="ml-64 flex justify-between items-center h-16 px-lg bg-surface-container-lowest dark:bg-inverse-surface sticky top-0 z-40 shadow-sm dark:shadow-none border-b border-outline-variant dark:border-outline">
        <div class="flex items-center gap-xl flex-1">
            <h2 class="font-headline-sm text-headline-sm text-primary dark:text-inverse-primary font-bold">@yield('page_title', 'Panel Admin')</h2>
            <div class="relative w-full max-w-md ml-4">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                <input class="w-full bg-surface-container border border-outline-variant rounded-full pl-10 pr-4 py-1.5 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all font-body-sm text-on-surface" placeholder="Buscar..." type="text">
            </div>
        </div>
        <div class="flex items-center gap-lg">
            <div class="flex items-center gap-sm">
                <button class="w-10 h-10 flex items-center justify-center rounded-full text-on-surface-variant hover:bg-surface-container-high transition-colors">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <button class="w-10 h-10 flex items-center justify-center rounded-full text-on-surface-variant hover:bg-surface-container-high transition-colors">
                    <span class="material-symbols-outlined">settings</span>
                </button>
            </div>
            <div class="h-8 w-[1px] bg-outline-variant mx-sm"></div>
            <div class="flex items-center gap-md">
                <div class="text-right hidden sm:block">
                    <p class="font-label-md text-on-surface leading-tight">Admin Principal</p>
                    <p class="font-label-sm text-on-surface-variant">Superusuario</p>
                </div>
                <div class="w-10 h-10 rounded-full border border-primary/20 overflow-hidden bg-surface-container-high">
                    <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCwgkl8mkspG-H66L3VG_uhCM49Q-7BlY1ZrhAPb4L1Z0EP_46J156K17ljxjophKrg7-nA8kpU-6jSCZuCiZOGXGcdzpSheNfJ0-jiDJ55HJPHUQLmg4kNKBFU0vNqyW-1fTeLdiM4JXy1pCY9A-aU42XYb1s74dMjASudX3Y8xnRUUwVA7w1YRrnMEqIKvEQ7Tn4O64z_8AhtSCtCKItk1VgpB7skHD49_GqsZ06ogx4GnJdc3pCSVQ" alt="Admin">
                </div>
            </div>
        </div>
    </header>

    <main class="ml-64 p-lg">
        @yield('content')
    </main>
@endsection