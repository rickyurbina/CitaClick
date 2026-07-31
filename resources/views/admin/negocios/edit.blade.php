@extends('layouts.admin')

@section('page_title', 'Editar Negocio')

@section('content')
    <div class="max-w-5xl mx-auto w-full">
        <nav class="flex items-center gap-xs mb-lg text-on-surface-variant">
            <a class="font-label-sm text-label-sm hover:text-primary transition-colors" href="{{ route('admin.negocios.index') }}">Negocios</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="font-label-sm text-label-sm text-on-surface font-semibold">Editar Registro</span>
        </nav>

        <div class="bg-surface-container-lowest border border-outline-variant rounded-lg overflow-hidden">
            <div class="px-xl py-lg border-b border-outline-variant bg-surface-container-low/30">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-headline-md text-headline-md text-on-surface">Editar Negocio</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-xs">Actualice la información del negocio seleccionado.</p>
                    </div>
                    <div class="flex items-center gap-sm bg-surface-container rounded-full px-md py-xs border border-outline-variant">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        <span class="font-label-sm text-label-sm text-on-surface-variant">Editando</span>
                    </div>
                </div>
            </div>
            <form class="p-xl" method="POST" action="#">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-12 gap-xl">
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
                                    <option value="activo" {{ $negocio->estado ?? 'activo' == 'activo' ? 'selected' : '' }}>Activo</option>
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
                    <div class="col-span-12 lg:col-span-8 grid grid-cols-1 md:grid-cols-2 gap-lg">
                        <div class="col-span-1 md:col-span-2">
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="nombre">Nombre del Negocio <span class="text-error">*</span></label>
                            <input class="w-full h-10 px-md bg-white border border-outline-variant rounded-lg text-body-md" id="nombre" name="nombre" value="{{ $negocio->nombre }}" required type="text">
                        </div>
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="telefono">Teléfono de Oficina</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[18px]">call</span>
                                <input class="w-full h-10 pl-10 pr-md bg-white border border-outline-variant rounded-lg text-body-md" id="telefono" name="telefono" value="{{ $negocio->telefono }}" type="tel">
                            </div>
                        </div>
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="contacto">Persona de Contacto</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[18px]">person</span>
                                <input class="w-full h-10 pl-10 pr-md bg-white border border-outline-variant rounded-lg text-body-md" id="contacto" name="contacto" value="{{ $negocio->contacto }}" type="text">
                            </div>
                        </div>
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="dueno">Dueño / Representante Legal</label>
                            <input class="w-full h-10 px-md bg-white border border-outline-variant rounded-lg text-body-md" id="dueno" name="dueno" value="{{ $negocio->dueno }}" type="text">
                        </div>
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="fecha_contratacion">Fecha de Contratación</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[18px]">calendar_today</span>
                                <input class="w-full h-10 pl-10 pr-md bg-white border border-outline-variant rounded-lg text-body-md" id="fecha_contratacion" name="fecha_contratacion" value="{{ $negocio->fecha_contratacion }}" type="date">
                            </div>
                        </div>
                        <div class="col-span-1 md:col-span-2">
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="siguiente_pago">Siguiente Fecha de Pago</label>
                            <div class="relative max-w-md">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[18px]">payments</span>
                                <input class="w-full h-10 pl-10 pr-md bg-white border border-outline-variant rounded-lg text-body-md" id="siguiente_pago" name="siguiente_pago" value="{{ $negocio->siguiente_pago }}" type="date">
                            </div>
                        </div>
                        <div class="col-span-1 md:col-span-2">
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="periodo_pago">Periodo de Pago</label>
                            <div class="relative max-w-md">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[18px]">update</span>
                                <select class="w-full h-10 pl-10 pr-md bg-white border border-outline-variant rounded-lg text-body-md appearance-none cursor-pointer" id="periodo_pago" name="periodo_pago">
                                    <option value="libre" {{ $negocio->periodo_pago == 'libre' ? 'selected' : '' }}>Libre</option>
                                    <option value="semanal" {{ $negocio->periodo_pago == 'semanal' ? 'selected' : '' }}>Semanal</option>
                                    <option value="mensual" {{ $negocio->periodo_pago == 'mensual' ? 'selected' : '' }}>Mensual</option>
                                    <option value="anual" {{ $negocio->periodo_pago == 'anual' ? 'selected' : '' }}>Anual</option>
                                </select>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline pointer-events-none">expand_more</span>
                            </div>
                        </div>
                        <div class="col-span-1 md:col-span-2">
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="cantidad_pagar">Cantidad a Pagar</label>
                            <div class="relative max-w-md">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[18px]">payments</span>
                                <input class="w-full h-10 pl-10 pr-md bg-white border border-outline-variant rounded-lg text-body-md" id="cantidad_pagar" name="cantidad_pagar" value="{{ $negocio->cantidad_pagar }}" type="text">
                            </div>
                        </div>
                        <div class="col-span-1 md:col-span-2 mt-md">
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="observaciones">Observaciones Internas</label>
                            <textarea class="w-full p-md bg-white border border-outline-variant rounded-lg text-body-md focus:ring-2 focus:ring-primary/20 transition-all resize-none" id="observaciones" name="observaciones" rows="3">{{ $negocio->observaciones }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="mt-2xl flex items-center justify-end gap-md pt-xl border-t border-outline-variant">
                    <a href="{{ route('admin.negocios.index') }}" class="px-xl py-2.5 rounded-lg border border-outline-variant text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high transition-colors active:scale-[0.98]">Cancelar</a>
                    <button class="px-xl py-2.5 rounded-lg bg-primary text-on-primary font-label-md text-label-md shadow-sm hover:opacity-90 transition-all active:scale-[0.98] flex items-center gap-sm" type="submit">
                        <span class="material-symbols-outlined text-[20px]">save</span>
                        Actualizar Registro
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection