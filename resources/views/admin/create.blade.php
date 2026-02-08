@extends('layouts.admin')

@section('header', 'Configurar Nuevo Sorteo')

@section('content')
    <div class="max-w-3xl mx-auto">
        <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            @csrf

            <div class="p-8 space-y-8">
                <!-- Sección: Información Básica -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3 mb-2">
                        <span
                            class="bg-emerald-100 text-emerald-600 w-8 h-8 rounded-lg flex items-center justify-center font-bold text-sm">1</span>
                        <h4 class="font-bold text-slate-800 uppercase tracking-wider text-xs">Información Principal</h4>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Título del Sorteo</label>
                        <input type="text" name="titulo" required value="{{ old('titulo') }}"
                            placeholder="Ej: GRAN SORTEO DE FIN DE AÑO"
                            class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-slate-900 font-medium focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                        @error('titulo') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Descripción Corta</label>
                            <textarea name="descripcion" rows="3" placeholder="Describe brevemente el sorteo..."
                                class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-slate-900 font-medium focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">{{ old('descripcion') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Imagen Banner (Hero)</label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl hover:border-emerald-400 transition-colors bg-slate-50">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48" aria-hidden="true">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-slate-600">
                                        <label for="imagen"
                                            class="relative cursor-pointer bg-white rounded-md font-bold text-emerald-600 hover:text-emerald-500">
                                            <span>Subir archivo</span>
                                            <input id="imagen" name="imagen" type="file" class="sr-only">
                                        </label>
                                    </div>
                                    <p class="text-xs text-slate-500">PNG, JPG, GIF hasta 10MB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección: Valores y Límites -->
                <div class="pt-8 border-t border-slate-100 space-y-6">
                    <div class="flex items-center gap-3 mb-2">
                        <span
                            class="bg-emerald-100 text-emerald-600 w-8 h-8 rounded-lg flex items-center justify-center font-bold text-sm">2</span>
                        <h4 class="font-bold text-slate-800 uppercase tracking-wider text-xs">Valores y Disponibilidad</h4>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Precio por Ticket ($)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">$</span>
                                <input type="number" name="precio_ticket" required value="{{ old('precio_ticket', 1000) }}"
                                    class="w-full bg-slate-50 border-slate-200 rounded-xl pl-8 pr-4 py-3 text-slate-900 font-black focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Total Tickets</label>
                            <input type="number" name="total_tickets" required value="{{ old('total_tickets', 100000) }}"
                                class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-slate-900 font-black focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                        </div>

                        <div
                            class="sm:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6 p-4 bg-emerald-50/30 rounded-2xl border border-emerald-100">
                            <div>
                                <label class="block text-sm font-bold text-emerald-900 mb-2">Control de Progreso</label>
                                <label
                                    class="flex items-center gap-3 cursor-pointer group bg-white p-3 rounded-xl border border-emerald-200">
                                    <div class="relative">
                                        <input type="checkbox" name="proceso_manual" value="1" class="peer sr-only">
                                        <div
                                            class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500">
                                        </div>
                                    </div>
                                    <span class="text-xs font-black text-emerald-800 uppercase tracking-tight">Usar Llenado
                                        Manual</span>
                                </label>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-emerald-900 mb-2">Porcentaje Inicial (%)</label>
                                <div class="relative">
                                    <input type="number" name="porcentaje_manual" min="0" max="100" value="0"
                                        class="w-full bg-white border-emerald-200 rounded-xl px-4 py-3 text-emerald-900 font-black focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                                    <span
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-emerald-400 font-bold">%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-emerald-50/50 p-4 rounded-xl border border-emerald-100/50">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" name="activo" value="1" checked class="peer sr-only">
                                <div
                                    class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500">
                                </div>
                            </div>
                            <span
                                class="text-sm font-bold text-slate-700 group-hover:text-emerald-700 transition-colors">Marcar
                                como sorteo activo inmediatamente</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Footer con Botones -->
            <div class="bg-slate-50 p-6 flex flex-col sm:flex-row justify-end gap-4 border-t border-slate-100">
                <a href="{{ route('admin.index') }}"
                    class="px-6 py-3 text-sm font-bold text-slate-500 hover:text-slate-800 transition-colors text-center order-2 sm:order-1">
                    Cancelar
                </a>
                <button type="submit"
                    class="bg-black text-white px-10 py-3 rounded-xl font-bold hover:bg-emerald-600 transition-all shadow-lg shadow-black/10 order-1 sm:order-2">
                    Crear Sorteo
                </button>
            </div>
        </form>
    </div>
@endsection