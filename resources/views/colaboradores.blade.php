<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>SecureCorp | Enterprise Solutions Catalog</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
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
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .product-card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .product-card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -10px rgba(15, 23, 42, 0.1);
        }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-surface text-on-surface custom-scrollbar">
<!-- TopAppBar -->
<header class="bg-surface dark:bg-inverse-surface border-b border-outline-variant dark:border-outline shadow-sm fixed top-0 left-0 right-0 z-50">
<div class="flex justify-between items-center w-full px-margin-mobile md:px-margin-desktop h-16 max-w-container-max mx-auto">
<div class="flex items-center gap-8">
<span class="text-headline-md font-headline-lg text-primary dark:text-inverse-primary cursor-pointer active:opacity-80 transition-opacity">SecureCorp</span>
<nav class="hidden md:flex items-center gap-6 h-full">
<a class="text-primary dark:text-secondary-fixed-dim font-bold border-b-2 border-primary h-16 flex items-center px-1 font-label-md text-label-md transition-colors" href="#">Catalog</a>
<a class="text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-low dark:hover:bg-surface-container-highest transition-colors h-16 flex items-center px-1 font-label-md text-label-md" href="#">Schedule</a>
<a class="text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-low dark:hover:bg-surface-container-highest transition-colors h-16 flex items-center px-1 font-label-md text-label-md" href="#">Orders</a>
</nav>
</div>
<div class="flex items-center gap-4">
<button class="material-symbols-outlined text-primary dark:text-inverse-primary p-2 hover:bg-surface-container-low rounded-full transition-colors">notifications</button>
<button class="material-symbols-outlined text-primary dark:text-inverse-primary p-2 hover:bg-surface-container-low rounded-full transition-colors">help_outline</button>
<div class="w-10 h-10 rounded-full overflow-hidden border border-outline-variant ml-2 cursor-pointer active:opacity-80 transition-opacity">
<img class="w-full h-full object-cover" data-alt="A professional headshot of a corporate executive in business attire, clean studio lighting, soft gray background, high-end professional photography style that aligns with a premium enterprise security company aesthetic." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAg1rw5GoL8k9I0LPm832iTGRGeV753V6UnimCuPV5j8hGk0s_0Lxp4b72SGtnEShP0hpfMlgIWjIg6KvNDIRE7zsTFkXeP3nu4ppjc_nrhyMbktzkhfnmI1IKvTP2aWC6gxGt7DdbkaD5YEnK3pftumVn11l_cA5P26KmCwhvTyhwdqRkRh23AotJo_205Z6vGQLTOXZbfQ1xFyzCE4CJDNQGovfWzVN3TdSZf6G--xlfGYB6MD9TxGA"/>
</div>
</div>
</div>
</header>
<!-- SideNavBar (Desktop Only) -->
<aside class="fixed left-0 top-16 h-[calc(100vh-64px)] w-64 hidden md:flex flex-col bg-surface dark:bg-inverse-surface border-r border-outline-variant dark:border-outline p-md z-40">
<div class="flex items-center gap-3 mb-8 px-2">
<div class="w-8 h-8 bg-primary rounded flex items-center justify-center">
<span class="material-symbols-outlined text-on-primary text-[20px]" style="font-variation-settings: 'FILL' 1;">security</span>
</div>
<div>
<h2 class="font-headline-md text-label-md font-bold text-primary">SecureCorp Admin</h2>
<p class="text-[10px] text-outline uppercase tracking-wider font-bold">Enterprise Tier</p>
</div>
</div>
<div class="flex-1 space-y-1">
<a class="flex items-center gap-3 px-4 py-3 bg-secondary-container dark:bg-on-secondary-fixed-variant text-on-secondary-container dark:text-secondary-fixed rounded-lg transition-all duration-200 ease-in-out" href="#">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">grid_view</span>
<span class="font-label-md text-label-md">Catalog</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-container-highest rounded-lg transition-all duration-200 ease-in-out" href="#">
<span class="material-symbols-outlined">calendar_today</span>
<span class="font-label-md text-label-md">Schedule</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-container-highest rounded-lg transition-all duration-200 ease-in-out" href="#">
<span class="material-symbols-outlined">receipt_long</span>
<span class="font-label-md text-label-md">Orders</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-container-highest rounded-lg transition-all duration-200 ease-in-out" href="#">
<span class="material-symbols-outlined">settings</span>
<span class="font-label-md text-label-md">Settings</span>
</a>
</div>
<div class="mt-auto pt-6 border-t border-outline-variant space-y-1">
<button class="w-full flex items-center justify-center gap-2 bg-[#10B981] text-white py-3 rounded-lg font-label-md text-label-md hover:bg-[#059669] transition-colors mb-6 shadow-sm">
<span class="material-symbols-outlined text-[20px]">add</span>
                New Appointment
            </button>
<a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-container-highest rounded-lg transition-all duration-200 ease-in-out" href="#">
<span class="material-symbols-outlined">help</span>
<span class="font-label-md text-label-md">Help</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-container-highest rounded-lg transition-all duration-200 ease-in-out" href="#">
<span class="material-symbols-outlined">logout</span>
<span class="font-label-md text-label-md">Sign Out</span>
</a>
</div>
</aside>
<!-- Main Content Area -->
<main class="pt-24 pb-20 md:pb-12 md:pl-72 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto min-h-screen">
<!-- Hero / Header Section -->
<section class="mb-12">
<div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
<div class="max-w-2xl">
<h1 class="font-headline-lg md:font-headline-xl text-headline-lg-mobile md:text-headline-xl text-primary mb-4">Enterprise Solutions Catalog</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant">Strategic infrastructure and security services designed for the modern corporate landscape. Scale with confidence.</p>
</div>
<div class="flex items-center gap-3">
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
<input class="pl-10 pr-4 py-2 bg-surface border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all w-full md:w-64 font-body-sm text-body-sm" placeholder="Search solutions..." type="text"/>
</div>
<button class="flex items-center gap-2 border-[1.5px] border-[#0F172A] text-[#0F172A] px-4 py-2 rounded-lg font-label-md text-label-md hover:bg-surface-container-low transition-colors">
<span class="material-symbols-outlined text-[20px]">filter_list</span>
                        Filter
                    </button>
</div>
</div>
<!-- Quick Chips -->
<div class="flex flex-wrap gap-2 mt-8">
<span class="px-3 py-1 bg-secondary-container text-on-secondary-container rounded-[4px] font-label-sm text-label-sm">All Services</span>
<span class="px-3 py-1 bg-surface-container-high text-on-surface-variant rounded-[4px] font-label-sm text-label-sm hover:bg-surface-variant cursor-pointer transition-colors">Cloud Security</span>
<span class="px-3 py-1 bg-surface-container-high text-on-surface-variant rounded-[4px] font-label-sm text-label-sm hover:bg-surface-variant cursor-pointer transition-colors">Risk Management</span>
<span class="px-3 py-1 bg-surface-container-high text-on-surface-variant rounded-[4px] font-label-sm text-label-sm hover:bg-surface-variant cursor-pointer transition-colors">Network Audit</span>
<span class="px-3 py-1 bg-surface-container-high text-on-surface-variant rounded-[4px] font-label-sm text-label-sm hover:bg-surface-variant cursor-pointer transition-colors">Compliance</span>
</div>
</section>
<!-- Product Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-lg">
<!-- Product Card 1 -->
<div class="product-card-hover bg-white border border-outline-variant rounded-lg overflow-hidden flex flex-col group">
<div class="relative h-64 w-full overflow-hidden">
<img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" data-alt="A clean, high-tech server room with glowing blue LED indicators on racks, deep blacks and tech-silver tones, professional wide-angle shot with shallow depth of field, minimalist and corporate tech aesthetic." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCRa6aBbgUq24NcGofPuxRoLuQoN0nnfKlm3kUK8djoWLlGMLDwTjRiPGCHmfQM8MB4XbkwK8Vn0lPH_3vjZRau7zyoqTnec9tZ84ple8IDA752e0ZrayNjn_URwceX3_PbYgaHsJuhwexjVXsXrHNQ5BFGDT20nGslOgDQbRwDRA9AwIiHZB0NwuO2E29O5n5-ltlu18RdKdflG_H6w8jRP_57MlsfPpHz4JN25thP5zjIHeomd7xDFg"/>
<div class="absolute top-4 right-4 px-2 py-1 bg-secondary-container/90 backdrop-blur-sm text-on-secondary-container text-[10px] font-bold uppercase tracking-wider rounded">Featured</div>
</div>
<div class="p-6 flex flex-col flex-1">
<div class="flex justify-between items-start mb-2">
<h3 class="font-headline-md text-headline-md text-primary">Cyber Guard Core</h3>
<span class="font-label-md text-label-md text-secondary">$1,200/mo</span>
</div>
<p class="font-body-sm text-body-sm text-on-surface-variant mb-6 flex-1">Integrated endpoint protection and 24/7 threat monitoring for medium to large enterprise networks. Includes weekly vulnerability assessments.</p>
<div class="flex items-center justify-between pt-4 border-t border-outline-variant">
<button class="text-secondary font-label-md text-label-md hover:underline">View Details</button>
<button class="bg-[#10B981] text-white px-4 py-2 rounded-lg font-label-md text-label-md hover:bg-[#059669] transition-colors">Request Quote</button>
</div>
</div>
</div>
<!-- Product Card 2 -->
<div class="product-card-hover bg-white border border-outline-variant rounded-lg overflow-hidden flex flex-col group">
<div class="relative h-64 w-full overflow-hidden">
<img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" data-alt="Close-up of a modern biometric access control panel on a frosted glass door in a high-end corporate office, bright white natural lighting, emerald green indicator light, sleek architectural details." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAsyF5UeT50WVvK_sWf5Mb7dasmgK65URLC6Fg3kLeEjAkCXjMXKSv2hgSzL0xhZ5iwYyI_x3Ct1GWDIFKG6cRDOdfQl4X5n2CVjhKEdIHVayNh_VSPk_4-WR0UwJ_x0JnvVayLxtrVmZyNkmH4RQ2YjvE-HHaMUqpfR_CpCdomrEvRMhSCT8q3UuLdUFnD7I01JG-PLw88J1skxfnY6xPgcNQwyrqKczOB3tm4cpu39hwK_KzRPqctvA"/>
</div>
<div class="p-6 flex flex-col flex-1">
<div class="flex justify-between items-start mb-2">
<h3 class="font-headline-md text-headline-md text-primary">Biometric Suite</h3>
<span class="font-label-md text-label-md text-secondary">$850/site</span>
</div>
<p class="font-body-sm text-body-sm text-on-surface-variant mb-6 flex-1">Advanced multi-factor physical access controls featuring facial recognition and encrypted keycard support for restricted zones.</p>
<div class="flex items-center justify-between pt-4 border-t border-outline-variant">
<button class="text-secondary font-label-md text-label-md hover:underline">View Details</button>
<button class="bg-[#10B981] text-white px-4 py-2 rounded-lg font-label-md text-label-md hover:bg-[#059669] transition-colors">Request Quote</button>
</div>
</div>
</div>
<!-- Product Card 3 -->
<div class="product-card-hover bg-white border border-outline-variant rounded-lg overflow-hidden flex flex-col group">
<div class="relative h-64 w-full overflow-hidden">
<img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" data-alt="A minimalist architectural visualization of a data center corridor, symmetrical lines, soft ambient white lighting with navy blue accents, clean and clinical corporate environment, high-end 3D render style." src="https://lh3.googleusercontent.com/aida-public/AB6AXuB7Xp5KhqJM4_EAKTXUVVzarNUXvYEi2SyrzlhoAx43UmXvJgP622p-PADy2MMXaHpMmUkB4pK772VPQNEwZ-IE_SNoz8oBlq7MzqyCRluv27mc7KP0xet4KpJYJ-T_KQ92ya2Jv9q6JifECoGSyYlAcfdVtwF-z7Wp3J5ZqNeqEt84PKN5yhEKYgrv2HkfdXl-U7fhlcf1wplc3nRHVd_Ammyn6J7QGm4Hmb700fZiMphsLkwrnZr-_g"/>
</div>
<div class="p-6 flex flex-col flex-1">
<div class="flex justify-between items-start mb-2">
<h3 class="font-headline-md text-headline-md text-primary">Cloud Vault Plus</h3>
<span class="font-label-md text-label-md text-secondary">$450/TB</span>
</div>
<p class="font-body-sm text-body-sm text-on-surface-variant mb-6 flex-1">Immutable backup storage with zero-knowledge encryption. Designed for critical data recovery and regulatory compliance auditing.</p>
<div class="flex items-center justify-between pt-4 border-t border-outline-variant">
<button class="text-secondary font-label-md text-label-md hover:underline">View Details</button>
<button class="bg-[#10B981] text-white px-4 py-2 rounded-lg font-label-md text-label-md hover:bg-[#059669] transition-colors">Request Quote</button>
</div>
</div>
</div>
<!-- Product Card 4 -->
<div class="product-card-hover bg-white border border-outline-variant rounded-lg overflow-hidden flex flex-col group">
<div class="relative h-64 w-full overflow-hidden">
<img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" data-alt="A professional analyst working with complex data visualizations on multiple ultra-thin monitors, dark room with vibrant green and blue glowing charts, cinematic lighting, corporate intelligence atmosphere." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBpsQOd4WnI41_UZQPoOsGmgdE-dRKnbUZR1G1YVBNtXN-ClMRQEAFWe5rFZ3Jm3egAg1NnJJn8r4f5kCycraq4KB79oA4vkT3bUwLB62gdshwAM-2sRbGLX8IhRUVt1UNcqO2dhL7-NkGpMwgS9_Xfkb-66-2CqTqshmDMjOE6qkhnCe-yNzg6kIuTPM9EDN0gKNZSBQGAe-igJd_31g2ATujMIjBELIqIAJtSdiV6NcaCDopOpB1vmA"/>
</div>
<div class="p-6 flex flex-col flex-1">
<div class="flex justify-between items-start mb-2">
<h3 class="font-headline-md text-headline-md text-primary">Risk Intelligence</h3>
<span class="font-label-md text-label-md text-secondary">$2,100/mo</span>
</div>
<p class="font-body-sm text-body-sm text-on-surface-variant mb-6 flex-1">Predictive analytics for global supply chain risks and geopolitical developments. Real-time dashboards and executive reporting.</p>
<div class="flex items-center justify-between pt-4 border-t border-outline-variant">
<button class="text-secondary font-label-md text-label-md hover:underline">View Details</button>
<button class="bg-[#10B981] text-white px-4 py-2 rounded-lg font-label-md text-label-md hover:bg-[#059669] transition-colors">Request Quote</button>
</div>
</div>
</div>
<!-- Product Card 5 -->
<div class="product-card-hover bg-white border border-outline-variant rounded-lg overflow-hidden flex flex-col group">
<div class="relative h-64 w-full overflow-hidden">
<img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" data-alt="A macro shot of professional network cabling, perfectly organized with green ties, bright studio lighting, soft focus background, emphasizing order and high-end technical expertise in networking." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAebtJwTzgfAxifEYYMl4jB6XrPHWomKRC7nnZNUOutPzLwPwtinWCp6E4WNUybXBqIH8m4hn3Ro7Uz8GkD640mH1Ik7DhOohBGrRjHgAl25m25GhUZ8Qb7RptgDvA96lI_jvljt66kx3pNiaAmFR8FRqw3PRUkplVhba8g9mXqLb1eQ1ADntM3BZx0xeoVODKrhz6IeMtxLfa8DPmHbgpfrdRouYA9_BXqGNsYQwbxfsrAUEWOr62TOQ"/>
</div>
<div class="p-6 flex flex-col flex-1">
<div class="flex justify-between items-start mb-2">
<h3 class="font-headline-md text-headline-md text-primary">Quantum Link</h3>
<span class="font-label-md text-label-md text-secondary">$950/mo</span>
</div>
<p class="font-body-sm text-body-sm text-on-surface-variant mb-6 flex-1">Next-generation SD-WAN connectivity with quantum-resistant encryption protocols for secure inter-office communication.</p>
<div class="flex items-center justify-between pt-4 border-t border-outline-variant">
<button class="text-secondary font-label-md text-label-md hover:underline">View Details</button>
<button class="bg-[#10B981] text-white px-4 py-2 rounded-lg font-label-md text-label-md hover:bg-[#059669] transition-colors">Request Quote</button>
</div>
</div>
</div>
<!-- Product Card 6 -->
<div class="product-card-hover bg-white border border-outline-variant rounded-lg overflow-hidden flex flex-col group">
<div class="relative h-64 w-full overflow-hidden">
<img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" data-alt="An abstract representation of digital compliance and legal documents, ethereal glowing lines forming a shield over a stack of high-end paper documents, corporate navy and soft gold color palette." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAr9X0B5tlk41ZRRSbTr7NfkJ_G0wLPk3uHY1BPw0cVLPaQoX5Ay3ZjzY-j_emPVMV435eEDfmIVBT81_9vndpJX2kFK6x1Xfza_wvmhiVozQRSVwvUD08xuxRHw5F_p6Q-YLIau_BGfxdlK2pNG-NLKRx2jxd7-O-3RUzkMNoib-tR7_1a6SI4rilgf2SGubdCI4jVgA86giMIYq66RBvt-BiWIwP6LT_4mDh6f_j3RKmullHkeX0iGg"/>
</div>
<div class="p-6 flex flex-col flex-1">
<div class="flex justify-between items-start mb-2">
<h3 class="font-headline-md text-headline-md text-primary">Compliance Shield</h3>
<span class="font-label-md text-label-md text-secondary">$1,800/yr</span>
</div>
<p class="font-body-sm text-body-sm text-on-surface-variant mb-6 flex-1">Automated compliance mapping for GDPR, HIPAA, and SOC2. Real-time gap analysis and documentation generator.</p>
<div class="flex items-center justify-between pt-4 border-t border-outline-variant">
<button class="text-secondary font-label-md text-label-md hover:underline">View Details</button>
<button class="bg-[#10B981] text-white px-4 py-2 rounded-lg font-label-md text-label-md hover:bg-[#059669] transition-colors">Request Quote</button>
</div>
</div>
</div>
</div>
<!-- Pagination / Load More -->
<div class="mt-16 flex justify-center">
<button class="flex items-center gap-2 border-[1.5px] border-[#0F172A] text-[#0F172A] px-8 py-3 rounded-lg font-label-md text-label-md hover:bg-surface-container-high transition-all active:scale-95">
                Load More Solutions
                <span class="material-symbols-outlined">expand_more</span>
</button>
</div>
</main>
<!-- BottomNavBar (Mobile Only) -->
<nav class="fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-2 pb-safe bg-surface dark:bg-inverse-surface h-16 border-t border-outline-variant dark:border-outline shadow-lg md:hidden">
<button class="flex flex-col items-center justify-center bg-secondary-container dark:bg-on-secondary-fixed-variant text-on-secondary-container dark:text-secondary-fixed rounded-2xl px-4 py-1 transition-transform active:scale-90">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
<span class="font-label-sm text-label-sm-mobile">Catalog</span>
</button>
<button class="flex flex-col items-center justify-center text-on-surface-variant dark:text-surface-variant px-4 py-1 active:bg-surface-container-high transition-transform active:scale-90">
<span class="material-symbols-outlined">event</span>
<span class="font-label-sm text-label-sm-mobile">Schedule</span>
</button>
<button class="flex flex-col items-center justify-center text-on-surface-variant dark:text-surface-variant px-4 py-1 active:bg-surface-container-high transition-transform active:scale-90">
<span class="material-symbols-outlined">person</span>
<span class="font-label-sm text-label-sm-mobile">Profile</span>
</button>
<button class="flex flex-col items-center justify-center text-on-surface-variant dark:text-surface-variant px-4 py-1 active:bg-surface-container-high transition-transform active:scale-90">
<span class="material-symbols-outlined">more_horiz</span>
<span class="font-label-sm text-label-sm-mobile">Menu</span>
</button>
</nav>
<script>
        // Micro-interaction for hover states and button ripples
        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('mousedown', function(e) {
                this.style.opacity = '0.8';
            });
            button.addEventListener('mouseup', function(e) {
                this.style.opacity = '1';
            });
            button.addEventListener('mouseleave', function(e) {
                this.style.opacity = '1';
            });
        });

        // Simple smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body></html>