@extends('layouts.admin')

@section('header', 'Configuración del Sitio')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-lg font-bold text-slate-800">Identidad y Apariencia</h3>
                <p class="text-slate-500 text-sm">Gestiona los elementos visuales base de tu plataforma de sorteos.</p>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-8 space-y-10">
                    <!-- Logo Section -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
                        <div>
                            <h4 class="font-bold text-slate-700 mb-1">Logotipo Principal</h4>
                            <p class="text-xs text-slate-400">Este logo aparecerá en el encabezado de todas las páginas.</p>
                        </div>
                        <div class="md:col-span-2 space-y-4">
                            <div class="flex items-center gap-6">
                                <div
                                    class="w-24 h-24 bg-slate-100 rounded-2xl border-2 border-dashed border-slate-200 flex items-center justify-center overflow-hidden">
                                    @if($settings['logo'])
                                        <img src="{{ asset('storage/' . $settings['logo']) }}"
                                            class="w-full h-full object-contain p-2">
                                    @else
                                        <span class="text-3xl">🖼️</span>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <input type="file" name="logo" id="logo" class="sr-only">
                                    <label for="logo"
                                        class="inline-flex items-center px-4 py-2 bg-black text-white rounded-xl text-xs font-bold hover:bg-slate-800 cursor-pointer transition-all">
                                        Subir Nuevo Logo
                                    </label>
                                    <p class="text-[10px] text-slate-400 mt-2 italic">Formatos recomendados: PNG
                                        Transparente o SVG.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    <!-- Favicon Section -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
                        <div>
                            <h4 class="font-bold text-slate-700 mb-1">Favicon (Icono de Pestaña)</h4>
                            <p class="text-xs text-slate-400">El icono pequeño que aparece en la pestaña del navegador.</p>
                        </div>
                        <div class="md:col-span-2 space-y-4">
                            <div class="flex items-center gap-6">
                                <div
                                    class="w-12 h-12 bg-slate-100 rounded-lg border-2 border-dashed border-slate-200 flex items-center justify-center overflow-hidden">
                                    @if($settings['favicon'])
                                        <img src="{{ asset('storage/' . $settings['favicon']) }}"
                                            class="w-full h-full object-contain p-1">
                                    @else
                                        <span class="text-xl">📍</span>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <input type="file" name="favicon" id="favicon" class="sr-only">
                                    <label for="favicon"
                                        class="inline-flex items-center px-4 py-2 bg-slate-200 text-slate-700 rounded-xl text-xs font-bold hover:bg-slate-300 cursor-pointer transition-all">
                                        Subir Favicon
                                    </label>
                                    <p class="text-[10px] text-slate-400 mt-2 italic">Formato recomendado: PNG circular o ICO (32x32px).</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    <!-- Banner Section -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
                        <div>
                            <h4 class="font-bold text-slate-700 mb-1">Banner por Defecto</h4>
                            <p class="text-xs text-slate-400">Imagen de 1920x720 para sorteos sin imagen propia.</p>
                        </div>
                        <div class="md:col-span-2 space-y-4">
                            <div
                                class="relative w-full aspect-[192/72] bg-slate-100 rounded-2xl border-2 border-dashed border-slate-200 flex items-center justify-center overflow-hidden group">
                                @if($settings['banner'])
                                    <img src="{{ asset('storage/' . $settings['banner']) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="text-center">
                                        <span class="text-4xl block mb-2">🏔️</span>
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">1920 x
                                            720</span>
                                    </div>
                                @endif
                                <div
                                    class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <input type="file" name="banner" id="banner" class="sr-only">
                                    <label for="banner"
                                        class="bg-white text-black px-6 py-2 rounded-xl text-xs font-black uppercase tracking-tight cursor-pointer hover:scale-105 transition-transform">
                                        Cambiar Banner
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="border-slate-100">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
                        <div>
                            <h4 class="font-bold text-slate-700 mb-1">Información del Sitio</h4>
                            <p class="text-xs text-slate-400">Configura los textos principales y redes sociales.</p>
                        </div>
                        <div class="md:col-span-2 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Título
                                        de la Web</label>
                                    <input type="text" name="site_title" value="{{ $settings['site_title'] }}"
                                        class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-slate-900 font-bold focus:ring-2 focus:ring-black/5 focus:border-black transition-all outline-none">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Eslogan
                                        / Subtítulo</label>
                                    <input type="text" name="site_slogan" value="{{ $settings['site_slogan'] }}"
                                        class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-slate-900 font-medium focus:ring-2 focus:ring-black/5 focus:border-black transition-all outline-none">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Correo de Contacto</label>
                                    <input type="email" name="site_email" value="{{ $settings['site_email'] }}"
                                        class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-slate-900 font-medium focus:ring-2 focus:ring-black/5 focus:border-black transition-all outline-none">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label
                                        class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">WhatsApp</label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">📱</span>
                                        <input type="text" name="whatsapp" value="{{ $settings['whatsapp'] }}"
                                            placeholder="Ej: 57300..."
                                            class="w-full bg-slate-50 border-slate-200 rounded-xl pl-10 pr-4 py-3 text-slate-900 font-bold focus:ring-2 focus:ring-black/5 focus:border-black transition-all outline-none">
                                    </div>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Instagram</label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">📸</span>
                                        <input type="text" name="instagram" value="{{ $settings['instagram'] }}"
                                            placeholder="@usuario"
                                            class="w-full bg-slate-50 border-slate-200 rounded-xl pl-10 pr-4 py-3 text-slate-900 font-bold focus:ring-2 focus:ring-black/5 focus:border-black transition-all outline-none">
                                    </div>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Facebook</label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">👤</span>
                                        <input type="text" name="facebook" value="{{ $settings['facebook'] }}"
                                            placeholder="URL perfil"
                                            class="w-full bg-slate-50 border-slate-200 rounded-xl pl-10 pr-4 py-3 text-slate-900 font-bold focus:ring-2 focus:ring-black/5 focus:border-black transition-all outline-none">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    <!-- Footer Section -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
                        <div>
                            <h4 class="font-bold text-slate-700 mb-1">Pie de Página (Footer)</h4>
                            <p class="text-xs text-slate-400">Personaliza los textos que aparecen al final de la web.</p>
                        </div>
                        <div class="md:col-span-2 space-y-6">
                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Descripción Corta (Bajo el Logo)</label>
                                <textarea name="site_description" rows="2"
                                    class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-slate-900 font-medium focus:ring-2 focus:ring-black/5 focus:border-black transition-all outline-none">{{ $settings['site_description'] }}</textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Texto "Sobre Nosotros" (Footer)</label>
                                <textarea name="footer_about" rows="2"
                                    class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-slate-900 font-medium focus:ring-2 focus:ring-black/5 focus:border-black transition-all outline-none">{{ $settings['footer_about'] }}</textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Texto de Copyright</label>
                                <input type="text" name="footer_copyright" value="{{ $settings['footer_copyright'] }}"
                                    class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-slate-900 font-medium focus:ring-2 focus:ring-black/5 focus:border-black transition-all outline-none">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-slate-50 border-t border-slate-100 flex justify-between items-center">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Asegúrate de guardar después
                        de cada cambio</p>
                    <button type="submit"
                        class="bg-black text-white px-10 py-3 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-slate-800 transition-all shadow-lg hover:shadow-black/20">
                        Guardar Configuración
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection