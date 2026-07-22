<!DOCTYPE html><html class="light" lang="es"><head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title>SecureCorp Admin - Detalles del Servicio</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "surface-dim": "#cbdbf5",
                    "tertiary-fixed": "#e0e3e5",
                    "surface-container-low": "#eff4ff",
                    "primary": "#000000",
                    "on-primary-fixed": "#131b2e",
                    "surface-container": "#e5eeff",
                    "surface-container-lowest": "#ffffff",
                    "secondary": "#006c49",
                    "secondary-container": "#6cf8bb",
                    "tertiary": "#000000",
                    "on-background": "#0b1c30",
                    "on-secondary-container": "#00714d",
                    "on-secondary-fixed-variant": "#005236",
                    "surface-container-high": "#dce9ff",
                    "surface-container-highest": "#d3e4fe",
                    "primary-fixed": "#dae2fd",
                    "on-tertiary-fixed": "#191c1e",
                    "secondary-fixed-dim": "#4edea3",
                    "on-tertiary-fixed-variant": "#444749",
                    "on-primary-container": "#7c839b",
                    "outline": "#76777d",
                    "error-container": "#ffdad6",
                    "error": "#ba1a1a",
                    "surface-bright": "#f8f9ff",
                    "background": "#f8f9ff",
                    "primary-fixed-dim": "#bec6e0",
                    "on-primary-fixed-variant": "#3f465c",
                    "tertiary-fixed-dim": "#c4c7c9",
                    "on-surface-variant": "#45464d",
                    "on-secondary": "#ffffff",
                    "inverse-surface": "#213145",
                    "on-tertiary-container": "#818486",
                    "on-error-container": "#93000a",
                    "on-primary": "#ffffff",
                    "surface": "#f8f9ff",
                    "on-surface": "#0b1c30",
                    "on-secondary-fixed": "#002113",
                    "primary-container": "#131b2e",
                    "inverse-primary": "#bec6e0",
                    "surface-tint": "#565e74",
                    "on-error": "#ffffff",
                    "secondary-fixed": "#6ffbbe",
                    "inverse-on-surface": "#eaf1ff",
                    "surface-variant": "#d3e4fe",
                    "on-tertiary": "#ffffff",
                    "tertiary-container": "#191c1e",
                    "outline-variant": "#c6c6cd"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "spacing": {
                    "margin-mobile": "16px",
                    "xl": "32px",
                    "2xl": "48px",
                    "sm": "8px",
                    "xs": "4px",
                    "base": "4px",
                    "margin-desktop": "32px",
                    "gutter": "24px",
                    "lg": "24px",
                    "container-max": "1280px",
                    "md": "16px",
                    "3xl": "64px"
            },
            "fontFamily": {
                    "body-lg": ["Inter"],
                    "headline-lg": ["Inter"],
                    "headline-md": ["Inter"],
                    "label-sm": ["Inter"],
                    "body-sm": ["Inter"],
                    "label-md": ["Inter"],
                    "headline-lg-mobile": ["Inter"],
                    "body-md": ["Inter"],
                    "headline-xl": ["Inter"]
            },
            "fontSize": {
                    "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                    "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "700"}],
                    "headline-md": ["24px", {"lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                    "label-sm": ["12px", {"lineHeight": "16px", "fontWeight": "500"}],
                    "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                    "label-md": ["14px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600"}],
                    "headline-lg-mobile": ["28px", {"lineHeight": "36px", "letterSpacing": "-0.01em", "fontWeight": "700"}],
                    "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                    "headline-xl": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}]
            }
          },
        },
      }
    </script>
<style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .form-shadow {
            box-shadow: 0 2px 4px rgba(15, 23, 42, 0.04), 0 8px 16px rgba(15, 23, 42, 0.04);
        }
    </style>
</head>
<body class="bg-surface text-on-surface flex min-h-screen overflow-x-hidden">
<!-- SideNavBar Shell -->
<aside class="hidden md:flex flex-col h-full py-lg px-md space-y-2 bg-surface-container-low border-r border-outline-variant w-64 fixed left-0 top-0 bottom-0 z-30">
<div class="flex items-center gap-3 px-sm mb-lg">
<img alt="SecureCorp Logo" class="w-10 h-10 rounded-lg object-contain" src="https://lh3.googleusercontent.com/aida/AP1WRLtuC5XlBGtOjSi_jmc-EaRB94ZzjKHm8WFGDRDMSacARG7jBOO3lqIWfjA7RcS5Lg6h17o68gbg85xhbmw6IivQk3b_wcExTeR4-uw5lZokalROtGwcG-rF-ylgeUSbN_6DjFtL304n9z6OaOw9Np-rH35VWinnvAuppyOb6KI32VzM0q0-QcXFhY2obJjZeHjjti72UfpmBEJZQYLvn5ZUdrPEFvAWwYYsr51c8vBk6g5T1K0TyL7k_Xed">
<div>
<h2 class="font-headline-md text-label-md font-bold text-primary leading-tight">Enterprise Suite</h2>
<p class="text-on-surface-variant font-label-sm text-[10px]">Administrador de Sistema</p>
</div>
</div>
<nav class="flex-1 space-y-1">
<a class="flex items-center gap-3 px-md py-sm bg-secondary-container text-on-secondary-container rounded-lg font-bold transition-transform active:scale-95" href="#">
<span class="material-symbols-outlined" data-icon="inventory_2">inventory_2</span>
<span class="font-label-md text-label-md">Service Inventory</span>
</a>
<a class="flex items-center gap-3 px-md py-sm text-on-surface-variant hover:bg-surface-container-high transition-all active:scale-95" href="#">
<span class="material-symbols-outlined" data-icon="description">description</span>
<span class="font-label-md text-label-md">Active Contracts</span>
</a>
<a class="flex items-center gap-3 px-md py-sm text-on-surface-variant hover:bg-surface-container-high transition-all active:scale-95" href="#">
<span class="material-symbols-outlined" data-icon="payments">payments</span>
<span class="font-label-md text-label-md">Pricing Models</span>
</a>
<a class="flex items-center gap-3 px-md py-sm text-on-surface-variant hover:bg-surface-container-high transition-all active:scale-95" href="#">
<span class="material-symbols-outlined" data-icon="analytics">analytics</span>
<span class="font-label-md text-label-md">Resource Logs</span>
</a>
<a class="flex items-center gap-3 px-md py-sm text-on-surface-variant hover:bg-surface-container-high transition-all active:scale-95" href="#">
<span class="material-symbols-outlined" data-icon="security">security</span>
<span class="font-label-md text-label-md">Audit Trail</span>
</a>
</nav>
<div class="pt-lg border-t border-outline-variant space-y-4">
<div class="px-md py-sm bg-surface-container-high rounded-lg">
<p class="font-label-sm text-[11px] text-secondary font-bold uppercase tracking-wider">System Status: Healthy</p>
</div>
<a class="flex items-center gap-3 px-md py-sm text-on-surface-variant hover:bg-surface-container-highest transition-all" href="#">
<span class="material-symbols-outlined" data-icon="logout">logout</span>
<span class="font-label-md text-label-md">Sign Out</span>
</a>
</div>
</aside>
<div class="flex-1 flex flex-col md:ml-64 min-w-0">
<!-- TopNavBar Shell -->
<header class="bg-surface-container-lowest border-b border-outline-variant shadow-sm sticky top-0 z-20">
<div class="flex justify-between items-center px-margin-desktop w-full max-w-container-max mx-auto h-16">
<div class="flex items-center gap-8">
<span class="font-headline-md text-headline-md font-bold text-on-surface">SecureCorp Admin</span>
<nav class="hidden lg:flex items-center gap-6">
<a class="font-body-md text-body-md text-on-surface-variant hover:text-secondary transition-colors" href="#">Dashboard</a>
<a class="font-body-md text-body-md text-secondary font-bold border-b-2 border-secondary h-16 flex items-center" href="#">Services</a>
<a class="font-body-md text-body-md text-on-surface-variant hover:text-secondary transition-colors" href="#">Analytics</a>
<a class="font-body-md text-body-md text-on-surface-variant hover:text-secondary transition-colors" href="#">Settings</a>
</nav>
</div>
<div class="flex items-center gap-4">
<div class="hidden sm:flex items-center gap-2 px-md py-1.5 bg-surface-container rounded-full">
<span class="material-symbols-outlined text-on-surface-variant text-sm" data-icon="search">search</span>
<input class="bg-transparent border-none focus:ring-0 text-body-sm w-32 md:w-48 placeholder-on-surface-variant" placeholder="Buscar..." type="text">
</div>
<button class="material-symbols-outlined p-2 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-colors" data-icon="notifications">notifications</button>
<button class="material-symbols-outlined p-2 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-colors" data-icon="help_outline">help_outline</button>
<div class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center border border-outline-variant overflow-hidden">
<img class="w-full h-full object-cover" data-alt="Close-up professional portrait of a business administrator with a friendly expression, wearing corporate attire, soft studio lighting, neutral grey background, high resolution photography style." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAZP3OaV9CexxsuTCUOpVKA3ldZ_nAJHx4q7dP6OUjjVVN8xWkOSmbaFNfL5febEYlOx0DyLYQnmeDV6rsns0HSRVCxiokBROZPS7TVkri69nQ4Ha-fbBttZluDDG56HlHhCL-PNMzSnMEkeXnj-vC0jsrnlRsCMqQzDs4gePure2PA2aE0NO3JrIfHVrdZhrcBsCVKec3enDVayK-Q-nuuYH2f-8WKBNHXHkLj_YvpdQZox9nMU5Hfuw">
</div>
</div>
</div>
</header>
<!-- Main Content Canvas -->
<main class="flex-1 w-full max-w-container-max mx-auto p-margin-mobile md:p-margin-desktop space-y-xl">
<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-end justify-between gap-md">
<div>
<nav class="flex gap-2 text-label-sm text-on-surface-variant mb-2">
<span class="">Servicios</span>
<span class="material-symbols-outlined text-xs leading-none" data-icon="chevron_right">chevron_right</span>
<span class="text-secondary font-bold">Editar Detalles</span>
</nav>
<h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Configuración del Servicio</h1>
<p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">Modifique los parámetros técnicos, financieros y operativos para este módulo de servicio empresarial.</p>
</div>
<div class="flex gap-sm">
<button class="px-lg py-sm rounded-lg border-[1.5px] border-primary text-primary font-bold hover:bg-surface-container-high transition-colors active:scale-95">
                        Cancelar
                    </button>
<button class="px-lg py-sm rounded-lg bg-[#10B981] text-white font-bold shadow-sm hover:brightness-90 transition-all active:scale-95">
                        Guardar Cambios
                    </button>
</div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-lg">
<!-- Left Column: Form Details -->
<div class="lg:col-span-8 space-y-lg">
<!-- General Information Card -->
<section class="bg-surface-container-lowest p-xl rounded-lg border border-outline-variant form-shadow">
<h3 class="font-headline-md text-headline-md mb-xl flex items-center gap-2">
<span class="material-symbols-outlined text-secondary" data-icon="settings_input_component">settings_input_component</span>
                            Información General
                        </h3>
<div class="grid grid-cols-1 md:grid-cols-2 gap-xl">
<!-- Name -->
<div class="flex flex-col gap-xs">
<label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Nombre del Servicio</label>
<input class="w-full h-12 px-md border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all font-body-md" type="text" value="Auditoría de Seguridad Nivel 4">
</div>
<!-- Email -->
<div class="flex flex-col gap-xs">
<label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Correo de Soporte</label>
<input class="w-full h-12 px-md border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all font-body-md" type="email" value="support@securecorp.com">
</div>
<!-- Cost -->
<div class="flex flex-col gap-xs">
<label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Costo por Unidad (MXN)</label>
<div class="relative">
<span class="absolute left-md top-1/2 -translate-y-1/2 text-on-surface-variant font-bold">$
</span>
<input class="w-full h-12 pl-xl pr-md border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all font-body-md" type="number" value="12500">
</div>
</div>
<!-- Duration -->
<div class="flex flex-col gap-xs">
<label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Duración Estimada</label>
<div class="flex gap-2">
<input class="w-2/3 h-12 px-md border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all font-body-md" type="number" value="48">
<select class="w-1/3 h-12 px-sm border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary outline-none font-label-md"><option>Minutos</option><option selected="">Horas</option></select>
</div>
</div>
</div>
<!-- Description -->
<div class="mt-xl flex flex-col gap-xs">
<label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Descripción del Servicio</label>
<textarea class="w-full p-md border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all font-body-md" placeholder="Describa el alcance detallado del servicio..." rows="6">Este servicio de auditoría integral proporciona una evaluación exhaustiva de los activos digitales de la corporación. Incluye pruebas de penetración, análisis de vulnerabilidades en tiempo real y un informe detallado de remediación estratégica compatible con normativas ISO 27001.</textarea>
</div>
</section>
<!-- Multi-select Options Table -->
<section class="bg-surface-container-lowest rounded-lg border border-outline-variant form-shadow overflow-hidden">
<div class="p-xl border-b border-outline-variant">
<h3 class="font-headline-md text-headline-md flex items-center gap-2">
<span class="material-symbols-outlined text-secondary" data-icon="checklist">checklist</span>
                                Características y Complementos
                            </h3>
<p class="text-body-sm text-on-surface-variant mt-1">Seleccione las funcionalidades activas para este nivel de servicio.</p>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead class="bg-surface-container-low">
<tr>
<th class="px-xl py-md font-label-md text-on-surface-variant uppercase tracking-widest text-[11px] w-16">
<input class="w-5 h-5 rounded border-outline-variant text-secondary focus:ring-secondary" type="checkbox">
</th>
<th class="px-xl py-md font-label-md text-on-surface-variant uppercase tracking-widest text-[11px]">Funcionalidad</th>
<th class="px-xl py-md font-label-md text-on-surface-variant uppercase tracking-widest text-[11px]">Tipo</th>
<th class="px-xl py-md font-label-md text-on-surface-variant uppercase tracking-widest text-[11px]">Estado</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant">
<tr class="hover:bg-surface-container transition-colors">
<td class="px-xl py-md">
<input checked="" class="w-5 h-5 rounded border-outline-variant text-secondary focus:ring-secondary cursor-pointer" type="checkbox">
</td>
<td class="px-xl py-md">
<div class="font-bold text-on-surface">Escaneo de Vulnerabilidades 24/7</div>
<div class="text-xs text-on-surface-variant">Monitoreo automatizado continuo</div>
</td>
<td class="px-xl py-md font-body-sm text-on-surface-variant italic">Core Feature</td>
<td class="px-xl py-md">
<span class="px-2 py-1 rounded bg-secondary-container text-on-secondary-container font-label-sm text-[10px] uppercase">Activo</span>
</td>
</tr>
<tr class="hover:bg-surface-container transition-colors">
<td class="px-xl py-md">
<input checked="" class="w-5 h-5 rounded border-outline-variant text-secondary focus:ring-secondary cursor-pointer" type="checkbox">
</td>
<td class="px-xl py-md">
<div class="font-bold text-on-surface">Soporte Técnico Premium</div>
<div class="text-xs text-on-surface-variant">Respuesta en menos de 2 horas</div>
</td>
<td class="px-xl py-md font-body-sm text-on-surface-variant italic">Add-on</td>
<td class="px-xl py-md">
<span class="px-2 py-1 rounded bg-secondary-container text-on-secondary-container font-label-sm text-[10px] uppercase">Activo</span>
</td>
</tr>
<tr class="hover:bg-surface-container transition-colors">
<td class="px-xl py-md">
<input class="w-5 h-5 rounded border-outline-variant text-secondary focus:ring-secondary cursor-pointer" type="checkbox">
</td>
<td class="px-xl py-md">
<div class="font-bold text-on-surface">Backup en Nube Descentralizada</div>
<div class="text-xs text-on-surface-variant">Almacenamiento redundante global</div>
</td>
<td class="px-xl py-md font-body-sm text-on-surface-variant italic">Advanced</td>
<td class="px-xl py-md">
<span class="px-2 py-1 rounded bg-surface-container-high text-on-surface-variant font-label-sm text-[10px] uppercase">Opcional</span>
</td>
</tr>
</tbody>
</table>
</div>
</section>
</div>
<!-- Right Column: Visuals & Actions -->
<div class="lg:col-span-4 space-y-lg">
<!-- Image Upload/Preview Card -->
<section class="bg-surface-container-lowest p-xl rounded-lg border border-outline-variant form-shadow">
<h3 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-md">Imagen del Servicio</h3>
<div class="group relative rounded-xl overflow-hidden aspect-video bg-surface-container-low border-2 border-dashed border-outline-variant flex flex-col items-center justify-center cursor-pointer hover:border-secondary transition-all">
<img class="absolute inset-0 w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-40" data-alt="A clean, minimalist 3D isometric illustration of a digital shield icon with glowing blue circuitry lines on a high-tech server rack background. The lighting is sophisticated and professional, reflecting a corporate security theme with deep navy and emerald green accents. High contrast, sharp details, corporate digital art style." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAAHdC0J_3istOt_1DwuKbTwJYcYxPm-GytUHgcq8R5P58fuLjBg_Hxb6TbQiCtVKoSjyrtZFnxVIogC3Uc0PkfYF9s2bDbOhT48QDQSJE72Sga5HXFvnw3B7aRDEnS9wBQFjUxPnB_c-BUWK2QfWJGXZdWvtQjLKVCXSMmgh4eGYNPxrjcUOXv40zdgb1mgjkrZlf4agpEHbj5bXJudzj5ZLY6JEizLTK54IKEZQs1jfaJdBDkB2GsnQ">
<div class="relative z-10 flex flex-col items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
<span class="material-symbols-outlined text-4xl text-secondary" data-icon="cloud_upload">cloud_upload</span>
<p class="font-label-md text-on-surface font-bold">Cambiar Imagen</p>
<p class="text-[10px] text-on-surface-variant">JPG, PNG hasta 5MB</p>
</div>
</div>
<div class="mt-xl pt-xl border-t border-outline-variant">
<div class="flex items-center gap-4 mb-xl">
<div class="w-12 h-12 rounded-lg bg-surface-container-high flex items-center justify-center p-2">
<img alt="Corporate Logo Small" class="w-full h-full object-contain" src="https://lh3.googleusercontent.com/aida/AP1WRLtuC5XlBGtOjSi_jmc-EaRB94ZzjKHm8WFGDRDMSacARG7jBOO3lqIWfjA7RcS5Lg6h17o68gbg85xhbmw6IivQk3b_wcExTeR4-uw5lZokalROtGwcG-rF-ylgeUSbN_6DjFtL304n9z6OaOw9Np-rH35VWinnvAuppyOb6KI32VzM0q0-QcXFhY2obJjZeHjjti72UfpmBEJZQYLvn5ZUdrPEFvAWwYYsr51c8vBk6g5T1K0TyL7k_Xed">
</div>
<div>
<p class="font-label-sm text-secondary font-bold">Identidad Visual</p>
<p class="text-body-sm text-on-surface-variant leading-tight">Configurado bajo la marca SecureCorp Nexus</p>
</div>
</div>
<button class="w-full py-md rounded-lg border border-outline-variant text-on-surface-variant font-bold flex items-center justify-center gap-2 hover:bg-surface-container-high transition-all">
<span class="material-symbols-outlined text-sm" data-icon="visibility">visibility</span>
                                Previsualizar Ficha
                            </button>
</div>
</section>
<!-- Quick Status / Info -->
<section class="bg-primary-container p-xl rounded-lg text-white space-y-md">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-secondary-fixed-dim" data-icon="info">info</span>
<h4 class="font-label-md uppercase tracking-widest text-[11px]">Resumen de Publicación</h4>
</div>
<ul class="space-y-3 font-body-sm opacity-90">
<li class="flex justify-between border-b border-white/10 pb-2">
<span class="">Última modificación:</span>
<span class="font-bold">Hace 2 horas</span>
</li>
<li class="flex justify-between border-b border-white/10 pb-2">
<span class="">Publicado por:</span>
<span class="font-bold">Admin_Alpha</span>
</li>
<li class="flex justify-between">
<span class="">Visibilidad:</span>
<span class="text-secondary-fixed-dim font-bold flex items-center gap-1">
<span class="w-2 h-2 rounded-full bg-secondary-fixed-dim"></span>
                                    Enterprise Only
                                </span>
</li>
</ul>
</section>
</div>
</div>
</main>
<!-- Footer Shell -->
<footer class="bg-surface-dim border-t border-outline-variant mt-auto">
<div class="flex flex-col md:flex-row justify-between items-center px-margin-desktop py-md w-full max-w-container-max mx-auto gap-4">
<div class="flex items-center gap-4">
<span class="font-label-md text-label-md font-bold text-primary">SecureCorp</span>
<p class="font-label-sm text-label-sm text-on-surface-variant">© 2024 SecureCorp Enterprise Solutions. All rights reserved.</p>
</div>
<nav class="flex gap-6">
<a class="font-label-sm text-label-sm text-on-surface-variant hover:text-secondary transition-colors" href="#">Privacy Policy</a>
<a class="font-label-sm text-label-sm text-on-surface-variant hover:text-secondary transition-colors" href="#">Terms of Service</a>
<a class="font-label-sm text-label-sm text-on-surface-variant hover:text-secondary transition-colors" href="#">API Documentation</a>
<a class="font-label-sm text-label-sm text-on-surface-variant hover:text-secondary transition-colors" href="#">Support</a>
</nav>
</div>
</footer>
</div>
<!-- Mobile Navigation (Bottom Bar) -->
<nav class="md:hidden fixed bottom-0 left-0 right-0 h-16 bg-surface-container-lowest border-t border-outline-variant flex items-center justify-around px-md z-50">
<button class="flex flex-col items-center gap-1 text-on-surface-variant">
<span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
<span class="text-[10px] font-medium">Panel</span>
</button>
<button class="flex flex-col items-center gap-1 text-secondary font-bold">
<span class="material-symbols-outlined" data-icon="inventory_2" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
<span class="text-[10px]">Servicios</span>
</button>
<button class="flex flex-col items-center gap-1 text-on-surface-variant">
<span class="material-symbols-outlined" data-icon="add_circle">add_circle</span>
<span class="text-[10px] font-medium">Nuevo</span>
</button>
<button class="flex flex-col items-center gap-1 text-on-surface-variant">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
<span class="text-[10px] font-medium">Config</span>
</button>
</nav>
<script>
        // Micro-interactions
        document.querySelectorAll('input, select, textarea').forEach(el => {
            el.addEventListener('focus', () => {
                el.parentElement.classList.add('scale-[1.01]');
            });
            el.addEventListener('blur', () => {
                el.parentElement.classList.remove('scale-[1.01]');
            });
        });

        // Simple checkbox group logic
        const masterCheckbox = document.querySelector('thead input[type="checkbox"]');
        const itemCheckboxes = document.querySelectorAll('tbody input[type="checkbox"]');
        
        masterCheckbox?.addEventListener('change', (e) => {
            itemCheckboxes.forEach(cb => cb.checked = e.target.checked);
        });
    </script>


</body></html>