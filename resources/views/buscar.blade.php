@extends('layouts.app')

@section('title', 'Búsqueda de Números')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto">
            <a href="{{ url('/') }}" class="text-sm text-gray-400 hover:text-gray-200 block mb-8">Volver a la pagina
                principal</a>

            <div class="bg-sorteo-green text-white text-center py-2 font-bold uppercase mb-8">
                Busqueda de Numeros
            </div>

            <div class="flex flex-col items-center mb-12">
                <h2 class="text-2xl font-bold mb-6">Consulta tus numeros con tu Email</h2>
                <form action="{{ route('buscar') }}" method="GET" class="w-full max-w-md">
                    <input type="email" name="email" value="{{ request('email') }}" placeholder="Email"
                        class="w-full bg-gray-100 border-none p-4 rounded-sm text-center mb-4 focus:ring-2 focus:ring-sorteo-green">
                    <div class="flex justify-center">
                        <button type="submit"
                            class="bg-sorteo-dark text-white font-bold py-2 px-12 rounded-full flex items-center gap-2 hover:bg-gray-800 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                                </path>
                            </svg>
                            Buscar
                        </button>
                    </div>
                </form>
            </div>

            @if(request()->has('email'))
                @if($tickets && $tickets->count() > 0)
                    <div class="grid grid-cols-1 gap-6">
                        @foreach($tickets->groupBy('sorteo_id') as $sorteoId => $listaTickets)
                            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                                <h3 class="font-bold text-lg mb-4">{{ $listaTickets->first()->sorteo->titulo }}</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($listaTickets as $ticket)
                                        <span
                                            class="bg-sorteo-green text-white px-3 py-1 rounded font-bold text-sm">{{ $ticket->numero }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @ else
                    <div class="text-center text-gray-500 py-12">
                        No se encontraron resultados
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection