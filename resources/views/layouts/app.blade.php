<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php 
        $siteTitle = \App\Models\Setting::get('site_title', 'Gana con Kelvin');
        $siteSlogan = \App\Models\Setting::get('site_slogan', 'Tu oportunidad de ganar hoy');
        $logo = \App\Models\Setting::get('logo');
        $whatsapp = \App\Models\Setting::get('whatsapp');
        $instagram = \App\Models\Setting::get('instagram');
        $facebook = \App\Models\Setting::get('facebook');
    @endphp
    <title>{{ $siteTitle }} - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body>
    <header class="bg-black py-6 md:py-8 text-center relative border-b border-white/5">
        <div class="container mx-auto px-4">
            <div class="flex flex-col items-center">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex flex-col items-center gap-1 scale-95 md:scale-100 transition-transform hover:scale-105">
                    @if($logo)
                        <img src="{{ asset('storage/' . $logo) }}" alt="{{ $siteTitle }}" class="h-10 md:h-16">
                    @else
                        <div class="flex items-center gap-2">
                            <span class="text-white text-3xl md:text-5xl font-black italic tracking-tighter">{{ $siteTitle }}</span>
                            <div class="bg-sorteo-green p-1">
                                <span class="text-white text-[8px] md:text-[10px] font-black uppercase leading-none">.COM</span>
                            </div>
                        </div>
                    @endif
                    <span class="text-sorteo-green text-[10px] md:text-sm font-black uppercase tracking-[0.3em] mt-2 opacity-80">{{ $siteSlogan }}</span>
                </a>
            </div>
        </div>
    </header>

    <div class="bg-[#111111] py-4 text-center border-t border-gray-900 sticky top-0 z-50 shadow-xl">
        <a href="{{ route('buscar') }}"
            class="bg-sorteo-green text-white text-[11px] font-black py-2.5 px-12 uppercase tracking-[0.2em] inline-block rounded-full hover:bg-green-500 transition-colors shadow-lg shadow-green-600/20">
            BUSCA AQUÍ TUS NÚMEROS
        </a>
    </div>

    <main class="bg-white min-h-screen">
        @yield('content')
    </main>

    <footer class="bg-black text-white pt-20 pb-10 border-t border-gray-900">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-16 mb-16">
                <!-- Brand -->
                <div class="flex flex-col items-center md:items-start text-center md:text-left">
                    <a href="{{ url('/') }}" class="mb-6">
                        @if($logo)
                            <img src="{{ asset('storage/' . $logo) }}" alt="{{ $siteTitle }}" class="h-10 md:h-12 brightness-0 invert opacity-90">
                        @else
                            <span class="text-white text-3xl font-black italic tracking-tighter uppercase">{{ $siteTitle }}</span>
                        @endif
                    </a>
                    <p class="text-gray-500 text-sm font-medium leading-relaxed max-w-sm">
                        {{ $siteSlogan }}. Únete a nuestra comunidad y sé el próximo gran ganador de premios extraordinarios.
                    </p>
                </div>

                <!-- Redes Sociales -->
                <div class="flex flex-col items-center">
                    <h4 class="text-xs font-black uppercase tracking-[0.4em] mb-8 text-white/50">Síguenos</h4>
                    <div class="flex gap-6">
                        @if($instagram)
                        <a href="{{ Str::startsWith($instagram, 'http') ? $instagram : 'https://instagram.com/'.ltrim($instagram, '@') }}" target="_blank" class="w-12 h-12 bg-gray-900 rounded-2xl flex items-center justify-center hover:bg-sorteo-green transition-all group">
                           <span class="text-xl group-hover:scale-125 transition-transform">📸</span>
                        </a>
                        @endif
                        @if($facebook)
                        <a href="{{ Str::startsWith($facebook, 'http') ? $facebook : $facebook }}" target="_blank" class="w-12 h-12 bg-gray-900 rounded-2xl flex items-center justify-center hover:bg-sorteo-green transition-all group">
                           <span class="text-xl group-hover:scale-125 transition-transform">👤</span>
                        </a>
                        @endif
                        @if($whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" target="_blank" class="w-12 h-12 bg-gray-900 rounded-2xl flex items-center justify-center hover:bg-sorteo-green transition-all group">
                           <span class="text-xl group-hover:scale-125 transition-transform">📱</span>
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Contacto -->
                <div class="flex flex-col items-center md:items-end text-center md:text-right">
                    <h4 class="text-xs font-black uppercase tracking-[0.4em] mb-8 text-white/50">Contacto</h4>
                    <div class="space-y-4">
                        @if($whatsapp)
                        <p class="text-white font-black text-lg">+{{ $whatsapp }}</p>
                        @endif
                        <p class="text-gray-500 text-sm font-medium">ventas@ganaconkelvin.com</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-900 pt-10 text-center text-[10px] text-gray-500 uppercase tracking-[0.5em] font-black opacity-30">
                &copy; {{ date('Y') }} {{ $siteTitle }} • Todos los derechos reservados
            </div>
        </div>
    </footer>
    @stack('scripts')
</body>

</html>