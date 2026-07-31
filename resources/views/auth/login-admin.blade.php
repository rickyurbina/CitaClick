@extends('layouts.public')

@section('title', 'AdminPanel - Iniciar Sesión')

@section('styles')
    <style>
        .bg-subtle-pattern {
            background-color: #f8f9ff;
            background-image: radial-gradient(#e2e8f0 0.5px, transparent 0.5px);
            background-size: 24px 24px;
        }
        .login-card {
            box-shadow: 0px 4px 6px -1px rgba(0, 0, 0, 0.1), 0px 10px 15px -3px rgba(0, 0, 0, 0.05);
        }
    </style>
@endsection

@section('content')
    <div class="w-full max-w-[440px]">
        <div class="login-card bg-white w-full rounded-lg p-xl border border-outline-variant">
            <div class="text-center mb-xl">
                <h1 class="font-display-lg text-display-lg text-primary tracking-tight">AdminPanel</h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-xs">Gestión Corporativa</p>
            </div>
            <form class="space-y-lg" method="POST" action="#">
                @csrf
                <div class="space-y-xs">
                    <label class="font-label-md text-label-md text-on-surface" for="email">Correo Electrónico</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">mail</span>
                        <input class="w-full h-[40px] pl-[44px] pr-md border border-outline-variant rounded-lg bg-white font-body-md text-body-md focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" id="email" placeholder="nombre@empresa.com" type="email">
                    </div>
                </div>
                <div class="space-y-xs">
                    <div class="flex justify-between items-center">
                        <label class="font-label-md text-label-md text-on-surface" for="password">Contraseña</label>
                        <a class="font-label-sm text-label-sm text-secondary hover:underline" href="#">¿Olvidaste tu contraseña?</a>
                    </div>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">lock</span>
                        <input class="w-full h-[40px] pl-[44px] pr-[44px] border border-outline-variant rounded-lg bg-white font-body-md text-body-md focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" id="password" placeholder="••••••••" type="password">
                        <button class="absolute right-md top-1/2 -translate-y-1/2 text-outline hover:text-on-surface transition-colors" onclick="togglePassword()" type="button">
                            <span class="material-symbols-outlined" id="visibilityIcon">visibility</span>
                        </button>
                    </div>
                </div>
                <div class="flex items-center gap-sm">
                    <input class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary/20" id="remember" type="checkbox">
                    <label class="font-body-sm text-body-sm text-on-surface-variant cursor-pointer select-none" for="remember">Recordarme en este dispositivo</label>
                </div>
                <button class="w-full h-[40px] bg-primary text-white font-label-md text-label-md rounded-lg hover:opacity-90 active:scale-[0.98] transition-all flex items-center justify-center gap-sm" type="submit">
                    Iniciar Sesión
                </button>
            </form>
            <div class="relative my-xl">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-outline-variant"></div>
                </div>
                <div class="relative flex justify-center text-label-sm uppercase">
                    <span class="bg-white px-md text-outline">O continuar con</span>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-md">
                <button class="w-full h-[40px] border border-outline-variant rounded-lg flex items-center justify-center gap-sm font-label-md text-label-md text-on-surface hover:bg-surface-container-low transition-colors">
                    <img class="w-5 h-5" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDYOyr6S7teTKawJ7bZ88k1WwEAFsggtnGxqKR7ROxSLWgIrycZUwnTuy_NUbFcagL9Pnrbx-hFqULAj3s8nGhIAyOrSBgA3wh84YpvqbYMbLQ-6qA6kzRY7XtsI-aqj_19XZPhp5vXnki1hia3nHQGae8WWGKOlib2LpZRhlvRORZ1xysvCg8EKIaTAWUNitsvxCj7qfAhAyIXmdDlZ9GvemrzpOWUIdbQLJJFqjnybjiVSkNYGr1awg" alt="Google">
                    Single Sign-On Corporativo
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('visibilityIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                passwordInput.type = 'password';
                icon.textContent = 'visibility';
            }
        }

        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = this.querySelector('button[type="submit"]');
            btn.innerHTML = '<span class="animate-spin material-symbols-outlined">progress_activity</span> Accediendo...';
            btn.disabled = true;
            setTimeout(() => {
                btn.innerHTML = 'Iniciar Sesión';
                btn.disabled = false;
            }, 1500);
        });
    </script>
@endpush