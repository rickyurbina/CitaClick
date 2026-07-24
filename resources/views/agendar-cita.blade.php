<!DOCTYPE html><html class="light" lang="es"><head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title>SecureCorp - Panel Unificado</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "surface-container-highest": "#d3e4fe",
                    "on-primary": "#ffffff",
                    "surface-tint": "#565e74",
                    "surface-container-high": "#dce9ff",
                    "on-secondary-container": "#00714d",
                    "inverse-on-surface": "#eaf1ff",
                    "surface-container-low": "#eff4ff",
                    "primary-fixed": "#dae2fd",
                    "primary-container": "#131b2e",
                    "primary": "#000000",
                    "on-surface": "#0b1c30",
                    "on-secondary": "#ffffff",
                    "tertiary-fixed": "#e0e3e5",
                    "inverse-surface": "#213145",
                    "inverse-primary": "#bec6e0",
                    "on-tertiary": "#ffffff",
                    "on-secondary-fixed-variant": "#005236",
                    "tertiary-fixed-dim": "#c4c7c9",
                    "tertiary": "#000000",
                    "surface": "#f8f9ff",
                    "on-error-container": "#93000a",
                    "secondary-fixed-dim": "#4edea3",
                    "on-background": "#0b1c30",
                    "outline-variant": "#c6c6cd",
                    "surface-container": "#e5eeff",
                    "surface-dim": "#cbdbf5",
                    "secondary": "#006c49",
                    "on-tertiary-fixed": "#191c1e",
                    "on-primary-fixed-variant": "#3f465c",
                    "background": "#f8f9ff",
                    "error-container": "#ffdad6",
                    "tertiary-container": "#191c1e",
                    "on-secondary-fixed": "#002113",
                    "on-surface-variant": "#45464d",
                    "on-primary-container": "#7c839b",
                    "secondary-fixed": "#6ffbbe",
                    "on-tertiary-fixed-variant": "#444749",
                    "outline": "#76777d",
                    "surface-bright": "#f8f9ff",
                    "secondary-container": "#6cf8bb",
                    "on-primary-fixed": "#131b2e",
                    "surface-container-lowest": "#ffffff",
                    "surface-variant": "#d3e4fe",
                    "on-tertiary-container": "#818486",
                    "error": "#ba1a1a",
                    "primary-fixed-dim": "#bec6e0",
                    "on-error": "#ffffff"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "spacing": {
                    "container-max": "1280px",
                    "sm": "8px",
                    "base": "4px",
                    "xl": "32px",
                    "2xl": "48px",
                    "3xl": "64px",
                    "margin-mobile": "16px",
                    "margin-desktop": "32px",
                    "lg": "24px",
                    "gutter": "24px",
                    "md": "16px",
                    "xs": "4px"
            },
            "fontFamily": {
                    "headline-md": ["Inter"],
                    "headline-lg-mobile": ["Inter"],
                    "headline-lg": ["Inter"],
                    "body-sm": ["Inter"],
                    "headline-xl": ["Inter"],
                    "label-md": ["Inter"],
                    "body-md": ["Inter"],
                    "body-lg": ["Inter"],
                    "label-sm": ["Inter"]
            },
            "fontSize": {
                    "headline-md": ["24px", {"lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                    "headline-lg-mobile": ["28px", {"lineHeight": "36px", "letterSpacing": "-0.01em", "fontWeight": "700"}],
                    "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "700"}],
                    "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                    "headline-xl": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                    "label-md": ["14px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600"}],
                    "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                    "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                    "label-sm": ["12px", {"lineHeight": "16px", "fontWeight": "500"}]
            }
          },
        },
      }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            line-height: 1;
            text-transform: none;
            letter-spacing: normal;
            word-wrap: normal;
            white-space: nowrap;
            direction: ltr;
        }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 24px;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.5);
            box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.04);
        }
    </style>
</head>
<body class="bg-background text-on-background min-h-screen">
<!-- TopAppBar -->
<header class="bg-surface fixed top-0 left-0 md:left-64 right-0 z-30 border-b border-outline-variant shadow-sm h-16 flex justify-between items-center px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
<div class="flex items-center gap-4">
<span class="md:hidden material-symbols-outlined cursor-pointer">menu</span>
<h1 class="font-headline-md text-headline-md text-primary">Catálogo y Agendamiento</h1>
</div>
<div class="flex items-center gap-md">
<button class="p-2 rounded-full hover:bg-surface-container-low transition-colors active:opacity-80">
<span class="material-symbols-outlined text-on-surface-variant">notifications</span>
</button>
<button class="p-2 rounded-full hover:bg-surface-container-low transition-colors active:opacity-80">
<span class="material-symbols-outlined text-on-surface-variant">help_outline</span>
</button>
<div class="w-8 h-8 rounded-full overflow-hidden border border-outline-variant">
<img class="w-full h-full object-cover" data-alt="Close-up professional corporate headshot of a diverse male executive in a sharp navy blue suit, set against a blurred high-end office background. The lighting is sophisticated and bright, following the modern professional aesthetic of SecureCorp, emphasizing trustworthiness and competence." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCRr4E45wLLgOhZUNlo_LCTaqOwdEWYYsoLucxuccQ9HeOL4y0Zs4Z5XBKW8No8o1xYNFGUZLyx-Znx-zEyFmo1xRSdsj6NKQ9CLuOI71CQTXEJ5tke9J3zzyzFGMlTyjMByaLBC1v9Feifz9uTSQkG81D6F1xoqUQ1nI_UtMxp8s-rtB_PdAEDN1g6Dv7h8lPALi5zEyuhVNX0-HhGovkBToIjkdFpbFStit0u3_zYP-LtjgdPaOcUlA">
</div>
</div>
</header>
<!-- SideNavBar -->
<aside class="fixed left-0 top-0 h-full w-64 hidden md:flex flex-col bg-surface border-r border-outline-variant z-40 p-md">
<div class="mb-xl px-2 flex items-center gap-3">
<img alt="SecureCorp Logo" class="w-10 h-10" src="https://lh3.googleusercontent.com/aida/AP1WRLu2jOA2GshY9rTdvu6JMUaDEVz6yqZBnEdR0NNlu7fuCRxycdm-KvXMvvJEUSW8YZQv3xy-ZyZbsMDDHBBeu9W1dTV7qHoBzoNny4T44AAWK4D_i2Rgg2z947T1tCGzAV_G8rDc5lAcE2JMz3RaFw3YySZiTQ26MtT47HLjHTy47SI6DLl61brLryZQmWGRDOISTc5cquBjzvyWaSa9xN-lBTveEhE5onEZckQfCRkalGdcmcjZOcMa_wYz">
<div>
<div class="font-headline-md text-headline-md font-bold text-primary">SecureCorp</div>
<div class="text-label-sm text-on-surface-variant opacity-70 uppercase tracking-wider">Enterprise Tier</div>
</div>
</div>
<nav class="flex-1 space-y-1">
<div class="flex items-center gap-3 p-3 transition-all duration-200 ease-in-out cursor-pointer hover:bg-surface-container-high rounded-lg text-on-surface-variant font-label-md text-label-md">
<span class="material-symbols-outlined">grid_view</span>
<span class="">Catalog</span>
</div>
<div class="flex items-center gap-3 p-3 transition-all duration-200 ease-in-out cursor-pointer bg-secondary-container text-on-secondary-container rounded-lg font-label-md text-label-md">
<span class="material-symbols-outlined">calendar_today</span>
<span class="">Schedule</span>
</div>
<div class="flex items-center gap-3 p-3 transition-all duration-200 ease-in-out cursor-pointer hover:bg-surface-container-high rounded-lg text-on-surface-variant font-label-md text-label-md">
<span class="material-symbols-outlined">receipt_long</span>
<span class="">Orders</span>
</div>
<div class="flex items-center gap-3 p-3 transition-all duration-200 ease-in-out cursor-pointer hover:bg-surface-container-high rounded-lg text-on-surface-variant font-label-md text-label-md">
<span class="material-symbols-outlined">settings</span>
<span class="">Settings</span>
</div>
</nav>
<div class="mt-auto space-y-1 border-t border-outline-variant pt-md">
<button class="w-full bg-secondary text-on-secondary py-3 px-4 rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 mb-md hover:brightness-110 transition-all">
<span class="material-symbols-outlined text-lg">add</span>
                New Appointment
            </button>
<div class="flex items-center gap-3 p-3 transition-all duration-200 ease-in-out cursor-pointer hover:bg-surface-container-high rounded-lg text-on-surface-variant font-label-md text-label-md">
<span class="material-symbols-outlined">help</span>
<span class="">Help</span>
</div>
<div class="flex items-center gap-3 p-3 transition-all duration-200 ease-in-out cursor-pointer hover:bg-surface-container-high rounded-lg text-on-surface-variant font-label-md text-label-md">
<span class="material-symbols-outlined text-logout">logout</span>
<span class="">Sign Out</span>
</div>
</div>
</aside>
<!-- Main Content -->
<main class="md:ml-64 pt-16 pb-20 md:pb-8">
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-lg">
<!-- Section 1: Catálogo de Soluciones -->
<section class="mb-2xl">
<div class="flex items-center justify-between mb-lg">
<h2 class="font-headline-lg text-headline-lg text-primary">Catálogo de Soluciones</h2>
<button class="text-secondary font-label-md text-label-md flex items-center gap-1 hover:underline">
                        Ver todo <span class="material-symbols-outlined text-sm">arrow_forward</span>
</button>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-lg">
<!-- Product Card 1 -->
<div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col h-full">
<div class="h-48 overflow-hidden relative">
<img class="w-full h-full object-cover" data-alt="A clean, minimalist product photography of a high-tech corporate security device. The object has a matte charcoal finish with metallic emerald accents, reflecting the SecureCorp brand identity. It is set against a soft, bright studio background with natural daylight and subtle ambient shadows, creating a look of premium enterprise hardware." src="https://lh3.googleusercontent.com/aida-public/AB6AXuB8hlBuIICJRT9MZfcsz3N7vjrwoAY4zFwbD05A__dauRvQP4jX_NE7fe1Z40l__25nDLfu6Y1NxW2UBgak7JgDIO9H718FkyWByuSqMIFCVdlyV-FgThIwY9R6Hgk1UzcicQYx4PCe913IiDZQDuXIXf19Jp8kYLuJ-asml4-FwPf9Bp8jQ19Ca5y0lANNRE1dU3maLw3myULSqjKW91ilnwo5_GtU0WAvLBvGUOxiYGSWDqw8Z1kBvg">
<span class="absolute top-2 right-2 bg-secondary-container text-on-secondary-container px-2 py-1 rounded text-[10px] font-bold uppercase tracking-widest">Nuevo</span>
</div>
<div class="p-md flex flex-col flex-1">
<h3 class="font-headline-md text-[18px] text-primary mb-xs">Sistema Sentinel v4</h3>
<div class="mt-auto">
<div class="text-headline-md text-secondary font-bold mb-md">$2,499.00</div>
<div class="grid grid-cols-2 gap-sm">
<button class="border-[1.5px] border-primary text-primary py-2 rounded-lg font-label-sm text-[11px] hover:bg-surface-container-low transition-colors uppercase">Detalles</button>
<button class="bg-secondary text-on-secondary py-2 rounded-lg font-label-sm text-[11px] hover:brightness-110 transition-all uppercase">Cotizar</button>
</div>
</div>
</div>
</div>
<!-- Product Card 2 -->
<div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col h-full">
<div class="h-48 overflow-hidden">
<img class="w-full h-full object-cover" data-alt="Modern network infrastructure component, a sleek metallic router with glowing emerald indicator lights. The product is shot in a high-contrast style with sharp focus and professional studio lighting. The aesthetic is corporate and trustworthy, using a palette of deep navy and white to maintain cohesion with the SecureCorp design system." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDRvHjbC36qSUIitDPAKNN1GyGSRHcJ_k8eP5mK52kDB06z7UEqW1gWShDHA1-3FlJSCVKa-KfYZlB5xOR31JScX3LJRK8v1Eh1uZ8b-1iKG8wgSvwmyTgVfTbkpZRijIVzjtDv9q69H___Z91ZPLkaW7NJVgOgONa4Z0QDiQoeSjVt5_xpYbCt7EmCaM2p6p6w4lvoWQB4uK8317zWXkV3sFzsZ9e7r9BVa-4mv7ejKZb677Vm-8lJYA">
</div>
<div class="p-md flex flex-col flex-1">
<h3 class="font-headline-md text-[18px] text-primary mb-xs">Módulo Quantum Sync</h3>
<div class="mt-auto">
<div class="text-headline-md text-secondary font-bold mb-md">$1,250.00</div>
<div class="grid grid-cols-2 gap-sm">
<button class="border-[1.5px] border-primary text-primary py-2 rounded-lg font-label-sm text-[11px] hover:bg-surface-container-low transition-colors uppercase">Detalles</button>
<button class="bg-secondary text-on-secondary py-2 rounded-lg font-label-sm text-[11px] hover:brightness-110 transition-all uppercase">Cotizar</button>
</div>
</div>
</div>
</div>
<!-- Product Card 3 -->
<div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col h-full">
<div class="h-48 overflow-hidden">
<img class="w-full h-full object-cover" data-alt="An enterprise-grade smart lock interface, featuring a brushed aluminum surface and a minimalist digital display. High-end lighting creates soft reflections on the metallic surface. The background is a clean, bright corporate lobby, reinforcing the professional application of the product within the SecureCorp ecosystem." src="https://lh3.googleusercontent.com/aida-public/AB6AXuA0_U_jNYwLSpQlYmmd1vwLPjwBqHhz7BD6xwnH6f3yWbOAmr-gZARIMbFX8yigtNvz-r_3QCMejnZHVSLWMqcDA_8QxQdth1oDL3gxgHcLu34d-vZsE1L7qj7XSVdlZELzuDqrRMiZIOGZdVahEbjkOGztUMG7aTD6o6rZcYN60i6jDsM-pmOy-s4JdeLzKHVYUOJCaHF8TdZz4nhdSw-oHq1r6mZH39hM9X7AIl9cziMJP0LYM7hjBg">
</div>
<div class="p-md flex flex-col flex-1">
<h3 class="font-headline-md text-[18px] text-primary mb-xs">Acceso Biométrico X1</h3>
<div class="mt-auto">
<div class="text-headline-md text-secondary font-bold mb-md">$890.00</div>
<div class="grid grid-cols-2 gap-sm">
<button class="border-[1.5px] border-primary text-primary py-2 rounded-lg font-label-sm text-[11px] hover:bg-surface-container-low transition-colors uppercase">Detalles</button>
<button class="bg-secondary text-on-secondary py-2 rounded-lg font-label-sm text-[11px] hover:brightness-110 transition-all uppercase">Cotizar</button>
</div>
</div>
</div>
</div>
<!-- Product Card 4 -->
<div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col h-full">
<div class="h-48 overflow-hidden">
<img class="w-full h-full object-cover" data-alt="Professional thermal imaging camera designed for corporate environments. The product features a sleek, aerodynamic design in matte black with emerald green detailing. The image is captured from a dynamic angle with shallow depth of field, set against a minimalist white studio background. Professional corporate lighting highlights the product's high-end build quality." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDeGh2PgSKLvJaavbU3guDfmOkv_F-1DbXgyo5IcGlfoeAO5g22eWy3bM3KESAQnYNyErY910_MaXH_v8VfpP2HlIv_yw1shk9pj4N2-ZvCAg5suIj1fiLZb0NlsjhwUTa7Y7cX0mF8zJjHR_2ELaqBB_OoTaJef6zIVERZw-BqPCFDFDZZZIF9GblW7PcsZronXcK6ZtPkRC0K9EyraKdo1RPxoPt9p9ABIDoyexRwOFVVEx8C6qhr7g">
</div>
<div class="p-md flex flex-col flex-1">
<h3 class="font-headline-md text-[18px] text-primary mb-xs">Visión Térmica Pro</h3>
<div class="mt-auto">
<div class="text-headline-md text-secondary font-bold mb-md">$3,100.00</div>
<div class="grid grid-cols-2 gap-sm">
<button class="border-[1.5px] border-primary text-primary py-2 rounded-lg font-label-sm text-[11px] hover:bg-surface-container-low transition-colors uppercase">Detalles</button>
<button class="bg-secondary text-on-secondary py-2 rounded-lg font-label-sm text-[11px] hover:brightness-110 transition-all uppercase">Cotizar</button>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- Section 2: Agendamiento de Servicios -->
<section class="border-t border-outline-variant pt-2xl">
<div class="mb-lg">
<h2 class="font-headline-lg text-headline-lg text-primary">Agendamiento de Servicios</h2>
<p class="text-on-surface-variant font-body-md text-body-md mt-xs">Seleccione su ventana de prioridad y horario para la instalación.</p>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-xl">
<!-- Date Selection & Priority Window -->
<div class="lg:col-span-2 space-y-xl">
<!-- Priority Window (7-day horizontal selector) -->
<div class="glass-card rounded-xl p-md">
<div class="flex items-center justify-between mb-md px-2">
<h3 class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant">Ventana de Prioridad</h3>
<div class="flex gap-2">
<button class="p-1 rounded-full hover:bg-surface-container-low active:scale-95 transition-transform"><span class="material-symbols-outlined">chevron_left</span></button>
<button class="p-1 rounded-full hover:bg-surface-container-low active:scale-95 transition-transform"><span class="material-symbols-outlined">chevron_right</span></button>
</div>
</div>
<div class="flex justify-between items-center overflow-x-auto hide-scrollbar gap-sm px-2">
<!-- Days -->
<button class="flex-shrink-0 w-16 h-20 rounded-xl flex flex-col items-center justify-center border border-outline-variant hover:bg-surface-container-low transition-all">
<span class="text-label-sm font-medium opacity-60">LUN</span>
<span class="text-headline-md font-bold">12</span>
</button>
<button class="flex-shrink-0 w-16 h-20 rounded-xl flex flex-col items-center justify-center border-2 border-secondary bg-secondary-container text-on-secondary-container shadow-md transition-all">
<span class="text-label-sm font-bold uppercase">MAR</span>
<span class="text-headline-md font-extrabold">13</span>
</button>
<button class="flex-shrink-0 w-16 h-20 rounded-xl flex flex-col items-center justify-center border border-outline-variant hover:bg-surface-container-low transition-all">
<span class="text-label-sm font-medium opacity-60">MIE</span>
<span class="text-headline-md font-bold">14</span>
</button>
<button class="flex-shrink-0 w-16 h-20 rounded-xl flex flex-col items-center justify-center border border-outline-variant hover:bg-surface-container-low transition-all">
<span class="text-label-sm font-medium opacity-60">JUE</span>
<span class="text-headline-md font-bold">15</span>
</button>
<button class="flex-shrink-0 w-16 h-20 rounded-xl flex flex-col items-center justify-center border border-outline-variant hover:bg-surface-container-low transition-all">
<span class="text-label-sm font-medium opacity-60">VIE</span>
<span class="text-headline-md font-bold">16</span>
</button>
<button class="flex-shrink-0 w-16 h-20 rounded-xl flex flex-col items-center justify-center border border-outline-variant hover:bg-surface-container-low transition-all opacity-40 cursor-not-allowed">
<span class="text-label-sm font-medium opacity-60">SAB</span>
<span class="text-headline-md font-bold">17</span>
</button>
<button class="flex-shrink-0 w-16 h-20 rounded-xl flex flex-col items-center justify-center border border-outline-variant hover:bg-surface-container-low transition-all opacity-40 cursor-not-allowed">
<span class="text-label-sm font-medium opacity-60">DOM</span>
<span class="text-headline-md font-bold">18</span>
</button>
</div>
</div>
<!-- Available Time Slots -->
<div class="glass-card rounded-xl p-md">
<h3 class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant mb-md px-2">Horarios Disponibles</h3>
<div class="grid grid-cols-2 sm:grid-cols-4 gap-md px-2">
<button class="py-3 px-2 rounded-lg border border-outline-variant text-body-sm font-medium hover:border-secondary hover:text-secondary transition-all active:bg-secondary-container">08:00 AM</button>
<button class="py-3 px-2 rounded-lg border border-outline-variant text-body-sm font-medium hover:border-secondary hover:text-secondary transition-all active:bg-secondary-container">09:30 AM</button>
<button class="py-3 px-2 rounded-lg border-2 border-secondary bg-secondary-container text-on-secondary-container text-body-sm font-bold shadow-sm">11:00 AM</button>
<button class="py-3 px-2 rounded-lg border border-outline-variant text-body-sm font-medium hover:border-secondary hover:text-secondary transition-all active:bg-secondary-container">12:30 PM</button>
<button class="py-3 px-2 rounded-lg border border-outline-variant text-body-sm font-medium hover:border-secondary hover:text-secondary transition-all active:bg-secondary-container">02:00 PM</button>
<button class="py-3 px-2 rounded-lg border border-outline-variant text-body-sm font-medium hover:border-secondary hover:text-secondary transition-all active:bg-secondary-container">03:30 PM</button>
<button class="py-3 px-2 rounded-lg border border-outline-variant text-body-sm font-medium hover:border-secondary hover:text-secondary transition-all active:bg-secondary-container">05:00 PM</button>
<button class="py-3 px-2 rounded-lg border border-outline-variant text-body-sm font-medium opacity-30 cursor-not-allowed">06:30 PM</button>
</div>
</div>
</div>
<!-- Future Planning & Summary -->
<div class="space-y-xl">
<!-- Future Planning (Date Picker) -->
<div class="glass-card rounded-xl p-md">
<h3 class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant mb-md">Planificación Futura</h3>
<div class="p-xs bg-surface-container-low rounded-lg border border-outline-variant">
<div class="flex justify-between items-center p-2 mb-2">
<span class="font-bold text-body-md">Marzo 2024</span>
<div class="flex gap-1">
<span class="material-symbols-outlined cursor-pointer hover:bg-surface-container-high rounded p-1">chevron_left</span>
<span class="material-symbols-outlined cursor-pointer hover:bg-surface-container-high rounded p-1">chevron_right</span>
</div>
</div>
<div class="grid grid-cols-7 gap-1 text-center text-[10px] font-bold text-on-surface-variant mb-1">
<span class="">L</span><span class="">M</span><span class="">M</span><span class="">J</span><span class="">V</span><span class="">S</span><span class="">D</span>
</div>
<div class="grid grid-cols-7 gap-1 text-center text-label-sm">
<span class="p-2 opacity-20">26</span><span class="p-2 opacity-20">27</span><span class="p-2 opacity-20">28</span><span class="p-2 opacity-20">29</span><span class="p-2">1</span><span class="p-2">2</span><span class="p-2">3</span>
<span class="p-2">4</span><span class="p-2">5</span><span class="p-2">6</span><span class="p-2">7</span><span class="p-2">8</span><span class="p-2">9</span><span class="p-2">10</span>
<span class="p-2">11</span><span class="p-2 bg-secondary text-on-secondary rounded-full">12</span><span class="p-2">13</span><span class="p-2">14</span><span class="p-2">15</span><span class="p-2">16</span><span class="p-2">17</span>
<span class="p-2">18</span><span class="p-2">19</span><span class="p-2">20</span><span class="p-2">21</span><span class="p-2">22</span><span class="p-2">23</span><span class="p-2">24</span>
<span class="p-2">25</span><span class="p-2">26</span><span class="p-2">27</span><span class="p-2">28</span><span class="p-2">29</span><span class="p-2">30</span><span class="p-2">31</span>
</div>
</div>
</div>
<!-- Reservation Summary -->
<div class="bg-primary text-on-primary rounded-xl p-lg shadow-xl relative overflow-hidden">
<div class="relative z-10">
<h3 class="font-headline-md text-headline-md mb-md">Resumen de Cita</h3>
<div class="mb-md">
  <label class="block text-label-sm font-medium text-on-primary opacity-70 uppercase tracking-wider mb-1">Nombre Completo</label>
  <input type="text" placeholder="Ingrese su nombre" class="w-full bg-surface-container-low text-primary px-3 py-2 rounded-lg border border-outline-variant focus:outline-none focus:border-secondary transition-colors text-body-md">
</div><div class="space-y-sm mb-lg border-l-2 border-secondary-container pl-md">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-secondary-fixed text-sm">event</span>
<span class="text-body-md">Martes, 13 de Marzo</span>
</div>
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-secondary-fixed text-sm">schedule</span>
<span class="text-body-md">11:00 AM - 12:30 PM</span>
</div>
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-secondary-fixed text-sm">location_on</span>
<span class="text-body-md">Oficinas Centrales</span>
</div>
</div>
<button class="w-full bg-secondary text-on-secondary py-3 rounded-lg font-bold text-body-md hover:brightness-110 active:scale-95 transition-all">Aceptar y Agendar</button>
</div>
<!-- Aesthetic background pattern -->
<div class="absolute -bottom-10 -right-10 w-40 h-40 bg-secondary opacity-20 rounded-full blur-3xl"></div>
</div>
</div>
</div>
</section>
</div>
</main>
<!-- BottomNavBar (Mobile only) -->
<nav class="fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-2 pb-safe bg-surface border-t border-outline-variant h-16 md:hidden">
<button class="flex flex-col items-center justify-center text-on-surface-variant px-4 py-1">
<span class="material-symbols-outlined">inventory_2</span>
<span class="font-label-sm text-[10px] mt-1">Catalog</span>
</button>
<button class="flex flex-col items-center justify-center bg-secondary-container text-on-secondary-container rounded-2xl px-4 py-1 scale-95 transition-transform active:scale-90">
<span class="material-symbols-outlined">event</span>
<span class="font-label-sm text-[10px] mt-1">Schedule</span>
</button>
<button class="flex flex-col items-center justify-center text-on-surface-variant px-4 py-1">
<span class="material-symbols-outlined">person</span>
<span class="font-label-sm text-[10px] mt-1">Profile</span>
</button>
<button class="flex flex-col items-center justify-center text-on-surface-variant px-4 py-1">
<span class="material-symbols-outlined">more_horiz</span>
<span class="font-label-sm text-[10px] mt-1">Menu</span>
</button>
</nav>
<script>
        // Micro-interactions for time slots and days
        document.querySelectorAll('button').forEach(btn => {
            btn.addEventListener('click', function() {
                if(!this.classList.contains('opacity-40') && !this.classList.contains('opacity-30')) {
                    // This is just a visual placeholder for interactivity
                    console.log('Action performed: ' + this.innerText.trim());
                }
            });
        });
    </script>


</body></html>