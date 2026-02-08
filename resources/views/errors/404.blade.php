@extends('layouts.app')

@section('title', 'Página no encontrada')

@section('content')
    <div class="min-h-[70vh] flex flex-col items-center justify-center p-4 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-sorteo-green/5 rounded-full blur-3xl">
            </div>
        </div>

        <div class="relative z-10 text-center max-w-lg">
            <!-- Glitch / 404 Visual -->
            <div class="relative inline-block mb-8">
                <span class="text-9xl font-black text-black opacity-10 select-none">404</span>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-7xl font-black text-black tracking-tighter uppercase italic">Oops!</span>
                </div>
            </div>

            <h1 class="text-3xl font-black text-black uppercase tracking-tight mb-4">
                La página que buscas <br>
                <span class="text-sorteo-green italic">no existe.</span>
            </h1>

            <p class="text-gray-500 font-medium mb-12">
                Parece que te has perdido en el sorteo. Pero no te preocupes, aún puedes encontrar el número de la suerte.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('home') }}"
                    class="w-full sm:w-auto bg-black text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest text-sm hover:bg-gray-900 transition-all shadow-xl hover:shadow-2xl hover:-translate-y-1">
                    Volver al Inicio
                </a>
                <a href="{{ route('buscar') }}"
                    class="w-full sm:w-auto bg-white text-black border-2 border-black px-8 py-4 rounded-2xl font-black uppercase tracking-widest text-sm hover:bg-gray-50 transition-all">
                    Buscar mis Tickets
                </a>
            </div>
        </div>

        <!-- Extra detail -->
        <p class="mt-20 text-[10px] font-black uppercase text-gray-300 tracking-[0.5em] z-10">
            Gana con Kelvin • Estás a un paso de ganar
        </p>
    </div>
@endsection