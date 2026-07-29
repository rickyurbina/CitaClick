@extends('layouts.colaborador')

@section('page_title', 'Gestión de Citas')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-4 gap-lg mb-2xl">
        <div class="bg-surface p-lg rounded-xl card-shadow border border-outline-variant col-span-1">
            <div class="flex items-center justify-between mb-sm">
                <span class="text-on-surface-variant font-label-sm text-label-sm">Citas Hoy</span>
                <span class="material-symbols-outlined text-secondary">today</span>
            </div>
            <div class="font-headline-lg text-headline-lg text-primary">12</div>
            <div class="text-body-sm font-body-sm text-secondary flex items-center gap-1 mt-xs">
                <span class="material-symbols-outlined text-[16px]">trending_up</span>
                <span>+4 que ayer</span>
            </div>
        </div>
        <div class="bg-surface p-lg rounded-xl card-shadow border border-outline-variant col-span-1">
            <div class="flex items-center justify-between mb-sm">
                <span class="text-on-surface-variant font-label-sm text-label-sm">Ingresos Hoy</span>
                <span class="material-symbols-outlined text-secondary">payments</span>
            </div>
            <div class="font-headline-md text-headline-md text-primary">$12,450.00</div>
            <div class="text-body-sm font-body-sm text-secondary flex items-center gap-1 mt-xs">
                <span class="material-symbols-outlined text-[16px]">trending_up</span>
                <span>+12% vs ayer</span>
            </div>
        </div>
    </div>

    <div class="bg-surface rounded-xl card-shadow border border-outline-variant overflow-hidden">
        <div class="px-lg py-md flex flex-col md:flex-row justify-between items-start md:items-center gap-md border-b border-outline-variant">
            <div>
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
                    <tr class="hover:bg-surface-container-lowest transition-colors">
                        <td class="px-lg py-md font-body-md text-body-md text-on-surface">24 Oct, 2023</td>
                        <td class="px-lg py-md font-body-md text-body-md text-on-surface">09:30 AM</td>
                        <td class="px-lg py-md">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-secondary"></div>
                                <span class="font-body-md text-body-md text-on-surface">Consultoría de Seguridad</span>
                            </div>
                        </td>
                        <td class="px-lg py-md"><span class="px-sm py-1 bg-secondary-container text-on-secondary-fixed-variant text-label-sm font-label-sm rounded-full">Confirmada</span></td>
                        <td class="px-lg py-md text-right">
                            <div class="flex justify-end gap-sm">
                                <button class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-container-high rounded-lg transition-all" title="Editar"><span class="material-symbols-outlined text-[20px]">edit</span></button>
                                <button class="p-2 text-on-surface-variant hover:text-error hover:bg-error-container rounded-lg transition-all" title="Eliminar"><span class="material-symbols-outlined text-[20px]">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-surface-container-lowest transition-colors">
                        <td class="px-lg py-md font-body-md text-body-md text-on-surface">24 Oct, 2023</td>
                        <td class="px-lg py-md font-body-md text-body-md text-on-surface">11:00 AM</td>
                        <td class="px-lg py-md">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-primary"></div>
                                <span class="font-body-md text-body-md text-on-surface">Auditoría Cloud</span>
                            </div>
                        </td>
                        <td class="px-lg py-md"><span class="px-sm py-1 bg-surface-container-high text-on-surface-variant text-label-sm font-label-sm rounded-full">Pendiente</span></td>
                        <td class="px-lg py-md text-right">
                            <div class="flex justify-end gap-sm">
                                <button class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-container-high rounded-lg transition-all" title="Editar"><span class="material-symbols-outlined text-[20px]">edit</span></button>
                                <button class="p-2 text-on-surface-variant hover:text-error hover:bg-error-container rounded-lg transition-all" title="Eliminar"><span class="material-symbols-outlined text-[20px]">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-surface-container-lowest transition-colors">
                        <td class="px-lg py-md font-body-md text-body-md text-on-surface">25 Oct, 2023</td>
                        <td class="px-lg py-md font-body-md text-body-md text-on-surface">02:15 PM</td>
                        <td class="px-lg py-md">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-secondary"></div>
                                <span class="font-body-md text-body-md text-on-surface">Soporte Técnico Enterprise</span>
                            </div>
                        </td>
                        <td class="px-lg py-md"><span class="px-sm py-1 bg-secondary-container text-on-secondary-fixed-variant text-label-sm font-label-sm rounded-full">Confirmada</span></td>
                        <td class="px-lg py-md text-right">
                            <div class="flex justify-end gap-sm">
                                <button class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-container-high rounded-lg transition-all" title="Editar"><span class="material-symbols-outlined text-[20px]">edit</span></button>
                                <button class="p-2 text-on-surface-variant hover:text-error hover:bg-error-container rounded-lg transition-all" title="Eliminar"><span class="material-symbols-outlined text-[20px]">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-surface-container-lowest transition-colors">
                        <td class="px-lg py-md font-body-md text-body-md text-on-surface">25 Oct, 2023</td>
                        <td class="px-lg py-md font-body-md text-body-md text-on-surface">04:45 PM</td>
                        <td class="px-lg py-md">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-tertiary"></div>
                                <span class="font-body-md text-body-md text-on-surface">Formación de Empleados</span>
                            </div>
                        </td>
                        <td class="px-lg py-md"><span class="px-sm py-1 bg-error-container text-on-error-container text-label-sm font-label-sm rounded-full">Cancelada</span></td>
                        <td class="px-lg py-md text-right">
                            <div class="flex justify-end gap-sm">
                                <button class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-container-high rounded-lg transition-all" title="Editar"><span class="material-symbols-outlined text-[20px]">edit</span></button>
                                <button class="p-2 text-on-surface-variant hover:text-error hover:bg-error-container rounded-lg transition-all" title="Eliminar"><span class="material-symbols-outlined text-[20px]">delete</span></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="px-lg py-md bg-surface-container-low flex justify-between items-center border-t border-outline-variant">
            <span class="text-label-sm font-label-sm text-on-surface-variant">Mostrando 4 de 128 citas</span>
            <div class="flex gap-sm">
                <button class="p-2 hover:bg-surface-container-high rounded transition-colors disabled:opacity-30" disabled>
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
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('button, a').forEach(el => {
            el.addEventListener('mousedown', () => { el.style.transform = 'scale(0.97)'; });
            el.addEventListener('mouseup', () => { el.style.transform = 'scale(1)'; });
            el.addEventListener('mouseleave', () => { el.style.transform = 'scale(1)'; });
        });
    </script>
@endpush