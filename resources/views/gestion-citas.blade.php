<!DOCTYPE html><html lang="es" class="light"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"><link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=block" rel="stylesheet"><script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script><script id="tailwind-config">try{
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "tertiary-fixed-dim": "#c4c7c9",
                        "on-tertiary": "#ffffff",
                        "outline": "#76777d",
                        "primary-fixed": "#dae2fd",
                        "background": "#f8f9ff",
                        "on-secondary-fixed": "#002113",
                        "on-primary-fixed-variant": "#3f465c",
                        "on-secondary": "#ffffff",
                        "outline-variant": "#c6c6cd",
                        "on-background": "#0b1c30",
                        "on-error": "#ffffff",
                        "surface-container-high": "#dce9ff",
                        "on-tertiary-container": "#818486",
                        "error-container": "#ffdad6",
                        "surface-dim": "#cbdbf5",
                        "surface-container-lowest": "#ffffff",
                        "inverse-on-surface": "#eaf1ff",
                        "tertiary-fixed": "#e0e3e5",
                        "on-primary": "#ffffff",
                        "tertiary-container": "#191c1e",
                        "on-tertiary-fixed-variant": "#444749",
                        "secondary": "#10B981",
                        "on-secondary-container": "#00714d",
                        "surface": "#f8f9ff",
                        "primary": "#0F172A",
                        "on-primary-fixed": "#131b2e",
                        "error": "#ba1a1a",
                        "surface-container": "#e5eeff",
                        "on-secondary-fixed-variant": "#005236",
                        "surface-variant": "#d3e4fe",
                        "inverse-primary": "#bec6e0",
                        "on-surface-variant": "#45464d",
                        "on-error-container": "#93000a",
                        "on-surface": "#0b1c30",
                        "on-primary-container": "#7c839b",
                        "secondary-container": "#6cf8bb",
                        "secondary-fixed-dim": "#4edea3",
                        "on-tertiary-fixed": "#191c1e",
                        "tertiary": "#000000",
                        "primary-fixed-dim": "#bec6e0",
                        "surface-bright": "#f8f9ff",
                        "surface-container-highest": "#d3e4fe",
                        "primary-container": "#131b2e",
                        "surface-container-low": "#eff4ff",
                        "surface-tint": "#565e74",
                        "secondary-fixed": "#6ffbbe",
                        "inverse-surface": "#213145"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "2xl": "48px",
                        "margin-desktop": "32px",
                        "xs": "4px",
                        "lg": "24px",
                        "3xl": "64px",
                        "xl": "32px",
                        "base": "4px",
                        "container-max": "1280px",
                        "md": "16px",
                        "sm": "8px",
                        "margin-mobile": "16px",
                        "gutter": "24px"
                    },
                    "fontFamily": {
                        "headline-lg-mobile": ["Inter"],
                        "label-md": ["Inter"],
                        "body-lg": ["Inter"],
                        "label-sm": ["Inter"],
                        "body-sm": ["Inter"],
                        "body-md": ["Inter"],
                        "headline-md": ["Inter"],
                        "headline-xl": ["Inter"],
                        "headline-lg": ["Inter"]
                    },
                    "fontSize": {
                        "headline-lg-mobile": ["28px", {"lineHeight": "36px", "letterSpacing": "-0.01em", "fontWeight": "700"}],
                        "label-md": ["14px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                        "label-sm": ["12px", {"lineHeight": "16px", "fontWeight": "500"}],
                        "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                        "headline-xl": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "700"}]
                    }
                },
            },
        }
    }catch(_e){}</script><meta charset="utf-8"></head><body class="bg-background text-on-background">
<!-- SideNavBar (Desktop Only) -->
<aside class="fixed left-0 top-0 h-full z-40 p-md h-full w-64 hidden md:flex flex-col bg-surface dark:bg-inverse-surface border-r border-outline-variant dark:border-outline flat no shadows">
<div class="mb-3xl">
<h1 class="font-headline-md text-headline-md font-bold text-primary">SecureCorp</h1>
<p class="font-label-sm text-label-sm text-on-surface-variant">Admin Dashboard</p>
</div>
<nav class="flex-grow space-y-1">
<!-- Catalog -->
<a href="#" class="flex items-center gap-3 px-4 py-3 font-label-md text-label-md text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high transition-all duration-200 ease-in-out">
<span class="material-symbols-outlined">grid_view</span>
<span class="">Catalog</span>
</a>
<!-- Schedule (Active) -->
<a href="#" class="flex items-center gap-3 px-4 py-3 font-label-md text-label-md bg-secondary-container dark:bg-on-secondary-fixed-variant text-on-secondary-container dark:text-secondary-fixed rounded-lg transition-all duration-200 ease-in-out">
<span class="material-symbols-outlined">calendar_today</span>
<span class="">Schedule</span>
</a>
<!-- Orders -->
<a href="#" class="flex items-center gap-3 px-4 py-3 font-label-md text-label-md text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high transition-all duration-200 ease-in-out">
<span class="material-symbols-outlined">receipt_long</span>
<span class="">Orders</span>
</a>
<!-- Settings -->
<a href="#" class="flex items-center gap-3 px-4 py-3 font-label-md text-label-md text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high transition-all duration-200 ease-in-out">
<span class="material-symbols-outlined">settings</span>
<span class="">Settings</span>
</a>
</nav>
<div class="mt-auto border-t border-outline-variant pt-lg space-y-1">
<a href="#" class="flex items-center gap-3 px-4 py-3 font-label-md text-label-md text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high transition-all duration-200 ease-in-out">
<span class="material-symbols-outlined">help</span>
<span class="">Help</span>
</a>
<a href="#" class="flex items-center gap-3 px-4 py-3 font-label-md text-label-md text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high transition-all duration-200 ease-in-out">
<span class="material-symbols-outlined">logout</span>
<span class="">Sign Out</span>
</a>
</div>
</aside>
<!-- Main Content Layout -->
<div class="md:pl-64 flex flex-col min-h-screen">
<!-- TopAppBar -->
<header class="sticky top-0 z-30 bg-surface dark:bg-inverse-surface border-b border-outline-variant dark:border-outline shadow-sm h-16 flex items-center">
<div class="flex justify-between items-center w-full px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
<div class="flex items-center gap-4">
<span class="md:hidden material-symbols-outlined text-primary cursor-pointer">menu</span>
<span class="font-headline-md text-headline-md font-headline-lg text-primary dark:text-inverse-primary">Gestión de Citas</span>
</div>
<div class="flex items-center gap-md">
<div class="hidden md:flex items-center bg-surface-container-low px-4 py-2 rounded-full border border-outline-variant">
<span class="material-symbols-outlined text-on-surface-variant text-[20px]">search</span>
<input type="text" placeholder="Buscar citas..." class="bg-transparent border-none focus:ring-0 text-body-sm font-body-sm ml-2 w-48">
</div>
<div class="flex items-center gap-sm">
<button class="p-2 text-on-surface-variant hover:bg-surface-container-low rounded-full transition-colors cursor-pointer active:opacity-80">
<span class="material-symbols-outlined">notifications</span>
</button>
<button class="p-2 text-on-surface-variant hover:bg-surface-container-low rounded-full transition-colors cursor-pointer active:opacity-80">
<span class="material-symbols-outlined">help_outline</span>
</button>
<div class="w-8 h-8 rounded-full bg-surface-container-highest flex items-center justify-center border border-outline-variant ml-2 overflow-hidden">
<img class="w-full h-full object-cover" data-alt="A professional headshot of a corporate administrator in a bright, modern office setting. The lighting is soft and even, highlighting a friendly but authoritative expression. The background shows a clean, blurred technology-driven workspace with minimalist architectural details in white and navy blue tones." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDR40_JtW-odfhxK2hS95-75DeKY44xR5oY0MBOvYQwp_NV8Xh3gP48rdaJnBy7Kju5KtTQqwptCHr21b0qenA9C_t-LSAea8RSZZCgGnSob9bVrZSXzcS-ve7kdXZI9J14az_R0TleCEy0mC-ttUd4Cc29n01ONr3YXeouqc69K1HzbOfnmquO005ZhxBScs_7jVM0ugIoPzB5V_KptH_9PIlYCSZ1DPdpFUan4ZssRcxAGds37w9gVQ">
</div>
</div>
</div>
</div>
</header>
<!-- Page Canvas -->
<main class="flex-grow p-margin-mobile md:p-margin-desktop max-w-container-max w-full mx-auto">
<!-- Quick Actions / Stats (Bento Style) -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-lg mb-2xl">
<div class="bg-surface p-lg rounded-xl card-shadow border border-outline-variant col-span-1">
<div class="flex items-center justify-between mb-sm">
<span class="text-on-surface-variant font-label-sm text-label-sm">Citas Hoy</span>
<span class="material-symbols-outlined text-secondary">today</span>
</div>
<div class="font-headline-lg text-headline-lg text-primary">12</div>
<div class="text-body-sm font-body-sm text-secondary flex items-center gap-1 mt-xs">
<span class="material-symbols-outlined text-[16px]">trending_up</span>
<span class="">+4 que ayer</span>
</div>
</div>
<div class="bg-surface p-lg rounded-xl card-shadow border border-outline-variant col-span-1"><div class="flex items-center justify-between mb-sm">
<span class="text-on-surface-variant font-label-sm text-label-sm">Ingresos Hoy</span>
<span class="material-symbols-outlined text-secondary">payments</span>
</div>
<div class="font-headline-md text-headline-md text-primary">$12,450.00</div>
<div class="text-body-sm font-body-sm text-secondary flex items-center gap-1 mt-xs">
<span class="material-symbols-outlined text-[16px]">trending_up</span>
<span class="">+12% vs ayer</span>
</div></div>

</div>
<!-- Table Section -->
<div class="bg-surface rounded-xl card-shadow border border-outline-variant overflow-hidden">
<div class="px-lg py-md flex flex-col md:flex-row justify-between items-start md:items-center gap-md border-b border-outline-variant">
<div class="">
<h2 class="font-headline-md text-headline-md text-primary">Listado de Citas</h2>
<p class="font-body-sm text-body-sm text-on-surface-variant">Gestione y supervise todas las citas activas de SecureCorp.</p>
</div>
<div class="flex gap-sm">
<button class="flex items-center gap-2 px-md py-sm rounded-lg border border-outline text-on-surface hover:bg-surface-container-low transition-colors font-label-md text-label-md">
<span class="material-symbols-outlined text-[18px]">filter_list</span>
                            Filtrar
                        </button>
<button class="flex items-center gap-2 px-md py-sm rounded-lg border border-outline text-on-surface hover:bg-surface-container-low transition-colors font-label-md text-label-md">
<span class="material-symbols-outlined text-[18px]">download</span>
                            Exportar
                        </button>
</div>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low border-b border-outline-variant">
<th class="px-lg py-md font-label-md text-label-md text-on-surface-variant">Fecha</th>
<th class="px-lg py-md font-label-md text-label-md text-on-surface-variant">Hora</th>
<th class="px-lg py-md font-label-md text-label-md text-on-surface-variant">Servicio Seleccionado</th>
<th class="px-lg py-md font-label-md text-label-md text-on-surface-variant">Estado</th>
<th class="px-lg py-md font-label-md text-label-md text-on-surface-variant text-right">Acciones</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant">
<!-- Row 1 -->
<tr class="hover:bg-surface-container-lowest transition-colors">
<td class="px-lg py-md font-body-md text-body-md text-on-surface">24 Oct, 2023</td>
<td class="px-lg py-md font-body-md text-body-md text-on-surface">09:30 AM</td>
<td class="px-lg py-md">
<div class="flex items-center gap-2">
<div class="w-2 h-2 rounded-full bg-secondary"></div>
<span class="font-body-md text-body-md text-on-surface">Consultoría de Seguridad</span>
</div>
</td>
<td class="px-lg py-md">
<span class="px-sm py-1 bg-secondary-container text-on-secondary-fixed-variant text-label-sm font-label-sm rounded-full">Confirmada</span>
</td>
<td class="px-lg py-md text-right">
<div class="flex justify-end gap-sm">
<button class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-container-high rounded-lg transition-all" title="Editar">
<span class="material-symbols-outlined text-[20px]">edit</span>
</button>
<button class="p-2 text-on-surface-variant hover:text-error hover:bg-error-container rounded-lg transition-all" title="Eliminar">
<span class="material-symbols-outlined text-[20px]">delete</span>
</button>
</div>
</td>
</tr>
<!-- Row 2 -->
<tr class="hover:bg-surface-container-lowest transition-colors">
<td class="px-lg py-md font-body-md text-body-md text-on-surface">24 Oct, 2023</td>
<td class="px-lg py-md font-body-md text-body-md text-on-surface">11:00 AM</td>
<td class="px-lg py-md">
<div class="flex items-center gap-2">
<div class="w-2 h-2 rounded-full bg-primary"></div>
<span class="font-body-md text-body-md text-on-surface">Auditoría Cloud</span>
</div>
</td>
<td class="px-lg py-md">
<span class="px-sm py-1 bg-surface-container-high text-on-surface-variant text-label-sm font-label-sm rounded-full">Pendiente</span>
</td>
<td class="px-lg py-md text-right">
<div class="flex justify-end gap-sm">
<button class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-container-high rounded-lg transition-all" title="Editar">
<span class="material-symbols-outlined text-[20px]">edit</span>
</button>
<button class="p-2 text-on-surface-variant hover:text-error hover:bg-error-container rounded-lg transition-all" title="Eliminar">
<span class="material-symbols-outlined text-[20px]">delete</span>
</button>
</div>
</td>
</tr>
<!-- Row 3 -->
<tr class="hover:bg-surface-container-lowest transition-colors">
<td class="px-lg py-md font-body-md text-body-md text-on-surface">25 Oct, 2023</td>
<td class="px-lg py-md font-body-md text-body-md text-on-surface">02:15 PM</td>
<td class="px-lg py-md">
<div class="flex items-center gap-2">
<div class="w-2 h-2 rounded-full bg-secondary"></div>
<span class="font-body-md text-body-md text-on-surface">Soporte Técnico Enterprise</span>
</div>
</td>
<td class="px-lg py-md">
<span class="px-sm py-1 bg-secondary-container text-on-secondary-fixed-variant text-label-sm font-label-sm rounded-full">Confirmada</span>
</td>
<td class="px-lg py-md text-right">
<div class="flex justify-end gap-sm">
<button class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-container-high rounded-lg transition-all" title="Editar">
<span class="material-symbols-outlined text-[20px]">edit</span>
</button>
<button class="p-2 text-on-surface-variant hover:text-error hover:bg-error-container rounded-lg transition-all" title="Eliminar">
<span class="material-symbols-outlined text-[20px]">delete</span>
</button>
</div>
</td>
</tr>
<!-- Row 4 -->
<tr class="hover:bg-surface-container-lowest transition-colors">
<td class="px-lg py-md font-body-md text-body-md text-on-surface">25 Oct, 2023</td>
<td class="px-lg py-md font-body-md text-body-md text-on-surface">04:45 PM</td>
<td class="px-lg py-md">
<div class="flex items-center gap-2">
<div class="w-2 h-2 rounded-full bg-tertiary"></div>
<span class="font-body-md text-body-md text-on-surface">Formación de Empleados</span>
</div>
</td>
<td class="px-lg py-md">
<span class="px-sm py-1 bg-error-container text-on-error-container text-label-sm font-label-sm rounded-full">Cancelada</span>
</td>
<td class="px-lg py-md text-right">
<div class="flex justify-end gap-sm">
<button class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-container-high rounded-lg transition-all" title="Editar">
<span class="material-symbols-outlined text-[20px]">edit</span>
</button>
<button class="p-2 text-on-surface-variant hover:text-error hover:bg-error-container rounded-lg transition-all" title="Eliminar">
<span class="material-symbols-outlined text-[20px]">delete</span>
</button>
</div>
</td>
</tr>
</tbody>
</table>
</div>
<div class="px-lg py-md bg-surface-container-low flex justify-between items-center border-t border-outline-variant">
<span class="text-label-sm font-label-sm text-on-surface-variant">Mostrando 4 de 128 citas</span>
<div class="flex gap-sm">
<button class="p-2 hover:bg-surface-container-high rounded transition-colors disabled:opacity-30" disabled="">
<span class="material-symbols-outlined">chevron_left</span>
</button>
<div class="flex items-center gap-1">
<button class="w-8 h-8 flex items-center justify-center rounded bg-primary text-on-primary font-label-md">1</button>
<button class="w-8 h-8 flex items-center justify-center rounded hover:bg-surface-container-high font-label-md">2</button>
<button class="w-8 h-8 flex items-center justify-center rounded hover:bg-surface-container-high font-label-md">3</button>
</div>
<button class="p-2 hover:bg-surface-container-high rounded transition-colors">
<span class="material-symbols-outlined">chevron_right</span>
</button>
</div>
</div>
</div>
</main>
<!-- Footer (Simulated) -->
<footer class="mt-auto py-lg border-t border-outline-variant bg-surface px-margin-desktop text-center md:text-left">
<p class="font-label-sm text-label-sm text-on-surface-variant">© 2023 SecureCorp Enterprise Systems. Todos los derechos reservados.</p>
</footer>
</div>
<!-- Mobile BottomNavBar -->
<nav class="fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-2 pb-safe bg-surface dark:bg-inverse-surface h-16 md:hidden border-t border-outline-variant dark:border-outline shadow-lg">
<a class="flex flex-col items-center justify-center text-on-surface-variant dark:text-surface-variant px-4 py-1 active:bg-surface-container-high transition-all" href="#">
<span class="material-symbols-outlined">inventory_2</span>
<span class="font-label-sm text-[10px]">Catalog</span>
</a>
<a class="flex flex-col items-center justify-center bg-secondary-container dark:bg-on-secondary-fixed-variant text-on-secondary-container dark:text-secondary-fixed rounded-2xl px-4 py-1 active:bg-surface-container-high transition-all" href="#">
<span class="material-symbols-outlined">event</span>
<span class="font-label-sm text-[10px]">Schedule</span>
</a>
<a class="flex flex-col items-center justify-center text-on-surface-variant dark:text-surface-variant px-4 py-1 active:bg-surface-container-high transition-all" href="#">
<span class="material-symbols-outlined">person</span>
<span class="font-label-sm text-[10px]">Profile</span>
</a>
<a class="flex flex-col items-center justify-center text-on-surface-variant dark:text-surface-variant px-4 py-1 active:bg-surface-container-high transition-all" href="#">
<span class="material-symbols-outlined">more_horiz</span>
<span class="font-label-sm text-[10px]">Menu</span>
</a>
</nav>
<!-- Micro-interaction Script -->
<script>
        document.querySelectorAll('button, a').forEach(el => {
            el.addEventListener('mousedown', () => {
                el.style.transform = 'scale(0.97)';
            });
            el.addEventListener('mouseup', () => {
                el.style.transform = 'scale(1)';
            });
            el.addEventListener('mouseleave', () => {
                el.style.transform = 'scale(1)';
            });
        });
    </script>



</body></html>