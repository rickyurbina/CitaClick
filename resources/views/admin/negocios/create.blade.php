@extends('layouts.admin')

@section('page_title', 'Nuevo Negocio')

@section('content')
    <div class="max-w-5xl mx-auto w-full">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-xs mb-lg text-on-surface-variant">
            <a class="font-label-sm text-label-sm hover:text-primary transition-colors" href="{{ route('admin.negocios.index') }}">Negocios</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="font-label-sm text-label-sm text-on-surface font-semibold">Nuevo Registro</span>
        </nav>

        <div class="bg-surface-container-lowest border border-outline-variant rounded-lg overflow-hidden">
            <div class="px-xl py-lg border-b border-outline-variant bg-surface-container-low/30">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-headline-md text-headline-md text-on-surface">Información del Negocio</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-xs">Complete todos los campos requeridos para registrar una nueva entidad comercial en la plataforma.</p>
                    </div>
                    <div class="flex items-center gap-sm bg-surface-container rounded-full px-md py-xs border border-outline-variant">
                        <span class="w-2 h-2 rounded-full bg-warning-600 animate-pulse bg-amber-500"></span>
                        <span class="font-label-sm text-label-sm text-on-surface-variant">Edición en progreso</span>
                    </div>
                </div>
            </div>
            <form class="p-xl" method="POST" action="#">
                @csrf
                <div class="grid grid-cols-12 gap-xl">
                    <!-- Profile/Logo Section -->
                    <div class="col-span-12 lg:col-span-4 flex flex-col items-center justify-start text-center border-r-0 lg:border-r border-outline-variant lg:pr-xl pb-xl lg:pb-0">
                        <div class="relative group">
                            <div class="w-32 h-32 rounded-xl bg-surface-container flex items-center justify-center border-2 border-dashed border-outline-variant mb-md overflow-hidden transition-all group-hover:border-primary">
                                <div class="absolute inset-0 bg-primary/0 group-hover:bg-primary/5 transition-colors"></div>
                                <span class="material-symbols-outlined text-outline group-hover:text-primary text-[40px]">add_a_photo</span>
                            </div>
                            <button class="absolute -bottom-2 -right-2 bg-primary text-on-primary p-2 rounded-full shadow-lg hover:scale-105 transition-transform active:scale-95" type="button">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </button>
                        </div>
                        <h4 class="font-label-md text-label-md text-on-surface mt-md">Logo del Negocio</h4>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">Formatos aceptados: PNG, JPG, WEBP. Max: 2MB.</p>
                        <div class="mt-xl w-full text-left space-y-lg">
                            <div>
                                <label class="block font-label-md text-label-md text-on-surface-variant mb-xs">Estado del Negocio</label>
                                <select class="w-full h-10 px-md bg-surface-container-lowest border border-outline-variant rounded-lg text-body-md appearance-none cursor-pointer">
                                    <option value="activo">Activo</option>
                                    <option value="pendiente">Pendiente</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>
                            <div class="p-md rounded-lg bg-surface-container-low border border-outline-variant/50">
                                <div class="flex items-center gap-sm mb-xs">
                                    <span class="material-symbols-outlined text-primary text-[20px]">info</span>
                                    <span class="font-label-sm text-label-sm text-primary uppercase tracking-tight">Nota de Auditoría</span>
                                </div>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">El cambio de estado a "Inactivo" restringirá el acceso a los módulos operativos de forma inmediata.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Fields Section -->
                    <div class="col-span-12 lg:col-span-8 grid grid-cols-1 md:grid-cols-2 gap-lg">
                        <div class="col-span-1 md:col-span-2">
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="nombre">Nombre del Negocio <span class="text-error">*</span></label>
                            <input class="w-full h-10 px-md bg-white border border-outline-variant rounded-lg text-body-md" id="nombre" name="nombre" placeholder="Ej. Soluciones Corporativas S.A." required type="text">
                        </div>
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="telefono">Teléfono de Oficina</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[18px]">call</span>
                                <input class="w-full h-10 pl-10 pr-md bg-white border border-outline-variant rounded-lg text-body-md" id="telefono" name="telefono" placeholder="+52 (55) 0000-0000" type="tel">
                            </div>
                        </div>
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="contacto">Persona de Contacto</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[18px]">person</span>
                                <input class="w-full h-10 pl-10 pr-md bg-white border border-outline-variant rounded-lg text-body-md" id="contacto" name="contacto" placeholder="Nombre completo" type="text">
                            </div>
                        </div>
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="dueno">Dueño / Representante Legal</label>
                            <input class="w-full h-10 px-md bg-white border border-outline-variant rounded-lg text-body-md" id="dueno" name="dueno" placeholder="Nombre del propietario" type="text">
                        </div>
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="fecha_contratacion">Fecha de Contratación</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[18px]">calendar_today</span>
                                <input class="w-full h-10 pl-10 pr-md bg-white border border-outline-variant rounded-lg text-body-md" id="fecha_contratacion" name="fecha_contratacion" type="date">
                            </div>
                        </div>
                        <div class="col-span-1 md:col-span-2">
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="siguiente_pago">Siguiente Fecha de Pago</label>
                            <div class="relative max-w-md">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[18px]">payments</span>
                                <input class="w-full h-10 pl-10 pr-md bg-white border border-outline-variant rounded-lg text-body-md" id="siguiente_pago" name="siguiente_pago" type="date">
                            </div>
                        </div>
                        <div class="col-span-1 md:col-span-2">
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="periodo_pago">Periodo de Pago</label>
                            <div class="relative max-w-md">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[18px]">update</span>
                                <select class="w-full h-10 pl-10 pr-md bg-white border border-outline-variant rounded-lg text-body-md appearance-none cursor-pointer" id="periodo_pago" name="periodo_pago">
                                    <option value="libre">Libre</option>
                                    <option value="semanal">Semanal</option>
                                    <option value="mensual">Mensual</option>
                                    <option value="anual">Anual</option>
                                </select>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline pointer-events-none">expand_more</span>
                            </div>
                        </div>
                        <div class="col-span-1 md:col-span-2">
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="cantidad_pagar">Cantidad a Pagar</label>
                            <div class="relative max-w-md">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[18px]">payments</span>
                                <input class="w-full h-10 pl-10 pr-md bg-white border border-outline-variant rounded-lg text-body-md" id="cantidad_pagar" name="cantidad_pagar" placeholder="Ej. 1,500.00" type="text">
                            </div>
                        </div>
                        <div class="col-span-1 md:col-span-2 mt-md">
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="observaciones">Observaciones Internas</label>
                            <textarea class="w-full p-md bg-white border border-outline-variant rounded-lg text-body-md focus:ring-2 focus:ring-primary/20 transition-all resize-none" id="observaciones" name="observaciones" placeholder="Información adicional relevante sobre el cliente o términos especiales..." rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <!-- Actions Footer -->
                <div class="mt-2xl flex items-center justify-end gap-md pt-xl border-t border-outline-variant">
                    <button class="px-xl py-2.5 rounded-lg border border-outline-variant text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high transition-colors active:scale-[0.98]" type="button">Cancelar</button>
                    <button class="px-xl py-2.5 rounded-lg bg-primary text-on-primary font-label-md text-label-md shadow-sm hover:opacity-90 transition-all active:scale-[0.98] flex items-center gap-sm" type="submit">
                        <span class="material-symbols-outlined text-[20px]">save</span>
                        Guardar Registro
                    </button>
                </div>
            </form>
        </div>

        <!-- Supporting Information Cards -->
        <div class="mt-xl grid grid-cols-1 md:grid-cols-3 gap-lg">
            <div class="bg-surface-container-lowest p-lg rounded-lg border border-outline-variant shadow-sm flex items-start gap-md">
                <div class="bg-primary/10 p-sm rounded-lg">
                    <span class="material-symbols-outlined text-primary">security</span>
                </div>
                <div>
                    <h5 class="font-label-md text-label-md text-on-surface mb-xs">Seguridad de Datos</h5>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">Toda la información ingresada es cifrada mediante protocolos bancarios de grado corporativo.</p>
                </div>
            </div>
            <div class="bg-surface-container-lowest p-lg rounded-lg border border-outline-variant shadow-sm flex items-start gap-md">
                <div class="bg-secondary-container/20 p-sm rounded-lg">
                    <span class="material-symbols-outlined text-secondary">sync</span>
                </div>
                <div>
                    <h5 class="font-label-md text-label-md text-on-surface mb-xs">Sincronización</h5>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">Los cambios realizados se reflejarán en todos los reportes y módulos financieros en tiempo real.</p>
                </div>
            </div>
            <div class="bg-surface-container-lowest p-lg rounded-lg border border-outline-variant shadow-sm flex items-start gap-md">
                <div class="bg-error-container/20 p-sm rounded-lg">
                    <span class="material-symbols-outlined text-error">history</span>
                </div>
                <div>
                    <h5 class="font-label-md text-label-md text-on-surface mb-xs">Historial de Cambios</h5>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">Cada modificación queda registrada en el log de auditoría con fecha y usuario responsable.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement.classList.add('focused');
            });
            input.addEventListener('blur', () => {
                input.parentElement.classList.remove('focused');
            });
        });

        let formChanged = false;
        document.querySelector('form').addEventListener('change', () => { formChanged = true; });

        window.addEventListener('beforeunload', (e) => {
            if (formChanged) {
                e.preventDefault();
                e.returnValue = '';
            }
        });

        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('mousedown', function(e) {
                const x = e.clientX - e.target.offsetLeft;
                const y = e.clientY - e.target.offsetTop;
                const ripple = document.createElement('span');
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;
                this.appendChild(ripple);
                setTimeout(() => { ripple.remove(); }, 600);
            });
        });
    </script>
@endpush    