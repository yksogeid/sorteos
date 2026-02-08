@extends('layouts.app')

@section('title', 'Selecciona tu Sorteo')

@section('content')
    <!-- Hero Selection Section -->
    <div class="bg-black py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black"></div>
            <img src="https://img.freepik.com/premium-photo/abstract-dark-background-with-green-glowing-lines_95489-1065.jpg" class="w-full h-full object-cover">
        </div>
        
        <div class="container mx-auto px-4 relative z-10 text-center">
            <h1 class="text-4xl md:text-6xl font-black text-white uppercase tracking-tighter mb-6">
                Selecciona tu <span class="text-sorteo-green">Sorteo</span>
            </h1>
            <p class="text-gray-400 max-w-2xl mx-auto font-medium text-lg">
                Elige la oportunidad que cambiará tu vida hoy mismo. Stickers limitados por sorteo.
            </p>
        </div>
    </div>

    <!-- Raffles Grid -->
    <div class="container mx-auto px-4 -mt-12 pb-32">
        @if($sorteos->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                @foreach($sorteos as $sorteo)
                    <div class="bg-white rounded-[2rem] shadow-2xl border border-gray-100 overflow-hidden group hover:scale-[1.02] transition-all duration-500">
                        <!-- Card Header / Image -->
                        <div class="relative h-64 overflow-hidden">
                            @php 
                                $defaultBanner = \App\Models\Setting::get('banner');
                                $bannerUrl = $sorteo->imagen ? asset('storage/' . $sorteo->imagen) : ($defaultBanner ? asset('storage/' . $defaultBanner) : null);
                            @endphp
                            
                            @if($bannerUrl)
                                <img src="{{ $bannerUrl }}" alt="{{ $sorteo->titulo }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full bg-slate-200 flex items-center justify-center">
                                    <span class="text-slate-400 font-bold uppercase tracking-widest">Sorteo Activo</span>
                                </div>
                            @endif
                            
                            <!-- Badges -->
                            <div class="absolute top-4 right-4 flex flex-col gap-2">
                                <span class="bg-black text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-lg">
                                    {{ number_format($sorteo->disponibles_count, 0) }} Tickets
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-8">
                            <h2 class="text-2xl font-black text-black uppercase tracking-tight mb-3 leading-tight">
                                {{ $sorteo->titulo }}
                            </h2>
                            <p class="text-gray-500 text-sm font-medium mb-8 line-clamp-2 h-10">
                                {{ $sorteo->descripcion }}
                            </p>

                            <!-- Progress Bar Mini -->
                            @php 
                                if ($sorteo->proceso_manual) {
                                    $porcentaje = $sorteo->porcentaje_manual;
                                } else {
                                    $total = max(1, $sorteo->total_tickets);
                                    $porcentaje = ($sorteo->tickets_vendidos / $total) * 100;
                                }
                            @endphp
                            <div class="mb-8">
                                <div class="flex justify-between items-end mb-2">
                                    <span class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Progreso de venta</span>
                                    <span class="text-sm font-black text-black">{{ round($porcentaje) }}%</span>
                                </div>
                                <div class="h-3 bg-gray-100 rounded-full overflow-hidden border border-gray-50">
                                    <div class="h-full bg-sorteo-green rounded-full shadow-[0_0_10px_rgba(22,163,74,0.3)] transition-all duration-1000" style="width: {{ $porcentaje }}%"></div>
                                </div>
                            </div>

                            <a href="{{ route('sorteo.show', $sorteo) }}" class="block w-full bg-black text-white text-center py-4 rounded-2xl font-black uppercase tracking-[0.2em] text-sm hover:bg-gray-900 shadow-xl transition-all group-hover:shadow-green-500/10">
                                PARTICIPAR AHORA
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="max-w-md mx-auto text-center py-20">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-3xl text-gray-300">⏳</span>
                </div>
                <h3 class="text-2xl font-black text-black uppercase tracking-tight mb-2">No hay sorteos</h3>
                <p class="text-gray-500 font-medium">Estamos preparando nuevas sorpresas. ¡Vuelve pronto!</p>
            </div>
        @endif
    </div>
@endsection
