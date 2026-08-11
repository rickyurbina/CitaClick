<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name', 'CitaClick') }}</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
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
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        full: "9999px"
                    },
                    spacing: {
                        gutter: "24px",
                        "3xl": "64px",
                        "2xl": "48px",
                        "margin-desktop": "32px",
                        "container-max": "1280px",
                        lg: "24px",
                        base: "4px",
                        xl: "32px",
                        xs: "4px",
                        md: "16px",
                        "margin-mobile": "16px",
                        sm: "8px"
                    },
                    fontFamily: {
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
                    fontSize: {
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
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9ff; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .login-card {
            box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.04), 0 2px 4px -1px rgba(15, 23, 42, 0.02);
        }
        .focus-ring:focus-within {
            border-color: #006c49;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
        }
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
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.5);
            box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.04);
        }
        .card-shadow, .form-shadow {
            box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.04), 0 2px 4px -1px rgba(15, 23, 42, 0.02);
        }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    @fluxAppearance
</head>
<body class="min-h-screen bg-surface text-on-background antialiased">
    {{ $slot }}
    @stack('scripts')
    @fluxScripts
</body>
</html>
