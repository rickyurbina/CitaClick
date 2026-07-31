@extends('layouts.cliente')

@section('page_title', 'Catálogo y Agendamiento')

@section('content')
    <div class="max-w-container-max mx-auto">
        <!-- Catálogo de Soluciones -->
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
                        <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB8hlBuIICJRT9MZfcsz3N7vjrwoAY4zFwbD05A__dauRvQP4jX_NE7fe1Z40l__25nDLfu6Y1NxW2UBgak7JgDIO9H718FkyWByuSqMIFCVdlyV-FgThIwY9R6Hgk1UzcicQYx4PCe913IiDZQDuXIXf19Jp8kYLuJ-asml4-FwPf9Bp8jQ19Ca5y0lANNRE1dU3maLw3myULSqjKW91ilnwo5_GtU0WAvLBvGUOxiYGSWDqw8Z1kBvg" alt="Sistema Sentinel v4">
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
                        <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDRvHjbC36qSUIitDPAKNN1GyGSRHcJ_k8eP5mK52kDB06z7UEqW1gWShDHA1-3FlJSCVKa-KfYZlB5xOR31JScX3LJRK8v1Eh1uZ8b-1iKG8wgSvwmyTgVfTbkpZRijIVzjtDv9q69H___Z91ZPLkaW7NJVgOgONa4Z0QDiQoeSjVt5_xpYbCt7EmCaM2p6p6w4lvoWQB4uK8317zWXkV3sFzsZ9e7r9BVa-4mv7ejKZb677Vm-8lJYA" alt="Módulo Quantum Sync">
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
                        <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA0_U_jNYwLSpQlYmmd1vwLPjwBqHhz7BD6xwnH6f3yWbOAmr-gZARIMbFX8yigtNvz-r_3QCMejnZHVSLWMqcDA_8QxQdth1oDL3gxgHcLu34d-vZsE1L7qj7XSVdlZELzuDqrRMiZIOGZdVahEbjkOGztUMG7aTD6o6rZcYN60i6jDsM-pmOy-s4JdeLzKHVYUOJCaHF8TdZz4nhdSw-oHq1r6mZH39hM9X7AIl9cziMJP0LYM7hjBg" alt="Acceso Biométrico X1">
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
                        <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDeGh2PgSKLvJaavbU3guDfmOkv_F-1DbXgyo5IcGlfoeAO5g22eWy3bM3KESAQnYNyErY910_MaXH_v8VfpP2HlIv_yw1shk9pj4N2-ZvCAg5suIj1fiLZb0NlsjhwUTa7Y7cX0mF8zJjHR_2ELaqBB_OoTaJef6zIVERZw-BqPCFDFDZZZIF9GblW7PcsZronXcK6ZtPkRC0K9EyraKdo1RPxoPt9p9ABIDoyexRwOFVVEx8C6qhr7g" alt="Visión Térmica Pro">
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

        <!-- Agendamiento de Servicios -->
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
                                <span>L</span><span>M</span><span>M</span><span>J</span><span>V</span><span>S</span><span>D</span>
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
                            </div>
                            <div class="space-y-sm mb-lg border-l-2 border-secondary-container pl-md">
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
                        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-secondary opacity-20 rounded-full blur-3xl"></div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('button').forEach(btn => {
            btn.addEventListener('click', function() {
                if(!this.classList.contains('opacity-40') && !this.classList.contains('opacity-30')) {
                    console.log('Action performed: ' + this.innerText.trim());
                }
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.5);
            box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.04);
        }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
@endpush