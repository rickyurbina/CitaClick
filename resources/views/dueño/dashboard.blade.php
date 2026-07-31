@extends('layouts.dueño')

@section('page_title', 'Resumen Financiero')

@section('content')
    <div class="max-w-container-max mx-auto">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h1 class="font-headline-lg text-headline-lg text-on-background">Resumen Financiero</h1>
                <p class="text-on-surface-variant font-body-md">Análisis en tiempo real de ingresos y márgenes operativos.</p>
            </div>
            <div class="flex gap-sm">
                <button class="px-md py-2 border border-outline text-label-md font-semibold rounded-lg flex items-center gap-2 hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                    Last 30 Days
                </button>
                <button class="px-md py-2 bg-primary text-white text-label-md font-semibold rounded-lg flex items-center gap-2 hover:opacity-90 transition-opacity">
                    <span class="material-symbols-outlined text-[18px]">download</span>
                    Export PDF
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-lg mb-xl">
            <div class="bg-white rounded-xl p-lg border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-surface-container-low rounded-lg">
                        <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">account_balance_wallet</span>
                    </div>
                    <div class="flex items-center gap-1 text-secondary font-bold text-label-sm">
                        <span class="material-symbols-outlined text-[16px]">trending_up</span>
                        +12.4%
                    </div>
                </div>
                <p class="text-on-surface-variant font-label-md mb-1">Ingreso Total de Efectivo</p>
                <h3 class="font-headline-md text-headline-md text-on-background">$248,390.00</h3>
                <p class="text-[12px] text-on-surface-variant mt-2 font-body-sm">Proyección mensual superada en un 5%</p>
            </div>
            <div class="bg-white rounded-xl p-lg border-2 border-secondary shadow-lg relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 -mr-16 -mt-16 bg-secondary opacity-5 rounded-full"></div>
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-secondary-container rounded-lg">
                        <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">payments</span>
                    </div>
                    <span class="px-2 py-1 bg-secondary text-white rounded text-[10px] font-bold tracking-wider uppercase">En Tiempo Real</span>
                </div>
                <p class="text-on-surface-variant font-label-md mb-1">Ganancia Total del Día</p>
                <h3 class="font-headline-md text-headline-md text-secondary font-extrabold">$14,205.50</h3>
                <div class="flex items-center gap-2 mt-2">
                    <div class="w-full bg-surface-container h-1 rounded-full">
                        <div class="bg-secondary h-1 rounded-full" style="width: 78%"></div>
                    </div>
                    <span class="text-label-sm font-bold text-on-surface">78%</span>
                </div>
            </div>
            <div class="bg-white rounded-xl p-lg border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-surface-container-low rounded-lg">
                        <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">analytics</span>
                    </div>
                    <div class="flex items-center gap-1 text-secondary font-bold text-label-sm">
                        <span class="material-symbols-outlined text-[16px]">arrow_upward</span>
                        2.1% pts
                    </div>
                </div>
                <p class="text-on-surface-variant font-label-md mb-1">Margen de Beneficio</p>
                <h3 class="font-headline-md text-headline-md text-on-background">34.2%</h3>
                <p class="text-[12px] text-on-surface-variant mt-2 font-body-sm">Superior al promedio del sector (28%)</p>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-xl">
            <div class="col-span-12 lg:col-span-8 bg-white rounded-xl p-lg border border-outline-variant shadow-sm h-[450px] flex flex-col">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="font-headline-md text-label-md text-on-background">Tendencia de Entrada de Efectivo</h4>
                    <div class="flex gap-2">
                        <span class="flex items-center gap-1 text-[12px] font-medium text-on-surface-variant"><span class="w-3 h-3 rounded-full bg-secondary"></span> Ingresos</span>
                        <span class="flex items-center gap-1 text-[12px] font-medium text-on-surface-variant"><span class="w-3 h-3 rounded-full bg-primary-container"></span> Meta</span>
                    </div>
                </div>
                <div class="flex-1 relative">
                    <svg class="w-full h-full" preserveAspectRatio="none" viewBox="0 0 800 300">
                        <defs>
                            <linearGradient id="grad1" x1="0%" x2="0%" y1="0%" y2="100%">
                                <stop offset="0%" style="stop-color:rgba(16, 185, 129, 0.4);stop-opacity:1"></stop>
                                <stop offset="100%" style="stop-color:rgba(16, 185, 129, 0);stop-opacity:1"></stop>
                            </linearGradient>
                        </defs>
                        <line stroke="#f1f5f9" stroke-width="1" x1="0" x2="800" y1="50" y2="50"></line>
                        <line stroke="#f1f5f9" stroke-width="1" x1="0" x2="800" y1="125" y2="125"></line>
                        <line stroke="#f1f5f9" stroke-width="1" x1="0" x2="800" y1="200" y2="200"></line>
                        <line stroke="#f1f5f9" stroke-width="1" x1="0" x2="800" y1="275" y2="275"></line>
                        <path d="M0,250 Q100,220 200,235 T400,150 T600,100 T800,80 L800,300 L0,300 Z" fill="url(#grad1)"></path>
                        <path d="M0,250 Q100,220 200,235 T400,150 T600,100 T800,80" fill="none" stroke="#10B981" stroke-linecap="round" stroke-width="4"></path>
                        <line opacity="0.3" stroke="#131b2e" stroke-dasharray="8,4" stroke-width="2" x1="0" x2="800" y1="120" y2="120"></line>
                        <circle cx="200" cy="235" fill="#10B981" r="5"></circle>
                        <circle cx="400" cy="150" fill="#10B981" r="5"></circle>
                        <circle cx="600" cy="100" fill="#10B981" r="5"></circle>
                    </svg>
                    <div class="flex justify-between mt-4 text-label-sm text-on-surface-variant font-semibold">
                        <span>Week 01</span>
                        <span>Week 02</span>
                        <span>Week 03</span>
                        <span>Week 04</span>
                        <span>Week 05</span>
                    </div>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-4 bg-white rounded-xl p-lg border border-outline-variant shadow-sm h-[450px] flex flex-col">
                <h4 class="font-headline-md text-label-md text-on-background mb-6">Fuentes de Entrada</h4>
                <div class="flex-1 space-y-6 overflow-y-auto pr-2">
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-low flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary text-[20px]">shield</span>
                                </div>
                                <div>
                                    <p class="font-label-md text-on-background">Servicios de Seguridad</p>
                                    <p class="text-[12px] text-on-surface-variant">52% del total</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-label-md text-on-background">$129,162</p>
                                <p class="text-[12px] text-secondary font-bold">+8.4%</p>
                            </div>
                        </div>
                        <div class="w-full bg-surface-container h-1.5 rounded-full overflow-hidden">
                            <div class="bg-secondary h-full" style="width: 52%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-low flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary text-[20px]">psychology</span>
                                </div>
                                <div>
                                    <p class="font-label-md text-on-background">Consultoría</p>
                                    <p class="text-[12px] text-on-surface-variant">28% del total</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-label-md text-on-background">$69,549</p>
                                <p class="text-[12px] text-secondary font-bold">+12.1%</p>
                            </div>
                        </div>
                        <div class="w-full bg-surface-container h-1.5 rounded-full overflow-hidden">
                            <div class="bg-secondary h-full" style="width: 28%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-low flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary text-[20px]">key</span>
                                </div>
                                <div>
                                    <p class="font-label-md text-on-background">Licencias de Software</p>
                                    <p class="text-[12px] text-on-surface-variant">20% del total</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-label-md text-on-background">$49,679</p>
                                <p class="text-[12px] text-on-surface-variant font-bold">-2.3%</p>
                            </div>
                        </div>
                        <div class="w-full bg-surface-container h-1.5 rounded-full overflow-hidden">
                            <div class="bg-secondary h-full" style="width: 20%"></div>
                        </div>
                    </div>
                </div>
                <button class="mt-6 w-full py-2 border-2 border-primary text-primary rounded-lg font-label-md hover:bg-primary hover:text-white transition-all">Ver Informe Detallado</button>
            </div>
            <div class="col-span-12 bg-white rounded-xl border border-outline-variant shadow-sm overflow-hidden">
                <div class="p-lg border-b border-outline-variant flex justify-between items-center">
                    <h4 class="font-headline-md text-label-md text-on-background">Últimas Entradas de Efectivo</h4>
                    <div class="flex items-center gap-md">
                        <span class="text-label-sm text-on-surface-variant">Filtrar por: </span>
                        <select class="text-label-sm bg-surface-container-low border-none rounded-lg focus:ring-secondary">
                            <option>Todos los servicios</option>
                            <option>Seguridad</option>
                            <option>Consultoría</option>
                        </select>
                    </div>
                </div>
                <table class="w-full text-left">
                    <thead class="bg-surface-container-low text-label-sm text-on-surface-variant font-bold uppercase tracking-wider">
                        <tr>
                            <th class="px-lg py-4">Cliente / Origen</th>
                            <th class="px-lg py-4">ID Transacción</th>
                            <th class="px-lg py-4">Fecha</th>
                            <th class="px-lg py-4">Servicio</th>
                            <th class="px-lg py-4">Estado</th>
                            <th class="px-lg py-4 text-right">Monto</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant font-body-sm text-on-surface">
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="px-lg py-4 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-bold text-[10px]">GM</div>
                                <span class="font-semibold">Global Maritime Ltd</span>
                            </td>
                            <td class="px-lg py-4 font-mono text-on-surface-variant">#TXN-9021</td>
                            <td class="px-lg py-4 text-on-surface-variant">Oct 12, 2023</td>
                            <td class="px-lg py-4"><span class="px-2 py-1 bg-surface-container rounded-md text-[11px] font-medium">Seguridad</span></td>
                            <td class="px-lg py-4"><span class="flex items-center gap-1.5 text-secondary font-bold text-[11px]"><span class="w-2 h-2 rounded-full bg-secondary"></span> Completado</span></td>
                            <td class="px-lg py-4 text-right font-bold">$12,450.00</td>
                        </tr>
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="px-lg py-4 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary-container text-white flex items-center justify-center font-bold text-[10px]">TX</div>
                                <span class="font-semibold">TechX Solutions</span>
                            </td>
                            <td class="px-lg py-4 font-mono text-on-surface-variant">#TXN-9018</td>
                            <td class="px-lg py-4 text-on-surface-variant">Oct 11, 2023</td>
                            <td class="px-lg py-4"><span class="px-2 py-1 bg-surface-container rounded-md text-[11px] font-medium">Software</span></td>
                            <td class="px-lg py-4"><span class="flex items-center gap-1.5 text-secondary font-bold text-[11px]"><span class="w-2 h-2 rounded-full bg-secondary"></span> Completado</span></td>
                            <td class="px-lg py-4 text-right font-bold">$4,820.00</td>
                        </tr>
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="px-lg py-4 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center font-bold text-[10px]">AS</div>
                                <span class="font-semibold">Alpha Systems</span>
                            </td>
                            <td class="px-lg py-4 font-mono text-on-surface-variant">#TXN-9015</td>
                            <td class="px-lg py-4 text-on-surface-variant">Oct 10, 2023</td>
                            <td class="px-lg py-4"><span class="px-2 py-1 bg-surface-container rounded-md text-[11px] font-medium">Consultoría</span></td>
                            <td class="px-lg py-4"><span class="flex items-center gap-1.5 text-on-surface-variant font-bold text-[11px]"><span class="w-2 h-2 rounded-full bg-outline"></span> Pendiente</span></td>
                            <td class="px-lg py-4 text-right font-bold">$1,200.00</td>
                        </tr>
                    </tbody>
                </table>
                <div class="p-4 bg-surface-container-low text-center">
                    <button class="text-label-sm font-bold text-secondary hover:underline">Ver todas las transacciones recientes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.bg-white');
            cards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-4px)';
                    card.style.transition = 'transform 0.2s ease-out';
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
@endpush