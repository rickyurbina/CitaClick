<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Login | SecureCorp</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
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
            font-family: 'Inter', sans-serif;
            background-color: #f8f9ff;
            overflow-x: hidden;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .login-card {
            box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.04), 0 2px 4px -1px rgba(15, 23, 42, 0.02);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .focus-ring:focus-within {
            border-color: #006c49;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
        }
        /* Custom animated background elements */
        .bg-mesh {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            background: radial-gradient(circle at 0% 0%, #eff4ff 0%, transparent 50%),
                        radial-gradient(circle at 100% 100%, #dce9ff 0%, transparent 50%);
            opacity: 0.6;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-margin-mobile md:p-margin-desktop bg-surface">
<!-- Subtle atmospheric background -->
<div class="bg-mesh"></div>
<main class="w-full max-w-[420px] animate-in fade-in slide-in-from-bottom-4 duration-700">
<!-- Logo Section -->
<div class="flex flex-col items-center mb-xl">
<div class="w-[250px] h-[250px] flex items-center justify-center bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/30 p-md mb-lg">
<img alt="SecureCorp Logo" class="w-full h-full object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDcv7U0puuCB9jsR5bvpFuWCfPzMEIbnBNKUUr7Fp3bAxpvfXQR9ugEGJ_JEsVPS2dsj4tyyFMJy-clYQI5RX5HKPXUz0TR5oSUTHXA0i0N0Rh_0ukHkusVq5p8NfLlKw0-E_9weq4_tWH4q4FLhDMldt7MEnW6BDnu_5d77P_5WfCzF4JyEdboUdkCaLo3f2eP3VZDb29oAV_6kfRYXXNbnEmPlprCq6KYXRnUiBlPmxbOJOMSbVInVA"/>
</div>
<h1 class="font-headline-lg-mobile text-headline-lg-mobile md:font-headline-lg md:text-headline-lg text-primary text-center">
                Bienvenido a SecureCorp
            </h1>
<p class="font-body-md text-body-md text-on-surface-variant text-center mt-xs">
                Ingresa tus credenciales para continuar
            </p>
</div>
<!-- Login Form Container -->
<div class="login-card bg-surface-container-lowest border border-outline-variant p-xl rounded-xl">
<form class="space-y-lg" id="loginForm">
<!-- Phone Input Field -->
<div class="space-y-xs">
<label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider" for="phone">
                        Número de Teléfono
                    </label>
<div class="focus-ring flex items-center bg-surface border border-outline-variant rounded-lg transition-all duration-200">
<div class="px-md flex items-center gap-sm border-r border-outline-variant bg-surface-container-low rounded-l-lg h-12">
<span class="material-symbols-outlined text-on-surface-variant" style="font-size: 20px;">call</span>
<span class="font-label-md text-label-md text-on-surface">+52</span>
</div>
<input class="w-full h-12 px-md bg-transparent border-none focus:ring-0 font-body-md text-body-md text-on-surface placeholder:text-outline" id="phone" name="phone" placeholder="55 1234 5678" required="" type="tel"/>
</div>
</div>
<!-- Primary CTA -->
<button class="w-full h-14 bg-secondary text-on-secondary font-label-md text-label-md rounded-lg shadow-md hover:bg-[#005a3d] active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-sm" type="submit">
                    Continuar
                    <span class="material-symbols-outlined" style="font-size: 20px;">arrow_forward</span>
</button>
</form>
<!-- Footer Links -->
<div class="mt-xl pt-lg border-t border-outline-variant text-center">
<p class="font-body-sm text-body-sm text-on-surface-variant">
                    ¿Problemas para ingresar? 
                    <a class="text-secondary font-label-sm hover:underline ml-xs" href="#">Contactar Soporte</a>
</p>
</div>
</div>
<!-- Secondary Legal/Info Section -->
<div class="mt-xl flex flex-wrap justify-center gap-md">
<a class="font-label-sm text-label-sm text-outline hover:text-on-surface-variant transition-colors" href="#">Términos y Condiciones</a>
<span class="text-outline-variant">•</span>
<a class="font-label-sm text-label-sm text-outline hover:text-on-surface-variant transition-colors" href="#">Privacidad</a>
</div>
</main>
<script>
        // Simple form interaction handling
        const loginForm = document.getElementById('loginForm');
        const phoneInput = document.getElementById('phone');

        // Format phone input (very simple version for demo)
        phoneInput.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 10) value = value.slice(0, 10);
            e.target.value = value;
        });

        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const submitBtn = e.target.querySelector('button');
            const originalContent = submitBtn.innerHTML;
            
            // Visual feedback for interaction
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Procesando...
            `;

            // Mock redirect/success
            setTimeout(() => {
                alert('Iniciando sesión con el número: +52 ' + phoneInput.value);
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalContent;
            }, 1500);
        });

        // Atmospheric mouse track for the background mesh (Desktop only)
        if (window.innerWidth > 768) {
            document.addEventListener('mousemove', (e) => {
                const mesh = document.querySelector('.bg-mesh');
                const x = (e.clientX / window.innerWidth) * 20;
                const y = (e.clientY / window.innerHeight) * 20;
                mesh.style.background = `radial-gradient(circle at ${x}% ${y}%, #eff4ff 0%, transparent 50%),
                                         radial-gradient(circle at ${100 - x}% ${100 - y}%, #dce9ff 0%, transparent 50%)`;
            });
        }
    </script>
</body></html>