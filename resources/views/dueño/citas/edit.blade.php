@extends('layouts.dueño')

@section('page_title', 'Editar Cita')

@section('content')
    <div class="max-w-3xl mx-auto w-full">
        <nav class="flex items-center gap-xs mb-lg text-on-surface-variant">
            <a class="font-label-sm text-label-sm hover:text-primary transition-colors" href="{{ route('dueño.citas.index') }}">Citas</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="font-label-sm text-label-sm text-on-surface font-semibold">Editar Cita</span>
        </nav>

        <div class="bg-surface-container-lowest border border-outline-variant rounded-lg overflow-hidden">
            <div class="px-xl py-lg border-b border-outline-variant bg-surface-container-low/30">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-headline-md text-headline-md text-on-surface">Editar Cita</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-xs">Actualice los detalles de la cita seleccionada.</p>
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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-lg">
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="fecha">Fecha</label>
                        <input class="w-full h-10 px-md bg-white border border-outline-variant rounded-lg text-body-md" id="fecha" name="fecha" value="{{ $cita->fecha }}" type="date">
                    </div>
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="hora">Hora</label>
                        <input class="w-full h-10 px-md bg-white border border-outline-variant rounded-lg text-body-md" id="hora" name="hora" value="{{ $cita->hora }}" type="time">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="servicio">Servicio</label>
                        <input class="w-full h-10 px-md bg-white border border-outline-variant rounded-lg text-body-md" id="servicio" name="servicio" value="{{ $cita->servicio }}" type="text">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block font-label-md text-label-md text-on-surface-variant mb-xs" for="estado">Estado</label>
                        <select class="w-full h-10 px-md bg-white border border-outline-variant rounded-lg text-body-md" id="estado" name="estado">
                            <option value="confirmada" {{ $cita->estado == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                            <option value="pendiente" {{ $cita->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="cancelada" {{ $cita->estado == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                    </div>
                </div>
                <div class="mt-2xl flex items-center justify-end gap-md pt-xl border-t border-outline-variant">
                    <a href="{{ route('dueño.citas.index') }}" class="px-xl py-2.5 rounded-lg border border-outline-variant text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high transition-colors active:scale-[0.98]">Cancelar</a>
                    <button class="px-xl py-2.5 rounded-lg bg-primary text-on-primary font-label-md text-label-md shadow-sm hover:opacity-90 transition-all active:scale-[0.98] flex items-center gap-sm" type="submit">
                        <span class="material-symbols-outlined text-[20px]">save</span>
                        Actualizar Cita
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection