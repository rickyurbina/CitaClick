@extends('layouts.admin')

@section('page_title', 'Gestión de Negocios')

@section('content')
    <div class="flex justify-between items-end mb-lg">
        <div>
            <nav class="flex items-center gap-xs text-on-surface-variant font-label-sm mb-xs">
                <a class="hover:text-primary" href="#">Dashboard</a>
                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                <span class="text-primary font-bold">Negocios</span>
            </nav>
            <h3 class="font-display-lg text-display-lg text-on-surface">Listado Maestro</h3>
            <p class="text-on-surface-variant font-body-md mt-xs">Administra los parámetros de facturación y contacto de tus empresas aliadas.</p>
        </div>
        <div class="flex gap-md">
            <button class="flex items-center gap-sm px-lg py-sm border border-outline rounded font-label-md text-on-surface hover:bg-surface-container-low transition-colors">
                <span class="material-symbols-outlined">filter_list</span>
                Filtrar
            </button>
            <a href="{{ route('admin.negocios.create') }}" class="flex items-center gap-sm px-lg py-sm bg-primary text-on-primary rounded font-label-md hover:opacity-90 transition-all shadow-sm">
                <span class="material-symbols-outlined">add</span>
                Agregar Negocio
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-lg mb-xl">
        <div class="bg-surface-container-lowest p-md border border-outline-variant rounded shadow-sm">
            <div class="flex justify-between items-start mb-sm">
                <div class="p-xs bg-primary/10 rounded">
                    <span class="material-symbols-outlined text-primary">store</span>
                </div>
                <span class="text-green-600 font-label-sm">+4%</span>
            </div>
            <p class="text-on-surface-variant font-label-sm">Negocios Totales</p>
            <p class="text-headline-md font-bold text-on-surface">128</p>
        </div>
        <div class="bg-surface-container-lowest p-md border border-outline-variant rounded shadow-sm">
            <div class="flex justify-between items-start mb-sm">
                <div class="p-xs bg-green-100 rounded">
                    <span class="material-symbols-outlined text-green-700">task_alt</span>
                </div>
                <span class="text-on-surface-variant font-label-sm">92%</span>
            </div>
            <p class="text-on-surface-variant font-label-sm">Activos</p>
            <p class="text-headline-md font-bold text-on-surface">115</p>
        </div>
        <div class="bg-surface-container-lowest p-md border border-outline-variant rounded shadow-sm">
            <div class="flex justify-between items-start mb-sm">
                <div class="p-xs bg-amber-100 rounded">
                    <span class="material-symbols-outlined text-amber-700">pending</span>
                </div>
                <span class="text-red-500 font-label-sm">Pend. pago</span>
            </div>
            <p class="text-on-surface-variant font-label-sm">Por Revisar</p>
            <p class="text-headline-md font-bold text-on-surface">8</p>
        </div>
        <div class="bg-surface-container-lowest p-md border border-outline-variant rounded shadow-sm">
            <div class="flex justify-between items-start mb-sm">
                <div class="p-xs bg-blue-100 rounded">
                    <span class="material-symbols-outlined text-blue-700">payments</span>
                </div>
            </div>
            <p class="text-on-surface-variant font-label-sm">Cobros Mes</p>
            <p class="text-headline-md font-bold text-on-surface">$14,250</p>
        </div>
    </div>

    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low border-b border-outline-variant">
                        <th class="px-lg py-md font-label-sm text-on-surface-variant uppercase tracking-wider">Negocio</th>
                        <th class="px-lg py-md font-label-sm text-on-surface-variant uppercase tracking-wider">Contacto</th>
                        <th class="px-lg py-md font-label-sm text-on-surface-variant uppercase tracking-wider">Dueño</th>
                        <th class="px-lg py-md font-label-sm text-on-surface-variant uppercase tracking-wider">Contratación</th>
                        <th class="px-lg py-md font-label-sm text-on-surface-variant uppercase tracking-wider text-center">Estado</th>
                        <th class="px-lg py-md font-label-sm text-on-surface-variant uppercase tracking-wider">Sig. Pago</th>
                        <th class="px-lg py-md font-label-sm text-on-surface-variant uppercase tracking-wider text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    <tr class="hover:bg-surface-container/50 transition-colors group">
                        <td class="px-lg py-md">
                            <div class="flex items-center gap-md">
                                <div class="w-10 h-10 rounded-full overflow-hidden border border-outline-variant flex-shrink-0 bg-white">
                                    <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDyxLqiPNUG4AyxP8zD0146k-vEse96uMF04DFmMzfQZqvKDlaNdlRmx04sCKKVh15rjefOtBfiJvnYtaFB0se4wjEgZ-Xo6IPBj1l_482EER_NL8Y4LCipEoKfl0NQnlQrbTsRb-EYkLvt5Pp8XYvV32VTI9XVcWiy1B_CtCnYE4dah2xrmRGUNPryxtf_mq7lVfK9aFPS22eEDK3yxPiN-ejRoNtkjkP08HRmJL6FwaJcnJ__AZj3VA" alt="Logo">
                                </div>
                                <div>
                                    <p class="font-label-md text-on-surface group-hover:text-primary transition-colors">Trattoria Bella</p>
                                    <p class="font-body-sm text-on-surface-variant">+52 55 1234 5678</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-lg py-md font-body-md text-on-surface">Marco Santini</td>
                        <td class="px-lg py-md font-body-md text-on-surface">Santini Group S.A.</td>
                        <td class="px-lg py-md font-body-md text-on-surface-variant">12 Ene 2023</td>
                        <td class="px-lg py-md text-center">
                            <span class="px-sm py-1 bg-green-100 text-green-800 rounded-full font-label-sm">Activo</span>
                        </td>
                        <td class="px-lg py-md font-body-md text-on-surface">15 May 2024</td>
                        <td class="px-lg py-md text-right">
                            <div class="flex justify-end gap-sm">
                                <button class="w-8 h-8 rounded hover:bg-primary/10 text-primary transition-all flex items-center justify-center" title="Cambiar Estado"><span class="material-symbols-outlined text-[18px]">sync</span></button>
                                <a href="{{ route('admin.negocios.edit', ['id' => 1]) }}" class="w-8 h-8 rounded hover:bg-primary/10 text-primary transition-all flex items-center justify-center" title="Editar">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </a>
                                <button class="w-8 h-8 rounded hover:bg-secondary/10 text-secondary transition-all flex items-center justify-center" title="Ver Detalles">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <!-- Más filas... -->
                </tbody>
            </table>
        </div>
        <div class="px-lg py-md bg-surface-container-lowest border-t border-outline-variant flex justify-between items-center">
            <p class="font-body-sm text-on-surface-variant">Mostrando <span class="font-bold text-on-surface">5</span> de <span class="font-bold text-on-surface">128</span> negocios</p>
            <div class="flex items-center gap-sm">
                <button class="w-8 h-8 flex items-center justify-center rounded border border-outline-variant text-on-surface-variant hover:bg-surface-container transition-colors disabled:opacity-50" disabled>
                    <span class="material-symbols-outlined">chevron_left</span>
                </button>
                <div class="flex gap-xs">
                    <button class="w-8 h-8 flex items-center justify-center rounded bg-primary text-on-primary font-label-sm">1</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded hover:bg-surface-container font-label-sm text-on-surface">2</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded hover:bg-surface-container font-label-sm text-on-surface">3</button>
                    <span class="px-1 text-on-surface-variant">...</span>
                    <button class="w-8 h-8 flex items-center justify-center rounded hover:bg-surface-container font-label-sm text-on-surface">26</button>
                </div>
                <button class="w-8 h-8 flex items-center justify-center rounded border border-outline-variant text-on-surface-variant hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined">chevron_right</span>
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('tr').forEach(row => {
            row.addEventListener('click', (e) => {
                if (e.target.closest('button')) return;
                console.log('Row selected:', row.querySelector('.font-label-md')?.innerText);
            });
        });

        const searchInput = document.querySelector('input[type="text"]');
        if (searchInput) {
            searchInput.addEventListener('focus', () => {
                searchInput.parentElement.classList.add('ring-2', 'ring-primary/20', 'border-primary');
            });
            searchInput.addEventListener('blur', () => {
                searchInput.parentElement.classList.remove('ring-2', 'ring-primary/20', 'border-primary');
            });
        }
    </script>
@endpush