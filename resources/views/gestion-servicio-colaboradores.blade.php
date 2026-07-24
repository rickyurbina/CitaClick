<!DOCTYPE html><html lang="en" class="light"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"><link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=block" rel="stylesheet"><script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script><script id="tailwind-config">try{
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "tertiary-fixed": "#e0e3e5",
                        "surface-tint": "#565e74",
                        "on-error": "#ffffff",
                        "surface-container-low": "#eff4ff",
                        "on-primary-fixed-variant": "#3f465c",
                        "on-tertiary-fixed": "#191c1e",
                        "on-secondary-fixed-variant": "#005236",
                        "surface-container-lowest": "#ffffff",
                        "on-primary-fixed": "#131b2e",
                        "surface-container-high": "#dce9ff",
                        "on-background": "#0b1c30",
                        "surface-container-highest": "#d3e4fe",
                        "error-container": "#ffdad6",
                        "tertiary": "#000000",
                        "secondary-fixed-dim": "#4edea3",
                        "on-tertiary-fixed-variant": "#444749",
                        "inverse-primary": "#bec6e0",
                        "secondary-fixed": "#6ffbbe",
                        "on-tertiary-container": "#818486",
                        "on-primary": "#ffffff",
                        "on-error-container": "#93000a",
                        "tertiary-container": "#191c1e",
                        "on-secondary-fixed": "#002113",
                        "primary": "#000000",
                        "surface-bright": "#f8f9ff",
                        "on-surface-variant": "#45464d",
                        "on-secondary-container": "#00714d",
                        "on-secondary": "#ffffff",
                        "tertiary-fixed-dim": "#c4c7c9",
                        "outline": "#76777d",
                        "on-primary-container": "#7c839b",
                        "secondary": "#006c49",
                        "surface": "#f8f9ff",
                        "on-tertiary": "#ffffff",
                        "on-surface": "#0b1c30",
                        "surface-dim": "#cbdbf5",
                        "primary-fixed-dim": "#bec6e0",
                        "background": "#f8f9ff",
                        "surface-variant": "#d3e4fe",
                        "inverse-surface": "#213145",
                        "outline-variant": "#c6c6cd",
                        "surface-container": "#e5eeff",
                        "inverse-on-surface": "#eaf1ff",
                        "error": "#ba1a1a",
                        "primary-fixed": "#dae2fd",
                        "primary-container": "#131b2e",
                        "secondary-container": "#6cf8bb"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "xs": "4px",
                        "xl": "32px",
                        "md": "16px",
                        "container-max": "1280px",
                        "3xl": "64px",
                        "margin-desktop": "32px",
                        "lg": "24px",
                        "sm": "8px",
                        "margin-mobile": "16px",
                        "gutter": "24px",
                        "base": "4px",
                        "2xl": "48px"
                    },
                    "fontFamily": {
                        "body-md": ["Inter"],
                        "headline-md": ["Inter"],
                        "body-lg": ["Inter"],
                        "headline-lg": ["Inter"],
                        "headline-xl": ["Inter"],
                        "label-sm": ["Inter"],
                        "label-md": ["Inter"],
                        "body-sm": ["Inter"]
                    },
                    "fontSize": {
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                        "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "700"}],
                        "headline-xl": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "label-sm": ["12px", {"lineHeight": "16px", "fontWeight": "500"}],
                        "label-md": ["14px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600"}],
                        "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}]
                    }
                },
            },
        }
    }catch(_e){}</script><meta charset="utf-8"></head><body class="bg-background font-body-md text-on-background min-h-screen">
<!-- Sidebar (SideNavBar Anchor) -->
<aside class="h-screen w-64 fixed left-0 top-0 flex flex-col bg-surface-container-low border-r border-outline-variant shadow-md z-50">
<div class="flex flex-col py-lg h-full">
<div class="px-md mb-xl">
<div class="flex items-center gap-sm">
<div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
<span class="material-symbols-outlined text-on-primary">security</span>
</div>
<div>
<h1 class="font-headline-md text-headline-md font-bold text-on-surface">SecureCorp</h1>
<p class="font-label-sm text-label-sm text-on-surface-variant opacity-70">Enterprise Admin</p>
</div>
</div>
</div>
<nav class="flex-1 space-y-1">
<a href="#" class="flex items-center gap-md px-md py-sm mx-2 font-label-md text-label-md transition-all duration-200 text-on-surface-variant hover:bg-surface-container-high">
<span class="material-symbols-outlined">dashboard</span>
<span class="">Dashboard</span>
</a>
<a href="#" class="flex items-center gap-md px-md py-sm mx-2 font-label-md text-label-md transition-all duration-200 bg-secondary-container text-on-secondary-container rounded-lg">
<span class="material-symbols-outlined">settings_suggest</span>
<span class="">Services</span>
</a>
<a href="#" class="flex items-center gap-md px-md py-sm mx-2 font-label-md text-label-md transition-all duration-200 text-on-surface-variant hover:bg-surface-container-high">
<span class="material-symbols-outlined">group</span>
<span class="">Team</span>
</a>
<a href="#" class="flex items-center gap-md px-md py-sm mx-2 font-label-md text-label-md transition-all duration-200 text-on-surface-variant hover:bg-surface-container-high">
<span class="material-symbols-outlined">settings</span>
<span class="">Settings</span>
</a>
</nav>
<div class="mt-auto border-t border-outline-variant pt-md">
<a href="#" class="flex items-center gap-md px-md py-sm mx-2 font-label-md text-label-md text-on-surface-variant hover:bg-surface-container-high transition-all">
<span class="material-symbols-outlined">contact_support</span>
<span class="">Support</span>
</a>
<a href="#" class="flex items-center gap-md px-md py-sm mx-2 font-label-md text-label-md text-error hover:bg-error-container transition-all">
<span class="material-symbols-outlined">logout</span>
<span class="">Logout</span>
</a>
</div>
</div>
</aside>
<!-- Main Content Area -->
<main class="pl-64 min-h-screen">
<!-- TopNavBar Anchor -->
<header class="w-full h-16 sticky top-0 z-40 bg-surface border-b border-outline-variant shadow-sm flex justify-between items-center px-margin-desktop">
<div class="flex items-center gap-lg">
<h2 class="font-headline-md text-headline-md font-bold text-primary">Management Console</h2>
<div class="relative hidden lg:block">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-body-md">search</span>
<input type="text" placeholder="Global search..." class="pl-10 pr-4 py-2 bg-surface-container-low border border-outline-variant rounded-full text-body-sm focus:outline-none focus:border-secondary w-64 transition-all">
</div>
</div>
<div class="flex items-center gap-md">
<button class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-surface-container-low transition-colors">
<span class="material-symbols-outlined text-primary">notifications</span>
</button>
<button class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-surface-container-low transition-colors">
<span class="material-symbols-outlined text-primary">help</span>
</button>
<div class="h-8 w-px bg-outline-variant mx-2"></div>
<div class="flex items-center gap-sm cursor-pointer hover:bg-surface-container-low p-1 rounded-lg transition-colors">
<img class="w-8 h-8 rounded-full border border-outline-variant object-cover" data-alt="A professional headshot of a corporate administrator, middle-aged with a confident expression, wearing a tailored navy blazer. The lighting is soft and studio-quality, with a blurred office background. The overall aesthetic is clean, high-contrast, and authoritative, matching the SecureCorp brand identity." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBj1Jh4vdDhDleyt7wlqqqnrDi7L_QhU7Sb9GXGUDgztXZTYqV-jNwiT1zsxqpTENWg1eM9SpJ4FMzUtlC9cV982TnvBefjFVLz_nM5oXgG4bFsMzzWpaQ_PV3Ydvz900Tbn9siaAgNlCVYj_1SDybXSQXRj_MgTB7dr7XDWeAS1mPKp7BIrzXwFWvupfsXPI2xNah_zL_dPIBxQLuw2i4y9V_rePqNdUvHM94DST-wj1WfTKLOWAz_oA">
<span class="font-label-md text-label-md text-on-surface hidden xl:block">Admin. Michael</span>
</div>
</div>
</header>
<div class="p-xl max-w-container-max mx-auto">
<!-- Breadcrumbs -->
<nav class="flex items-center gap-xs text-body-sm text-on-surface-variant mb-lg">
<span class="">Dashboard</span>
<span class="material-symbols-outlined text-sm">chevron_right</span>
<span class="text-secondary font-semibold">Service Management</span>
</nav>
<!-- Section Tabs -->
<div class="mb-xl border-b border-outline-variant flex gap-xl">
<button class="pb-md font-label-md text-label-md active-tab transition-all" id="btn-services" onclick="switchTab('services')">Manage Services</button>
<button class="pb-md font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-all" id="btn-collaborators" onclick="switchTab('collaborators')">Manage Collaborators</button>
</div>
<!-- Manage Services View -->
<div class="space-y-lg block" id="view-services">
<div class="flex flex-col md:flex-row md:items-center justify-between gap-md">
<div>
<h3 class="font-headline-md text-headline-md text-on-surface">Available Services</h3>
<p class="text-body-sm text-on-surface-variant mt-1">Configure and manage your organization's service catalog.</p>
</div>
<button class="inline-flex items-center gap-sm px-lg py-3 bg-secondary text-on-secondary font-label-md text-label-md rounded-lg hover:brightness-110 active:scale-95 transition-all shadow-md">
<span class="material-symbols-outlined">add</span>
                        Add New Service
                    </button>
</div>
<!-- Bento-ish Grid Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-lg">
<div class="p-lg bg-surface border border-outline-variant rounded-xl shadow-sm flex items-center gap-lg">
<div class="w-12 h-12 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
<span class="material-symbols-outlined">inventory_2</span>
</div>
<div>
<p class="text-label-sm text-on-surface-variant uppercase tracking-wider">Total Services</p>
<h4 class="text-headline-md font-bold text-on-surface">24</h4>
</div>
</div>
<div class="p-lg bg-surface border border-outline-variant rounded-xl shadow-sm flex items-center gap-lg">
<div class="w-12 h-12 rounded-full bg-surface-container-high flex items-center justify-center text-secondary">
<span class="material-symbols-outlined">payments</span>
</div>
<div>
<p class="text-label-sm text-on-surface-variant uppercase tracking-wider">Avg. Price</p>
<h4 class="text-headline-md font-bold text-on-surface">$1,240</h4>
</div>
</div>
<div class="p-lg bg-surface border border-outline-variant rounded-xl shadow-sm flex items-center gap-lg">
<div class="w-12 h-12 rounded-full bg-on-primary-fixed-variant flex items-center justify-center text-white">
<span class="material-symbols-outlined">trending_up</span>
</div>
<div>
<p class="text-label-sm text-on-surface-variant uppercase tracking-wider">Service Growth</p>
<h4 class="text-headline-md font-bold text-on-surface">+12%</h4>
</div>
</div>
</div>
<!-- Table Container -->
<div class="bg-surface border border-outline-variant rounded-xl shadow-sm overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low border-b border-outline-variant">
<th class="px-lg py-4 font-label-md text-label-md text-on-surface">Service Name</th>
<th class="px-lg py-4 font-label-md text-label-md text-on-surface">Category</th>
<th class="px-lg py-4 font-label-md text-label-md text-on-surface">Price</th>
<th class="px-lg py-4 font-label-md text-label-md text-on-surface text-right">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant">
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-lg py-4">
<div class="flex items-center gap-md">
<div class="w-8 h-8 rounded bg-primary-container text-on-primary-container flex items-center justify-center">
<span class="material-symbols-outlined text-sm">shield</span>
</div>
<span class="font-body-md font-semibold">Enterprise Security Audit</span>
</div>
</td>
<td class="px-lg py-4">
<span class="px-3 py-1 bg-surface-container-high text-on-surface-variant rounded-full text-xs font-medium">Compliance</span>
</td>
<td class="px-lg py-4 font-body-md text-on-surface">$4,500.00</td>
<td class="px-lg py-4 text-right">
<div class="flex justify-end gap-sm opacity-0 group-hover:opacity-100 transition-opacity"><button class="p-2 hover:bg-secondary-container hover:text-on-secondary-container rounded transition-colors" title="Edit"><span class="material-symbols-outlined">edit</span></button><button class="p-2 hover:bg-error-container hover:text-error rounded transition-colors" title="Delete"><span class="material-symbols-outlined">delete</span></button></div>
</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-lg py-4">
<div class="flex items-center gap-md">
<div class="w-8 h-8 rounded bg-secondary-container text-on-secondary-container flex items-center justify-center">
<span class="material-symbols-outlined text-sm">cloud</span>
</div>
<span class="font-body-md font-semibold">Cloud Infrastructure Mgmt</span>
</div>
</td>
<td class="px-lg py-4">
<span class="px-3 py-1 bg-surface-container-high text-on-surface-variant rounded-full text-xs font-medium">Infrastructure</span>
</td>
<td class="px-lg py-4 font-body-md text-on-surface">$2,200.00</td>
<td class="px-lg py-4 text-right">
<div class="flex justify-end gap-sm opacity-0 group-hover:opacity-100 transition-opacity"><button class="p-2 hover:bg-secondary-container hover:text-on-secondary-container rounded transition-colors" title="Edit"><span class="material-symbols-outlined">edit</span></button><button class="p-2 hover:bg-error-container hover:text-error rounded transition-colors" title="Delete"><span class="material-symbols-outlined">delete</span></button></div>
</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-lg py-4">
<div class="flex items-center gap-md">
<div class="w-8 h-8 rounded bg-on-primary-fixed-variant text-white flex items-center justify-center">
<span class="material-symbols-outlined text-sm">support_agent</span>
</div>
<span class="font-body-md font-semibold">24/7 Incident Response</span>
</div>
</td>
<td class="px-lg py-4">
<span class="px-3 py-1 bg-surface-container-high text-on-surface-variant rounded-full text-xs font-medium">Support</span>
</td>
<td class="px-lg py-4 font-body-md text-on-surface">$950.00 / mo</td>
<td class="px-lg py-4 text-right">
<div class="flex justify-end gap-sm opacity-0 group-hover:opacity-100 transition-opacity"><button class="p-2 hover:bg-secondary-container hover:text-on-secondary-container rounded transition-colors" title="Edit"><span class="material-symbols-outlined">edit</span></button><button class="p-2 hover:bg-error-container hover:text-error rounded transition-colors" title="Delete"><span class="material-symbols-outlined">delete</span></button></div>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
<!-- Manage Collaborators View (Hidden by default) -->
<div class="space-y-lg hidden" id="view-collaborators">
<div class="flex flex-col md:flex-row md:items-center justify-between gap-md">
<div>
<h3 class="font-headline-md text-headline-md text-on-surface">Manage Team Members</h3>
<p class="text-body-sm text-on-surface-variant mt-1">Invite and manage roles for your professional services team.</p>
</div>
<button class="inline-flex items-center gap-sm px-lg py-3 bg-secondary text-on-secondary font-label-md text-label-md rounded-lg hover:brightness-110 active:scale-95 transition-all shadow-md">
<span class="material-symbols-outlined">person_add</span>
                        Add New Collaborator
                    </button>
</div>
<div class="bg-surface border border-outline-variant rounded-xl shadow-sm overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low border-b border-outline-variant">
<th class="px-lg py-4 font-label-md text-label-md text-on-surface">Name</th>
<th class="px-lg py-4 font-label-md text-label-md text-on-surface">Role</th>
<th class="px-lg py-4 font-label-md text-label-md text-on-surface">Status</th>
<th class="px-lg py-4 font-label-md text-label-md text-on-surface text-right">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant">
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-lg py-4">
<div class="flex items-center gap-md">
<img class="w-10 h-10 rounded-full object-cover" data-alt="A portrait of a male professional in his 30s with short hair and glasses, wearing a white button-down shirt. The image has a clean, minimalist background with soft blue tones. Professional lighting enhances the high-contrast corporate modern look, emphasizing clarity and trust." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBf7MmwFU-PD5biYa6pTcObLeS6YvDwcx8Z9avc6rpOekdBVibO20luFPMXKrB01gt9BLitY4DQqBrS0824ywejZa_7rS_z2taYnoKsWhJXV4E8w1bLe_o7V-CR-3kOdJD6zvu2wuQMsDMoxjyrfn-keJ1Ma6fnIK2unjsWmQU95Nr8C-6V-Xd5Bl5NqC0ZdUQgLB-gXPJQAs9IeVwTHhymzmnMcqdT6gdfu-JXwJo94NcaxM94tKE3GA">
<div>
<div class="font-body-md font-semibold text-on-surface">David Chen</div>
<div class="text-xs text-on-surface-variant">david.c@securecorp.com</div>
</div>
</div>
</td>
<td class="px-lg py-4 text-body-sm text-on-surface">Lead Architect</td>
<td class="px-lg py-4">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary-container text-on-secondary-container">
<span class="w-1.5 h-1.5 rounded-full bg-secondary mr-1.5"></span>
                                            Active
                                        </span>
</td>
<td class="px-lg py-4 text-right">
<div class="flex justify-end gap-sm opacity-0 group-hover:opacity-100 transition-opacity">
<button class="p-2 hover:bg-secondary-container hover:text-on-secondary-container rounded transition-colors">
<span class="material-symbols-outlined">edit</span>
</button>
<button class="p-2 hover:bg-error-container hover:text-error rounded transition-colors">
<span class="material-symbols-outlined">delete</span>
</button>
</div>
</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-lg py-4">
<div class="flex items-center gap-md">
<img class="w-10 h-10 rounded-full object-cover" data-alt="A professional headshot of a woman in her 40s with a warm smile, wearing a structured charcoal grey blazer and a silk blouse. Her expression is approachable yet authoritative. The background is a blurred modern office environment with hints of emerald green, matching the brand colors. High-quality corporate aesthetic." src="https://lh3.googleusercontent.com/aida-public/AB6AXuD3BkqhliUq0Y55D1l5kuGV_VBfeVDSnrOzYt1giZJYHZdNu1Yw4ThXlTNXW0YqHvAlgUnfumbWkTTMZE3YWV8Hw1aHVgYDODRefpgnTUsKb1xmC4Dch7t0gFe8d2lTSXSuvNLuidN5t3LhnFVkqtjba8ueEhimtke2trJdk33vg-yWoSg9pxPeuSWXa9hPJLADbKJTKDqlW6i2m-9VMRr4a_85FWk7e-RSEtsBkLUEOdiVLfukcJo2nw">
<div>
<div class="font-body-md font-semibold text-on-surface">Sarah Jenkins</div>
<div class="text-xs text-on-surface-variant">s.jenkins@securecorp.com</div>
</div>
</div>
</td>
<td class="px-lg py-4 text-body-sm text-on-surface">Security Analyst</td>
<td class="px-lg py-4">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary-container text-on-secondary-container">
<span class="w-1.5 h-1.5 rounded-full bg-secondary mr-1.5"></span>
                                            Active
                                        </span>
</td>
<td class="px-lg py-4 text-right">
<div class="flex justify-end gap-sm opacity-0 group-hover:opacity-100 transition-opacity">
<button class="p-2 hover:bg-secondary-container hover:text-on-secondary-container rounded transition-colors">
<span class="material-symbols-outlined">edit</span>
</button>
<button class="p-2 hover:bg-error-container hover:text-error rounded transition-colors">
<span class="material-symbols-outlined">delete</span>
</button>
</div>
</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-lg py-4">
<div class="flex items-center gap-md">
<img class="w-10 h-10 rounded-full object-cover" data-alt="A professional photo of a man of African descent, mid-20s, with a focused and professional expression. He is wearing a minimalist dark navy sweater. The photo is set against a clean, architectural light grey background. Sharp focus and cinematic, high-key lighting for a modern enterprise UI." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAD32CrC3AN4GkpBwIJfRH_6WVp2F0wVy6E5ET9Qep2VZki4jP878X-7I3oKXq7RmqFZd2xV2nHaBFUaBTHyk1f41O2FtqE_SODICAQDwP_tKlFSLU-xXfSxYQkvOih4xBGk2zyXlgQcLkpfiP-iMzj-ep6q7uVTM_hKOfd61YLj7FGPRghiL8ss1yNWCcMoZzSofNv_6kyFqnehUCE9sIaYbPjU4QcfyUDRPVdcoS5e2ULROs6dOElDg">
<div>
<div class="font-body-md font-semibold text-on-surface">Marcus Thorne</div>
<div class="text-xs text-on-surface-variant">m.thorne@securecorp.com</div>
</div>
</div>
</td>
<td class="px-lg py-4 text-body-sm text-on-surface">Product Manager</td>
<td class="px-lg py-4">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-surface-container-high text-on-surface-variant">
<span class="w-1.5 h-1.5 rounded-full bg-outline mr-1.5"></span>
                                            Pending
                                        </span>
</td>
<td class="px-lg py-4 text-right">
<div class="flex justify-end gap-sm opacity-0 group-hover:opacity-100 transition-opacity">
<button class="p-2 hover:bg-secondary-container hover:text-on-secondary-container rounded transition-colors">
<span class="material-symbols-outlined">edit</span>
</button>
<button class="p-2 hover:bg-error-container hover:text-error rounded transition-colors">
<span class="material-symbols-outlined">delete</span>
</button>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
<!-- Notification Toast (Micro-interaction example) -->
<div class="fixed bottom-lg right-lg bg-inverse-surface text-inverse-on-surface px-lg py-md rounded-lg shadow-xl translate-y-20 opacity-0 transition-all duration-300 flex items-center gap-md z-50" id="toast">
<span class="material-symbols-outlined text-secondary">check_circle</span>
<p class="font-label-md">Operation completed successfully</p>
</div>
</main>
<script>
        function switchTab(tab) {
            const servicesView = document.getElementById('view-services');
            const collaboratorsView = document.getElementById('view-collaborators');
            const btnServices = document.getElementById('btn-services');
            const btnCollaborators = document.getElementById('btn-collaborators');

            if (tab === 'services') {
                servicesView.classList.remove('hidden');
                servicesView.classList.add('block');
                collaboratorsView.classList.remove('block');
                collaboratorsView.classList.add('hidden');
                
                btnServices.classList.add('active-tab');
                btnServices.classList.remove('text-on-surface-variant');
                btnCollaborators.classList.remove('active-tab');
                btnCollaborators.classList.add('text-on-surface-variant');
            } else {
                servicesView.classList.remove('block');
                servicesView.classList.add('hidden');
                collaboratorsView.classList.remove('hidden');
                collaboratorsView.classList.add('block');

                btnCollaborators.classList.add('active-tab');
                btnCollaborators.classList.remove('text-on-surface-variant');
                btnServices.classList.remove('active-tab');
                btnServices.classList.add('text-on-surface-variant');
            }
        }

        // Action feedback simulation
        document.querySelectorAll('button').forEach(btn => {
            btn.addEventListener('click', function() {
                const toast = document.getElementById('toast');
                toast.classList.remove('translate-y-20', 'opacity-0');
                
                setTimeout(() => {
                    toast.classList.add('translate-y-20', 'opacity-0');
                }, 3000);
            });
        });
    </script>

</body></html>