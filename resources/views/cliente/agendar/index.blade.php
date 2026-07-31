@extends('layouts.cliente')

@section('page_title', 'Catálogo y Agendamiento')

@section('content')
    <div class="max-w-container-max mx-auto">
        <!-- Catálogo de Soluciones (sin cambios) -->
        <section class="mb-2xl">
            <div class="flex items-center justify-between mb-lg">
                <h2 class="font-headline-lg text-headline-lg text-primary">Catálogo de Soluciones</h2>
                <button class="text-secondary font-label-md text-label-md flex items-center gap-1 hover:underline">
                    Ver todo <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </button>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-lg">
                <!-- Producto 1 -->
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
                <!-- Producto 2 -->
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
                <!-- Producto 3 -->
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
                <!-- Producto 4 -->
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

        <!-- Agendamiento -->
        <section class="border-t border-outline-variant pt-2xl">
            <div class="mb-lg">
                <h2 class="font-headline-lg text-headline-lg text-primary">Agendamiento de Servicios</h2>
                <p class="text-on-surface-variant font-body-md text-body-md mt-xs">Seleccione su ventana de prioridad y horario para la instalación.</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-xl">
                <!-- Columna izquierda: días y horas -->
                <div class="lg:col-span-2 space-y-xl">
                    <!-- Ventana de prioridad (7 días) -->
                    <div class="glass-card rounded-xl p-md">
                        <div class="flex items-center justify-between mb-md px-2">
                            <h3 class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant">Ventana de Prioridad</h3>
                            <div class="flex gap-2">
                                <button class="p-1 rounded-full hover:bg-surface-container-low active:scale-95 transition-transform" onclick="changeWeek(-1)"><span class="material-symbols-outlined">chevron_left</span></button>
                                <button class="p-1 rounded-full hover:bg-surface-container-low active:scale-95 transition-transform" onclick="changeWeek(1)"><span class="material-symbols-outlined">chevron_right</span></button>
                            </div>
                        </div>
                        <div class="flex justify-between items-center overflow-x-auto hide-scrollbar gap-sm px-2" id="weekDays">
                            <!-- Generado por JS -->
                        </div>
                    </div>
                    <!-- Horarios disponibles -->
                    <div class="glass-card rounded-xl p-md">
                        <h3 class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant mb-md px-2">Horarios Disponibles</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-md px-2" id="timeSlots">
                            <button class="time-slot py-3 px-2 rounded-lg border border-outline-variant text-body-sm font-medium hover:border-secondary hover:text-secondary transition-all active:bg-secondary-container" data-time="08:00">08:00 AM</button>
                            <button class="time-slot py-3 px-2 rounded-lg border border-outline-variant text-body-sm font-medium hover:border-secondary hover:text-secondary transition-all active:bg-secondary-container" data-time="09:30">09:30 AM</button>
                            <button class="time-slot py-3 px-2 rounded-lg border-2 border-secondary bg-secondary-container text-on-secondary-container text-body-sm font-bold shadow-sm" data-time="11:00">11:00 AM</button>
                            <button class="time-slot py-3 px-2 rounded-lg border border-outline-variant text-body-sm font-medium hover:border-secondary hover:text-secondary transition-all active:bg-secondary-container" data-time="12:30">12:30 PM</button>
                            <button class="time-slot py-3 px-2 rounded-lg border border-outline-variant text-body-sm font-medium hover:border-secondary hover:text-secondary transition-all active:bg-secondary-container" data-time="14:00">02:00 PM</button>
                            <button class="time-slot py-3 px-2 rounded-lg border border-outline-variant text-body-sm font-medium hover:border-secondary hover:text-secondary transition-all active:bg-secondary-container" data-time="15:30">03:30 PM</button>
                            <button class="time-slot py-3 px-2 rounded-lg border border-outline-variant text-body-sm font-medium hover:border-secondary hover:text-secondary transition-all active:bg-secondary-container" data-time="17:00">05:00 PM</button>
                            <button class="time-slot py-3 px-2 rounded-lg border border-outline-variant text-body-sm font-medium opacity-30 cursor-not-allowed" data-time="18:30" disabled>06:30 PM</button>
                        </div>
                    </div>
                </div>

                <!-- Columna derecha: calendario y resumen -->
                <div class="space-y-xl">
                    <!-- Calendario interactivo -->
                    <div class="glass-card rounded-xl p-md">
                        <h3 class="font-label-md text-label-md uppercase tracking-widest text-on-surface-variant mb-md">Planificación Futura</h3>
                        <div class="p-xs bg-surface-container-low rounded-lg border border-outline-variant">
                            <div class="flex justify-between items-center p-2 mb-2">
                                <span class="font-bold text-body-md" id="currentMonthLabel">Marzo 2024</span>
                                <div class="flex gap-1">
                                    <button onclick="changeMonth(-1)" class="material-symbols-outlined cursor-pointer hover:bg-surface-container-high rounded p-1">chevron_left</button>
                                    <button onclick="changeMonth(1)" class="material-symbols-outlined cursor-pointer hover:bg-surface-container-high rounded p-1">chevron_right</button>
                                </div>
                            </div>
                            <div class="grid grid-cols-7 gap-1 text-center text-[10px] font-bold text-on-surface-variant mb-1">
                                <span>L</span><span>M</span><span>M</span><span>J</span><span>V</span><span>S</span><span>D</span>
                            </div>
                            <div class="grid grid-cols-7 gap-1 text-center text-label-sm" id="calendarDays">
                                <!-- Generado por JS -->
                            </div>
                        </div>
                    </div>

                    <!-- Resumen de cita -->
                    <div class="bg-primary text-on-primary rounded-xl p-lg shadow-xl relative overflow-hidden" id="resumenCita">
                        <div class="relative z-10">
                            <h3 class="font-headline-md text-headline-md mb-md">Resumen de Cita</h3>
                            <div class="mb-md">
                                <label class="block text-label-sm font-medium text-on-primary opacity-70 uppercase tracking-wider mb-1">Nombre Completo</label>
                                <input type="text" placeholder="Ingrese su nombre" class="w-full bg-surface-container-low text-primary px-3 py-2 rounded-lg border border-outline-variant focus:outline-none focus:border-secondary transition-colors text-body-md" id="clienteNombre">
                            </div>
                            <div class="space-y-sm mb-lg border-l-2 border-secondary-container pl-md">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-secondary-fixed text-sm">event</span>
                                    <span class="text-body-md" id="resumenFecha">Selecciona un día</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-secondary-fixed text-sm">schedule</span>
                                    <span class="text-body-md" id="resumenHora">11:00 AM</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-secondary-fixed text-sm">location_on</span>
                                    <span class="text-body-md">Oficinas Centrales</span>
                                </div>
                            </div>
                            <button class="w-full bg-secondary text-on-secondary py-3 rounded-lg font-bold text-body-md hover:brightness-110 active:scale-95 transition-all" onclick="confirmarCita()">Aceptar y Agendar</button>
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
        // ---------- VARIABLES GLOBALES ----------
        let currentDate = new Date();
        let selectedDate = null;
        let selectedTime = '11:00';
        let weekOffset = 0;

        const monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        const dayNames = ['L', 'M', 'M', 'J', 'V', 'S', 'D'];

        // ---------- CALENDARIO ----------
        function renderCalendar(year, month) {
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startOffset = (firstDay.getDay() === 0) ? 6 : firstDay.getDay() - 1;
            const daysInMonth = lastDay.getDate();
            const container = document.getElementById('calendarDays');
            if (!container) return;
            container.innerHTML = '';

            for (let i = 0; i < startOffset; i++) {
                const empty = document.createElement('span');
                empty.className = 'p-2 opacity-20 pointer-events-none';
                empty.textContent = '';
                container.appendChild(empty);
            }

            for (let d = 1; d <= daysInMonth; d++) {
                const daySpan = document.createElement('span');
                const dateStr = `${year}-${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
                daySpan.className = 'p-2 rounded-full cursor-pointer hover:bg-secondary hover:text-on-secondary transition-colors';
                daySpan.textContent = d;
                daySpan.dataset.date = dateStr;
                daySpan.addEventListener('click', function() {
                    selectDate(this.dataset.date);
                });
                if (selectedDate === dateStr) {
                    daySpan.classList.add('bg-secondary', 'text-on-secondary');
                }
                container.appendChild(daySpan);
            }

            const label = document.getElementById('currentMonthLabel');
            if (label) label.textContent = `${monthNames[month]} ${year}`;
        }

        function changeMonth(delta) {
            currentDate.setMonth(currentDate.getMonth() + delta);
            renderCalendar(currentDate.getFullYear(), currentDate.getMonth());
        }

        // ---------- SELECCIÓN DE DÍA ----------
        function selectDate(dateStr) {
            selectedDate = dateStr;
            const parts = dateStr.split('-');
            const fechaObj = new Date(parts[0], parts[1]-1, parts[2]);
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const fechaFormateada = fechaObj.toLocaleDateString('es-ES', options);
            const fechaEl = document.getElementById('resumenFecha');
            if (fechaEl) fechaEl.textContent = fechaFormateada.charAt(0).toUpperCase() + fechaFormateada.slice(1);

            // Refrescar calendario para resaltar el día seleccionado
            renderCalendar(currentDate.getFullYear(), currentDate.getMonth());
            renderWeekDays(); // refrescar semana para sincronizar
        }

        // ---------- VENTANA DE PRIORIDAD (semana) ----------
        function changeWeek(delta) {
            weekOffset += delta;
            renderWeekDays();
        }

        function renderWeekDays() {
            const container = document.getElementById('weekDays');
            if (!container) return;
            container.innerHTML = '';
            const today = new Date();
            const startOfWeek = new Date(today);
            startOfWeek.setDate(today.getDate() - today.getDay() + 1 + weekOffset * 7);

            for (let i = 0; i < 7; i++) {
                const day = new Date(startOfWeek);
                day.setDate(startOfWeek.getDate() + i);
                const dayName = dayNames[i];
                const dayNum = day.getDate();
                const isToday = day.toDateString() === today.toDateString();
                const isPast = day < new Date() && !isToday;
                const dateStr = `${day.getFullYear()}-${String(day.getMonth()+1).padStart(2,'0')}-${String(day.getDate()).padStart(2,'0')}`;
                const isSelected = (selectedDate === dateStr);

                const btn = document.createElement('button');
                btn.className = `flex-shrink-0 w-16 h-20 rounded-xl flex flex-col items-center justify-center border transition-all 
                    ${isSelected ? 'border-2 border-secondary bg-secondary-container text-on-secondary-container shadow-md' : 'border-outline-variant hover:bg-surface-container-low'} 
                    ${isPast ? 'opacity-40 cursor-not-allowed' : ''}`;
                btn.innerHTML = `<span class="text-label-sm font-medium ${isSelected ? 'font-bold uppercase' : 'opacity-60'}">${dayName}</span>
                                 <span class="text-headline-md font-bold">${dayNum}</span>`;
                if (!isPast) {
                    btn.addEventListener('click', function() {
                        selectDate(dateStr);
                        // Sincronizar el mes del calendario
                        currentDate = new Date(day.getFullYear(), day.getMonth(), 1);
                        renderCalendar(currentDate.getFullYear(), currentDate.getMonth());
                    });
                }
                container.appendChild(btn);
            }
        }

        // ---------- SELECCIÓN DE HORA ----------
        document.addEventListener('click', function(e) {
            const slot = e.target.closest('.time-slot');
            if (!slot || slot.disabled) return;
            document.querySelectorAll('.time-slot').forEach(b => {
                b.classList.remove('border-2', 'border-secondary', 'bg-secondary-container', 'text-on-secondary-container', 'font-bold', 'shadow-sm');
                b.classList.add('border', 'border-outline-variant', 'text-body-sm', 'font-medium');
            });
            slot.classList.remove('border', 'border-outline-variant', 'text-body-sm', 'font-medium');
            slot.classList.add('border-2', 'border-secondary', 'bg-secondary-container', 'text-on-secondary-container', 'text-body-sm', 'font-bold', 'shadow-sm');
            selectedTime = slot.dataset.time;
            actualizarHoraResumen(selectedTime);
        });

        function actualizarHoraResumen(time) {
            const [h, m] = time.split(':');
            const hour = parseInt(h);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const hour12 = hour % 12 || 12;
            const horaEl = document.getElementById('resumenHora');
            if (horaEl) horaEl.textContent = `${hour12}:${m} ${ampm}`;
        }

        // ---------- CONFIRMAR CITA ----------
        function confirmarCita() {
            const nombre = document.getElementById('clienteNombre').value.trim() || 'Cliente';
            const fecha = document.getElementById('resumenFecha').textContent;
            const hora = document.getElementById('resumenHora').textContent;
            if (fecha === 'Selecciona un día') {
                alert('Por favor, selecciona una fecha.');
                return;
            }
            alert(`Cita confirmada para ${nombre} el ${fecha} a las ${hora}.`);
        }

        // ---------- INICIALIZACIÓN ----------
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM cargado, inicializando calendario...');
            const today = new Date();
            currentDate = new Date(today.getFullYear(), today.getMonth(), 1);
            renderCalendar(currentDate.getFullYear(), currentDate.getMonth());
            renderWeekDays();

            // Seleccionar día de hoy por defecto
            const todayStr = `${today.getFullYear()}-${String(today.getMonth()+1).padStart(2,'0')}-${String(today.getDate()).padStart(2,'0')}`;
            selectDate(todayStr);

            // Seleccionar hora por defecto (11:00)
            const defaultSlot = document.querySelector('.time-slot[data-time="11:00"]');
            if (defaultSlot) defaultSlot.click();
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