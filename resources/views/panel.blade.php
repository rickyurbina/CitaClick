<!DOCTYPE html>

<html class="light" lang="es"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>SecureCorp - Iniciar Sesión</title>
<!-- Material Symbols -->
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet"/>
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<!-- Shared Style Guidance Tokens -->
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "surface-container-high": "#dce9ff",
                    "on-surface-variant": "#45464d",
                    "on-secondary-fixed-variant": "#005236",
                    "on-primary-fixed": "#131b2e",
                    "on-secondary-container": "#00714d",
                    "surface-dim": "#cbdbf5",
                    "inverse-on-surface": "#eaf1ff",
                    "on-error": "#ffffff",
                    "secondary": "#006c49",
                    "surface": "#f8f9ff",
                    "secondary-fixed": "#6ffbbe",
                    "on-background": "#0b1c30",
                    "on-tertiary": "#ffffff",
                    "primary-fixed": "#dae2fd",
                    "surface-variant": "#d3e4fe",
                    "surface-container-lowest": "#ffffff",
                    "on-tertiary-fixed": "#191c1e",
                    "outline-variant": "#c6c6cd",
                    "inverse-primary": "#bec6e0",
                    "on-secondary-fixed": "#002113",
                    "secondary-container": "#6cf8bb",
                    "on-primary-fixed-variant": "#3f465c",
                    "surface-container-highest": "#d3e4fe",
                    "on-primary-container": "#7c839b",
                    "surface-container": "#e5eeff",
                    "error": "#ba1a1a",
                    "surface-container-low": "#eff4ff",
                    "on-tertiary-fixed-variant": "#444749",
                    "primary": "#000000",
                    "tertiary-fixed": "#e0e3e5",
                    "primary-fixed-dim": "#bec6e0",
                    "on-secondary": "#ffffff",
                    "outline": "#76777d",
                    "surface-tint": "#565e74",
                    "on-surface": "#0b1c30",
                    "tertiary-fixed-dim": "#c4c7c9",
                    "on-primary": "#ffffff",
                    "tertiary-container": "#191c1e",
                    "on-tertiary-container": "#818486",
                    "secondary-fixed-dim": "#4edea3",
                    "tertiary": "#000000",
                    "error-container": "#ffdad6",
                    "inverse-surface": "#213145",
                    "background": "#f8f9ff",
                    "on-error-container": "#93000a",
                    "surface-bright": "#f8f9ff",
                    "primary-container": "#131b2e"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "spacing": {
                    "gutter": "24px",
                    "3xl": "64px",
                    "2xl": "48px",
                    "margin-desktop": "32px",
                    "container-max": "1280px",
                    "lg": "24px",
                    "base": "4px",
                    "xl": "32px",
                    "xs": "4px",
                    "md": "16px",
                    "margin-mobile": "16px",
                    "sm": "8px"
            },
            "fontFamily": {
                    "label-md": ["Inter"],
                    "body-sm": ["Inter"],
                    "headline-md": ["Inter"],
                    "headline-lg": ["Inter"],
                    "body-lg": ["Inter"],
                    "headline-xl": ["Inter"],
                    "label-sm": ["Inter"],
                    "headline-lg-mobile": ["Inter"],
                    "body-md": ["Inter"]
            },
            "fontSize": {
                    "label-md": ["14px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600"}],
                    "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                    "headline-md": ["24px", {"lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                    "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "700"}],
                    "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                    "headline-xl": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                    "label-sm": ["12px", {"lineHeight": "16px", "fontWeight": "500"}],
                    "headline-lg-mobile": ["28px", {"lineHeight": "36px", "letterSpacing": "-0.01em", "fontWeight": "700"}],
                    "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}]
            }
          },
        },
      }
    </script>
<style>
        body {
            background-color: #f8f9ff;
            font-family: 'Inter', sans-serif;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .login-card-shadow {
            box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.04), 0 2px 4px -2px rgba(15, 23, 42, 0.04);
        }
        .login-card-shadow:hover {
            box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.08), 0 4px 6px -4px rgba(15, 23, 42, 0.08);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-margin-mobile md:p-margin-desktop relative overflow-hidden">
<!-- Atmospheric Background Decoration -->
<div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
<div class="absolute top-[-10%] right-[-5%] w-[40rem] h-[40rem] bg-surface-container rounded-full opacity-50 blur-3xl"></div>
<div class="absolute bottom-[-10%] left-[-5%] w-[35rem] h-[35rem] bg-secondary-container rounded-full opacity-30 blur-3xl"></div>
</div>
<!-- Navigation Shell Suppressed as per "The Destination Rule" for Transactional Screens -->
<main class="w-full max-w-md z-10 animate-in fade-in slide-in-from-bottom-4 duration-700">
<!-- Logo Section -->
<div class="flex flex-col items-center mb-xl">
<img alt="SecureCorp Logo" class="w-[250px] h-[250px] object-contain mb-md drop-shadow-sm transition-transform duration-500 hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDcv7U0puuCB9jsR5bvpFuWCfPzMEIbnBNKUUr7Fp3bAxpvfXQR9ugEGJ_JEsVPS2dsj4tyyFMJy-clYQI5RX5HKPXUz0TR5oSUTHXA0i0N0Rh_0ukHkusVq5p8NfLlKw0-E_9weq4_tWH4q4FLhDMldt7MEnW6BDnu_5d77P_5WfCzF4JyEdboUdkCaLo3f2eP3VZDb29oAV_6kfRYXXNbnEmPlprCq6KYXRnUiBlPmxbOJOMSbVInVA"/>
<h1 class="font-headline-md text-headline-md text-primary tracking-tight">Acceso Corporativo</h1>
<p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">Bienvenido de nuevo a SecureCorp</p>
</div>
<!-- Login Form Card -->
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg login-card-shadow transition-shadow duration-300">
<form class="space-y-md" id="login-form">
<!-- Email Input Group -->
<div class="space-y-xs">
<label class="font-label-sm text-label-sm text-on-surface-variant block ml-1" for="email">Correo Electrónico</label>
<div class="relative group">
<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-outline group-focus-within:text-secondary transition-colors">
<span class="material-symbols-outlined text-[20px]">mail</span>
</div>
<input class="w-full pl-10 pr-4 py-3 bg-white border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all" id="email" name="email" placeholder="ejemplo@securecorp.com" required="" type="email"/>
</div>
</div>
<!-- Password Input Group -->
<div class="space-y-xs">
<div class="flex justify-between items-center px-1">
<label class="font-label-sm text-label-sm text-on-surface-variant block" for="password">Contraseña</label>
<a class="font-label-sm text-label-sm text-secondary hover:text-on-secondary-container transition-colors" href="#">Olvidé mi contraseña</a>
</div>
<div class="relative group">
<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-outline group-focus-within:text-secondary transition-colors">
<span class="material-symbols-outlined text-[20px]">lock</span>
</div>
<input class="w-full pl-10 pr-12 py-3 bg-white border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all" id="password" name="password" placeholder="••••••••" required="" type="password"/>
<button class="absolute inset-y-0 right-0 pr-3 flex items-center text-outline hover:text-on-surface-variant transition-colors" onclick="togglePassword()" type="button">
<span class="material-symbols-outlined text-[20px]" id="password-toggle-icon">visibility</span>
</button>
</div>
</div>
<!-- Remember Me & Policy -->
<div class="flex items-center space-x-2 px-1">
<input class="w-4 h-4 text-secondary border-outline-variant rounded focus:ring-secondary cursor-pointer" id="remember" type="checkbox"/>
<label class="font-body-sm text-body-sm text-on-surface-variant cursor-pointer select-none" for="remember">Recordar mi sesión</label>
</div>
<!-- Primary Action -->
<button class="w-full bg-[#10B981] text-white font-label-md text-label-md py-4 rounded-lg shadow-sm hover:bg-[#059669] active:scale-[0.98] transition-all duration-200 mt-md flex items-center justify-center space-x-2" type="submit">
<span>Iniciar Sesión</span>
<span class="material-symbols-outlined text-[18px]">login</span>
</button>
</form>
</div>
<!-- Footer Links -->
<div class="mt-xl text-center">
<p class="font-body-sm text-body-sm text-on-surface-variant">
                ¿No tienes una cuenta? 
                <a class="text-secondary font-label-sm text-label-sm font-semibold hover:underline decoration-2 underline-offset-4" href="#">Contactar Soporte IT</a>
</p>
</div>
<!-- Legal Footer -->
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
</main>
<script>
        // Micro-interactions and UI Logic
        
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

        // Form Submission visual feedback
        const loginForm = document.getElementById('login-form');
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const btn = loginForm.querySelector('button[type="submit"]');
            const originalContent = btn.innerHTML;
            
            // Visual loading state
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Autenticando...</span>
            `;
            btn.classList.add('opacity-80');

            // Simulated delay
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

        // Add subtle mouse movement parallax effect to background blobs
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
</body></html>