<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CitaClick</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        secondary: "#006c49",
                        surface: "#f8f9ff",
                        "surface-container-lowest": "#ffffff",
                        "on-surface": "#0b1c30",
                        "on-surface-variant": "#45464d",
                        "outline-variant": "#c6c6cd",
                        primary: "#000000",
                        "on-secondary": "#ffffff",
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
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 bg-surface text-on-surface">
    <main class="w-full max-w-lg bg-surface-container-lowest border border-outline-variant rounded-xl p-8 shadow-sm text-center">
        <h1 class="text-3xl font-bold tracking-tight mb-2">CitaClick</h1>
        <p class="text-on-surface-variant mb-8">Sistema de gestión y agendamiento de citas</p>

        <div class="space-y-3">
            <a href="{{ route('superadmin') }}"
               class="flex items-center justify-center gap-2 w-full h-12 bg-secondary text-on-secondary rounded-lg font-semibold hover:opacity-90 transition">
                <span class="material-symbols-outlined text-[20px]">admin_panel_settings</span>
                Panel SuperAdmin
            </a>
            @if (Route::has('login'))
            <a href="{{ route('login') }}"
               class="flex items-center justify-center gap-2 w-full h-12 border border-outline-variant rounded-lg font-semibold hover:bg-surface transition">
                <span class="material-symbols-outlined text-[20px]">login</span>
                Iniciar sesión
            </a>
            @endif
        </div>

        <p class="mt-8 text-sm text-on-surface-variant">
            Acceso cliente: <code class="text-secondary">/{slug-empresa}</code><br>
            Acceso panel: <code class="text-secondary">/{slug-empresa}/panel</code>
        </p>
    </main>
</body>
</html>
