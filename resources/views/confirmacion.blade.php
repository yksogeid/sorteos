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