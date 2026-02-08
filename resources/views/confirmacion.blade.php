@extends('layouts.app')

@section('title', 'Venta Exitosa')

@section('content')
    <div class="container mx-auto px-4 py-16 text-center">
        <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
            <div class="bg-green-100 text-green-600 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold mb-2 text-gray-800">¡Compra Exitosa!</h2>
            <p class="text-gray-500 mb-8">Gracias por tu compra. Hemos enviado un correo con tus números de ticket.</p>

            @if(isset($premiosGanados) && count($premiosGanados) > 0)
                <div class="mb-8 bg-yellow-50 border-2 border-yellow-400 p-6 rounded-xl animate-bounce">
                    <div class="flex flex-col items-center">
                        <span class="text-4xl mb-2">🎁</span>
                        <h3 class="text-xl font-black text-yellow-800 uppercase tracking-tighter">¡TIENES UN NÚMERO PREMIADO!</h3>
                        <div class="mt-4 space-y-2 w-full">
                            @foreach($premiosGanados as $win)
                                <div class="bg-yellow-400 text-yellow-900 font-bold py-2 px-4 rounded-lg flex justify-between items-center shadow-sm">
                                    <span>Ticket: #{{ $win['numero'] }}</span>
                                    <span class="bg-white px-2 py-0.5 rounded text-[10px] uppercase">{{ $win['premio'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-gray-50 p-6 rounded-lg mb-8 text-left">
                <h3 class="font-bold text-sm text-gray-400 uppercase mb-4 tracking-widest">Tus Números</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($tickets as $ticket)
                        <span class="bg-sorteo-dark text-white px-3 py-1 rounded font-bold">{{ $ticket->numero }}</span>
                    @endforeach
                </div>
            </div>

            <a href="{{ url('/') }}"
                class="inline-block bg-sorteo-green text-white font-bold py-3 px-8 rounded-full hover:bg-green-600 transition">
                Volver al Inicio
            </a>
        </div>
    </div>
@endsection