<div>
    <div class="text-center mb-lg">
        <div class="w-16 h-16 bg-secondary-container/50 rounded-full flex items-center justify-center mx-auto mb-md border border-secondary/20">
            <span class="material-symbols-outlined text-secondary" style="font-size: 32px;">person_add</span>
        </div>
        <h2 class="font-headline-md text-headline-md text-on-surface">Regístrate como cliente</h2>
        <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">
            Completa tus datos para continuar con el agendamiento
        </p>
    </div>

    <form wire:submit.prevent="registrar" class="space-y-lg">
        <div class="space-y-xs">
            <label for="nombre" class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">
                Nombre completo *
            </label>
            <div class="focus-ring flex items-center bg-surface border border-outline-variant rounded-lg transition-all duration-200">
                <div class="px-md flex items-center border-r border-outline-variant bg-surface-container-low rounded-l-lg h-12">
                    <span class="material-symbols-outlined text-on-surface-variant" style="font-size: 20px;">badge</span>
                </div>
                <input type="text"
                       id="nombre"
                       wire:model="nombre"
                       placeholder="Ej: Juan Pérez"
                       class="w-full h-12 px-md bg-transparent border-none focus:ring-0 font-body-md text-body-md text-on-surface placeholder:text-outline"
                       autofocus>
            </div>
            @error('nombre')
                <span class="font-body-sm text-body-sm text-error mt-xs block">{{ $message }}</span>
            @enderror
        </div>

        <div class="space-y-xs">
            <label for="telefono_registro" class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">
                Número de teléfono *
            </label>
            <div class="flex items-center bg-surface-container-low border border-outline-variant rounded-lg">
                <div class="px-md flex items-center gap-sm border-r border-outline-variant h-12">
                    <span class="material-symbols-outlined text-on-surface-variant" style="font-size: 20px;">call</span>
                    <span class="font-label-md text-label-md text-on-surface">+52</span>
                </div>
                <input type="tel"
                       id="telefono_registro"
                       wire:model="telefono"
                       class="w-full h-12 px-md bg-transparent border-none focus:ring-0 font-body-md text-body-md text-on-surface-variant"
                       readonly>
            </div>
            @error('telefono')
                <span class="font-body-sm text-body-sm text-error mt-xs block">{{ $message }}</span>
            @enderror
            <p class="font-body-sm text-body-sm text-outline mt-xs">El teléfono no puede ser modificado</p>
        </div>

        {{-- ==================== CALENDARIO FECHA DE NACIMIENTO ==================== --}}
        <div class="space-y-xs"
             x-data="{
                 abierto: false,
                 mes: new Date().getMonth(),
                 año: new Date().getFullYear(),
                 diaSeleccionado: null,
                 fechaSeleccionada: null,
                 fechaMostrar: 'Seleccionar fecha',
                 dias: [],
                 hoy: new Date().getDate(),
                 mesActual: new Date().getMonth(),
                 añoActual: new Date().getFullYear(),

                 init() {
                     this.generarDias();
                     if (@this.fechaNacimiento) {
                         const f = new Date(@this.fechaNacimiento + 'T00:00:00');
                         if (!isNaN(f.getTime())) {
                             this.diaSeleccionado = f.getDate();
                             this.fechaSeleccionada = @this.fechaNacimiento;
                             this.fechaMostrar = f.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
                             this.mes = f.getMonth();
                             this.año = f.getFullYear();
                             this.generarDias();
                         }
                     }
                 },

                 toggle() {
                     this.abierto = !this.abierto;
                     if (this.abierto) this.generarDias();
                 },

                 cambiarAño(dir) {
                     this.año += dir;
                     this.generarDias();
                 },

                 cambiarMes(dir) {
                     const fecha = new Date(this.año, this.mes + dir, 1);
                     this.mes = fecha.getMonth();
                     this.año = fecha.getFullYear();
                     this.generarDias();
                 },

                 generarDias() {
                     const fecha = new Date(this.año, this.mes, 1);
                     const ultimoDia = new Date(this.año, this.mes + 1, 0).getDate();
                     const primerDia = fecha.getDay();
                     const dias = [];
                     const offset = primerDia === 0 ? 6 : primerDia - 1;
                     
                     const hoy = new Date();
                     hoy.setHours(0, 0, 0, 0);
                     
                     for (let i = 0; i < offset; i++) {
                         dias.push(null);
                     }
                     
                     for (let i = 1; i <= ultimoDia; i++) {
                         const fechaDia = new Date(this.año, this.mes, i);
                         const esHoy = fechaDia.getTime() === hoy.getTime();
                         const esFuturo = fechaDia > hoy;
                         const esSeleccionado = fechaDia.getDate() === this.diaSeleccionado && 
                                               fechaDia.getMonth() === this.mes && 
                                               fechaDia.getFullYear() === this.año;

                         dias.push({
                             dia: i,
                             esHoy: esHoy,
                             esFuturo: esFuturo,
                             esSeleccionado: esSeleccionado,
                             fecha: fechaDia,
                         });
                     }
                     
                     this.dias = dias;
                 },

                 seleccionarFecha(dia) {
                     if (dia.esFuturo) return;
                     
                     this.diaSeleccionado = dia.dia;
                     this.fechaSeleccionada = dia.fecha.toISOString().split('T')[0];
                     this.fechaMostrar = dia.fecha.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
                     
                     @this.set('fechaNacimiento', this.fechaSeleccionada);
                     this.abierto = false;
                     this.generarDias();
                 },

                 get titulo() {
                     const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                     return meses[this.mes] + ' ' + this.año;
                 }
             }"
             x-init="init()">
            
            <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">
                Fecha de nacimiento *
            </label>
            
            <div class="relative">
                <button type="button"
                        @click="toggle()"
                        class="w-full h-12 px-md bg-surface border border-outline-variant rounded-lg hover:bg-surface-container-low transition-all duration-200 flex items-center justify-between font-body-md text-body-md text-on-surface">
                    <span class="flex items-center gap-sm">
                        <span class="material-symbols-outlined text-on-surface-variant" style="font-size: 20px;">cake</span>
                        <span x-text="fechaMostrar"></span>
                    </span>
                    <span class="material-symbols-outlined text-on-surface-variant" style="font-size: 20px;" x-text="abierto ? 'expand_less' : 'expand_more'"></span>
                </button>

                <div x-show="abierto"
                     x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="absolute z-50 mt-sm bg-white border border-gray-200 rounded-xl shadow-xl p-4 w-72"
                     @click.away="abierto = false">

                    {{-- Navegación: << para año, < para mes --}}
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-1">
                            <button type="button" @click="cambiarAño(-1)" class="p-2 hover:bg-gray-100 rounded transition" title="Año anterior">
                                <span class="material-symbols-outlined text-gray-500" style="font-size: 18px;">keyboard_double_arrow_left</span>
                            </button>
                            <button type="button" @click="cambiarMes(-1)" class="p-2 hover:bg-gray-100 rounded transition" title="Mes anterior">
                                <span class="material-symbols-outlined text-gray-600" style="font-size: 20px;">chevron_left</span>
                            </button>
                        </div>
                        
                        <span class="font-semibold text-gray-800" x-text="titulo"></span>
                        
                        <div class="flex items-center gap-1">
                            <button type="button" @click="cambiarMes(1)" class="p-2 hover:bg-gray-100 rounded transition" title="Mes siguiente">
                                <span class="material-symbols-outlined text-gray-600" style="font-size: 20px;">chevron_right</span>
                            </button>
                            <button type="button" @click="cambiarAño(1)" class="p-2 hover:bg-gray-100 rounded transition" title="Año siguiente">
                                <span class="material-symbols-outlined text-gray-500" style="font-size: 18px;">keyboard_double_arrow_right</span>
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-7 gap-1 mb-2">
                        <div class="text-center text-xs font-medium text-gray-400 uppercase">L</div>
                        <div class="text-center text-xs font-medium text-gray-400 uppercase">M</div>
                        <div class="text-center text-xs font-medium text-gray-400 uppercase">X</div>
                        <div class="text-center text-xs font-medium text-gray-400 uppercase">J</div>
                        <div class="text-center text-xs font-medium text-gray-400 uppercase">V</div>
                        <div class="text-center text-xs font-medium text-gray-400 uppercase">S</div>
                        <div class="text-center text-xs font-medium text-gray-400 uppercase">D</div>
                    </div>

                    <div class="grid grid-cols-7 gap-1">
                        <template x-for="(dia, idx) in dias" :key="idx">
                            <div class="aspect-square flex items-center justify-center">
                                <template x-if="dia === null">
                                    <div class="w-full h-full"></div>
                                </template>
                                <template x-if="dia !== null">
                                    <button type="button"
                                            @click="seleccionarFecha(dia)"
                                            :disabled="dia.esFuturo"
                                            class="w-full h-full rounded-lg text-sm transition-all duration-200 flex items-center justify-center"
                                            :class="{
                                                'bg-green-600 text-white hover:bg-green-700 shadow-md scale-95': dia.esSeleccionado,
                                                'border-2 border-green-600 text-green-600 hover:bg-green-50': dia.esHoy && !dia.esSeleccionado,
                                                'text-gray-300 cursor-not-allowed opacity-40': dia.esFuturo,
                                                'hover:bg-gray-100 hover:scale-105 text-gray-800': !dia.esFuturo && !dia.esSeleccionado && !dia.esHoy
                                            }"
                                            x-text="dia.dia">
                                    </button>
                                </template>
                            </div>
                        </template>
                    </div>

                    <div class="flex items-center gap-4 mt-3 pt-3 border-t border-gray-100">
                        <span class="flex items-center gap-1 text-xs text-gray-600">
                            <span class="w-3 h-3 rounded-full bg-green-600 inline-block"></span>
                            Seleccionado
                        </span>
                        <span class="flex items-center gap-1 text-xs text-gray-600">
                            <span class="w-3 h-3 rounded-full border-2 border-green-600 inline-block"></span>
                            Hoy
                        </span>
                        <span class="flex items-center gap-1 text-xs text-gray-400">
                            <span class="w-3 h-3 rounded-full bg-gray-100 border border-gray-200 inline-block"></span>
                            No disponible
                        </span>
                    </div>
                </div>
            </div>

            @error('fechaNacimiento')
                <span class="font-body-sm text-body-sm text-error mt-xs block">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex items-start gap-sm">
            <input type="checkbox"
                   id="aceptaTerminos"
                   wire:model="aceptaTerminos"
                   class="mt-1 rounded border-gray-300 text-green-600 focus:ring-green-500">
            <label for="aceptaTerminos" class="font-body-sm text-body-sm text-on-surface-variant">
                Acepto los <a href="#" class="text-secondary font-label-sm hover:underline">términos y condiciones</a> de la empresa
            </label>
        </div>
        @error('aceptaTerminos')
            <span class="font-body-sm text-body-sm text-error block">{{ $message }}</span>
        @enderror

        <div class="flex gap-md pt-xs">
            <button type="button"
                    wire:click="volver"
                    class="flex-1 h-12 border border-outline-variant text-on-surface-variant font-label-md text-label-md rounded-lg hover:bg-surface-container-low active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-sm">
                <span class="material-symbols-outlined" style="font-size: 20px;">arrow_back</span>
                Volver
            </button>
            <button type="submit"
                    class="flex-1 h-12 bg-secondary text-on-secondary font-label-md text-label-md rounded-lg shadow-md hover:bg-[#005a3d] active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-sm disabled:opacity-60"
                    wire:loading.attr="disabled"
                    wire:target="registrar">
                <span wire:loading.remove wire:target="registrar" class="flex items-center gap-sm">
                    Registrarme
                    <span class="material-symbols-outlined" style="font-size: 20px;">arrow_forward</span>
                </span>
                <span wire:loading wire:target="registrar" class="flex items-center gap-sm">
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Registrando...
                </span>
            </button>
        </div>
    </form>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>