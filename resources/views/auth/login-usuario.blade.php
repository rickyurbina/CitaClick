@extends('layouts.public')

@section('title', 'SecureCorp - Iniciar Sesión')

@section('styles')
    <style>
        .login-card-shadow {
            box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.04), 0 2px 4px -2px rgba(15, 23, 42, 0.04);
        }
        .login-card-shadow:hover {
            box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.08), 0 4px 6px -4px rgba(15, 23, 42, 0.08);
        }
    </style>
@endsection

@section('content')
    <div class="w-full max-w-md z-10 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <div class="flex flex-col items-center mb-xl">
            <img alt="SecureCorp Logo" class="w-[250px] h-[250px] object-contain mb-md drop-shadow-sm transition-transform duration-500 hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDcv7U0puuCB9jsR5bvpFuWCfPzMEIbnBNKUUr7Fp3bAxpvfXQR9ugEGJ_JEsVPS2dsj4tyyFMJy-clYQI5RX5HKPXUz0TR5oSUTHXA0i0N0Rh_0ukHkusVq5p8NfLlKw0-E_9weq4_tWH4q4FLhDMldt7MEnW6BDnu_5d77P_5WfCzF4JyEdboUdkCaLo3f2eP3VZDb29oAV_6kfRYXXNbnEmPlprCq6KYXRnUiBlPmxbOJOMSbVInVA">
            <h1 class="font-headline-md text-headline-md text-primary tracking-tight">Acceso Corporativo</h1>
            <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">Bienvenido de nuevo a SecureCorp</p>
        </div>
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg login-card-shadow transition-shadow duration-300">
            <form class="space-y-md" id="login-form" method="POST" action="#">
                @csrf
                <div class="space-y-xs">
                    <label class="font-label-sm text-label-sm text-on-surface-variant block ml-1" for="email">Correo Electrónico</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-outline group-focus-within:text-secondary transition-colors">
                            <span class="material-symbols-outlined text-[20px]">mail</span>
                        </div>
                        <input class="w-full pl-10 pr-4 py-3 bg-white border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all" id="email" name="email" placeholder="ejemplo@securecorp.com" required type="email">
                    </div>
                </div>
                <div class="space-y-xs">
                    <div class="flex justify-between items-center px-1">
                        <label class="font-label-sm text-label-sm text-on-surface-variant block" for="password">Contraseña</label>
                        <a class="font-label-sm text-label-sm text-secondary hover:text-on-secondary-container transition-colors" href="#">Olvidé mi contraseña</a>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-outline group-focus-within:text-secondary transition-colors">
                            <span class="material-symbols-outlined text-[20px]">lock</span>
                        </div>
                        <input class="w-full pl-10 pr-12 py-3 bg-white border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all" id="password" name="password" placeholder="••••••••" required type="password">
                        <button class="absolute inset-y-0 right-0 pr-3 flex items-center text-outline hover:text-on-surface-variant transition-colors" onclick="togglePassword()" type="button">
                            <span class="material-symbols-outlined text-[20px]" id="password-toggle-icon">visibility</span>
                        </button>
                    </div>
                </div>
                <div class="flex items-center space-x-2 px-1">
                    <input class="w-4 h-4 text-secondary border-outline-variant rounded focus:ring-secondary cursor-pointer" id="remember" type="checkbox">
                    <label class="font-body-sm text-body-sm text-on-surface-variant cursor-pointer select-none" for="remember">Recordar mi sesión</label>
                </div>
                <button class="w-full bg-[#10B981] text-white font-label-md text-label-md py-4 rounded-lg shadow-sm hover:bg-[#059669] active:scale-[0.98] transition-all duration-200 mt-md flex items-center justify-center space-x-2" type="submit">
                    <span>Iniciar Sesión</span>
                    <span class="material-symbols-outlined text-[18px]">login</span>
                </button>
            </form>
        </div>
        <div class="mt-xl text-center">
            <p class="font-body-sm text-body-sm text-on-surface-variant">
                ¿No tienes una cuenta?
                <a class="text-secondary font-label-sm text-label-sm font-semibold hover:underline decoration-2 underline-offset-4" href="#">Contactar Soporte IT</a>
            </p>
        </div>
        <div class="mt-2xl text-center space-y-2 opacity-50">
            <div class="flex justify-center space-x-md text-[10px] uppercase tracking-widest font-bold text-on-surface-variant">
                <a class="hover:text-primary" href="#">Privacidad</a>
                <span>•</span>
                <a class="hover:text-primary" href="#">Términos</a>
                <span>•</span>
                <a class="hover:text-primary" href="#">Seguridad</a>
            </div>
            <p class="text-[10px] text-on-surface-variant">© 2024 SecureCorp Enterprise Tier. Todos los derechos reservados.</p>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('password-toggle-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = 'visibility_off';
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = 'visibility';
            }
        }

        const loginForm = document.getElementById('login-form');
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const btn = loginForm.querySelector('button[type="submit"]');
            const originalContent = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Autenticando...</span>
            `;
            btn.classList.add('opacity-80');
            setTimeout(() => {
                btn.innerHTML = `<span class="material-symbols-outlined">check_circle</span> <span>¡Éxito!</span>`;
                btn.classList.replace('bg-[#10B981]', 'bg-secondary');
                setTimeout(() => {
                    btn.disabled = false;
                    btn.innerHTML = originalContent;
                    btn.classList.replace('bg-secondary', 'bg-[#10B981]');
                    btn.classList.remove('opacity-80');
                    alert('Simulación de inicio de sesión completada.');
                }, 1000);
            }, 1500);
        });

        document.addEventListener('mousemove', (e) => {
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;
            const blobs = document.querySelectorAll('.bg-surface-container, .bg-secondary-container');
            blobs.forEach((blob, index) => {
                const speed = (index + 1) * 20;
                blob.style.transform = `translate(${x * speed}px, ${y * speed}px)`;
            });
        });
    </script>
@endpush