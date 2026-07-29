@extends('layouts.dueño')

@section('page_title', 'Configuración del Colaborador')

@section('content')
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-md">
        <div>
            <nav class="flex gap-2 text-label-sm text-on-surface-variant mb-2">
                <span>Colaboradores</span>
                <span class="material-symbols-outlined text-xs leading-none">chevron_right</span>
                <span class="text-secondary font-bold">Editar Detalles</span>
            </nav>
            <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Configuración del Colaborador</h1>
            <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">Gestione la información personal, profesional y operativa de los miembros de su equipo corporativo.</p>
        </div>
        <div class="flex gap-sm">
            <button class="px-lg py-sm rounded-lg border-[1.5px] border-primary text-primary font-bold hover:bg-surface-container-high transition-colors active:scale-95">Cancelar</button>
            <button class="px-lg py-sm rounded-lg bg-[#10B981] text-white font-bold shadow-sm hover:brightness-90 transition-all active:scale-95">Guardar Cambios</button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-lg mt-xl">
        <div class="lg:col-span-8 space-y-lg">
            <section class="bg-surface-container-lowest p-xl rounded-lg border border-outline-variant form-shadow">
                <h3 class="font-headline-md text-headline-md mb-xl flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary">settings_input_component</span>
                    Información General
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-xl">
                    <div class="flex flex-col gap-xs">
                        <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Nombre Completo</label>
                        <input class="w-full h-12 px-md border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all font-body-md" type="text" value="Auditoría de Seguridad Nivel 4">
                    </div>
                    <div class="flex flex-col gap-xs">
                        <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Correo Electrónico</label>
                        <input class="w-full h-12 px-md border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all font-body-md" type="email" value="support@securecorp.com">
                    </div>
                    <div class="flex flex-col gap-xs">
                        <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Teléfono de Contacto</label>
                        <input class="w-full h-12 px-md border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all font-body-md" type="tel" value="+52 55 1234 5678">
                    </div>
                    <div class="flex flex-col gap-xs">
                        <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Especialidad / Rol</label>
                        <input class="w-full h-12 px-md border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all font-body-md" type="text" value="Auditor Senior de Ciberseguridad">
                    </div>
                </div>
                <div class="mt-xl flex flex-col gap-xs">
                    <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Notas u Observaciones</label>
                    <textarea class="w-full p-md border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all font-body-md" placeholder="Describa el alcance detallado del servicio..." rows="6">Este servicio de auditoría integral proporciona una evaluación exhaustiva de los activos digitales de la corporación. Incluye pruebas de penetración, análisis de vulnerabilidades en tiempo real y un informe detallado de remediación estratégica compatible con normativas ISO 27001.</textarea>
                </div>
            </section>

            <section class="bg-surface-container-lowest rounded-lg border border-outline-variant form-shadow overflow-hidden">
                <div class="p-xl border-b border-outline-variant">
                    <h3 class="font-headline-md text-headline-md flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">checklist</span>
                        Características y Complementos
                    </h3>
                    <p class="text-body-sm text-on-surface-variant mt-1">Seleccione las funcionalidades activas para este nivel de servicio.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-surface-container-low">
                            <tr>
                                <th class="px-xl py-md font-label-md text-on-surface-variant uppercase tracking-widest text-[11px] w-16">
                                    <input class="w-5 h-5 rounded border-outline-variant text-secondary focus:ring-secondary" type="checkbox">
                                </th>
                                <th class="px-xl py-md font-label-md text-on-surface-variant uppercase tracking-widest text-[11px]">Funcionalidad</th>
                                <th class="px-xl py-md font-label-md text-on-surface-variant uppercase tracking-widest text-[11px]">Tipo</th>
                                <th class="px-xl py-md font-label-md text-on-surface-variant uppercase tracking-widest text-[11px]">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant">
                            <tr class="hover:bg-surface-container transition-colors">
                                <td class="px-xl py-md"><input checked class="w-5 h-5 rounded border-outline-variant text-secondary focus:ring-secondary cursor-pointer" type="checkbox"></td>
                                <td class="px-xl py-md">
                                    <div class="font-bold text-on-surface">Escaneo de Vulnerabilidades 24/7</div>
                                    <div class="text-xs text-on-surface-variant">Monitoreo automatizado continuo</div>
                                </td>
                                <td class="px-xl py-md font-body-sm text-on-surface-variant italic">Core Feature</td>
                                <td class="px-xl py-md"><span class="px-2 py-1 rounded bg-secondary-container text-on-secondary-container font-label-sm text-[10px] uppercase">Activo</span></td>
                            </tr>
                            <tr class="hover:bg-surface-container transition-colors">
                                <td class="px-xl py-md"><input checked class="w-5 h-5 rounded border-outline-variant text-secondary focus:ring-secondary cursor-pointer" type="checkbox"></td>
                                <td class="px-xl py-md">
                                    <div class="font-bold text-on-surface">Soporte Técnico Premium</div>
                                    <div class="text-xs text-on-surface-variant">Respuesta en menos de 2 horas</div>
                                </td>
                                <td class="px-xl py-md font-body-sm text-on-surface-variant italic">Add-on</td>
                                <td class="px-xl py-md"><span class="px-2 py-1 rounded bg-secondary-container text-on-secondary-container font-label-sm text-[10px] uppercase">Activo</span></td>
                            </tr>
                            <tr class="hover:bg-surface-container transition-colors">
                                <td class="px-xl py-md"><input class="w-5 h-5 rounded border-outline-variant text-secondary focus:ring-secondary cursor-pointer" type="checkbox"></td>
                                <td class="px-xl py-md">
                                    <div class="font-bold text-on-surface">Backup en Nube Descentralizada</div>
                                    <div class="text-xs text-on-surface-variant">Almacenamiento redundante global</div>
                                </td>
                                <td class="px-xl py-md font-body-sm text-on-surface-variant italic">Advanced</td>
                                <td class="px-xl py-md"><span class="px-2 py-1 rounded bg-surface-container-high text-on-surface-variant font-label-sm text-[10px] uppercase">Opcional</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <div class="lg:col-span-4 space-y-lg">
            <section class="bg-surface-container-lowest p-xl rounded-lg border border-outline-variant form-shadow">
                <h3 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-md">Foto del Colaborador</h3>
                <div class="group relative rounded-xl overflow-hidden aspect-video bg-surface-container-low border-2 border-dashed border-outline-variant flex flex-col items-center justify-center cursor-pointer hover:border-secondary transition-all">
                    <img class="absolute inset-0 w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-40" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAAHdC0J_3istOt_1DwuKbTwJYcYxPm-GytUHgcq8R5P58fuLjBg_Hxb6TbQiCtVKoSjyrtZFnxVIogC3Uc0PkfYF9s2bDbOhT48QDQSJE72Sga5HXFvnw3B7aRDEnS9wBQFjUxPnB_c-BUWK2QfWJGXZdWvtQjLKVCXSMmgh4eGYNPxrjcUOXv40zdgb1mgjkrZlf4agpEHbj5bXJudzj5ZLY6JEizLTK54IKEZQs1jfaJdBDkB2GsnQ" alt="Colaborador">
                    <div class="relative z-10 flex flex-col items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <span class="material-symbols-outlined text-4xl text-secondary">cloud_upload</span>
                        <p class="font-label-md text-on-surface font-bold">Cambiar Foto</p>
                        <p class="text-[10px] text-on-surface-variant">JPG, PNG hasta 5MB</p>
                    </div>
                </div>
                <div class="mt-xl pt-xl border-t border-outline-variant">
                    <div class="flex items-center gap-4 mb-xl">
                        <div class="w-12 h-12 rounded-lg bg-surface-container-high flex items-center justify-center p-2">
                            <img class="w-full h-full object-contain" src="https://lh3.googleusercontent.com/aida/AP1WRLtuC5XlBGtOjSi_jmc-EaRB94ZzjKHm8WFGDRDMSacARG7jBOO3lqIWfjA7RcS5Lg6h17o68gbg85xhbmw6IivQk3b_wcExTeR4-uw5lZokalROtGwcG-rF-ylgeUSbN_6DjFtL304n9z6OaOw9Np-rH35VWinnvAuppyOb6KI32VzM0q0-QcXFhY2obJjZeHjjti72UfpmBEJZQYLvn5ZUdrPEFvAWwYYsr51c8vBk6g5T1K0TyL7k_Xed" alt="Logo">
                        </div>
                        <div>
                            <p class="font-label-sm text-secondary font-bold">Identidad Visual</p>
                            <p class="text-body-sm text-on-surface-variant leading-tight">Configurado bajo la marca SecureCorp Nexus</p>
                        </div>
                    </div>
                    <button class="w-full py-md rounded-lg border border-outline-variant text-on-surface-variant font-bold flex items-center justify-center gap-2 hover:bg-surface-container-high transition-all">
                        <span class="material-symbols-outlined text-sm">visibility</span>
                        Previsualizar Ficha
                    </button>
                </div>
            </section>

            <section class="bg-primary-container p-xl rounded-lg text-white space-y-md">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary-fixed-dim">info</span>
                    <h4 class="font-label-md uppercase tracking-widest text-[11px]">Resumen de Publicación</h4>
                </div>
                <ul class="space-y-3 font-body-sm opacity-90">
                    <li class="flex justify-between border-b border-white/10 pb-2">
                        <span>Última modificación:</span>
                        <span class="font-bold">Hace 2 horas</span>
                    </li>
                    <li class="flex justify-between border-b border-white/10 pb-2">
                        <span>Publicado por:</span>
                        <span class="font-bold">Admin_Alpha</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Visibilidad:</span>
                        <span class="text-secondary-fixed-dim font-bold flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-secondary-fixed-dim"></span>
                            Enterprise Only
                        </span>
                    </li>
                </ul>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('input, select, textarea').forEach(el => {
            el.addEventListener('focus', () => { el.parentElement.classList.add('scale-[1.01]'); });
            el.addEventListener('blur', () => { el.parentElement.classList.remove('scale-[1.01]'); });
        });

        const masterCheckbox = document.querySelector('thead input[type="checkbox"]');
        const itemCheckboxes = document.querySelectorAll('tbody input[type="checkbox"]');
        if (masterCheckbox) {
            masterCheckbox.addEventListener('change', (e) => {
                itemCheckboxes.forEach(cb => cb.checked = e.target.checked);
            });
        }
    </script>
@endpush

@push('styles')
    <style>
        .form-shadow {
            box-shadow: 0 2px 4px rgba(15, 23, 42, 0.04), 0 8px 16px rgba(15, 23, 42, 0.04);
        }
    </style>
@endpush