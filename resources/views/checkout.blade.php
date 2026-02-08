@extends('layouts.app')

@section('title', 'Finalizar Compra')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-xl mx-auto">
            <h2 class="text-2xl font-bold mb-8 text-center uppercase tracking-wider">Formulario de Compra</h2>

            <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100 mb-8">
                <div class="flex justify-between items-center mb-6 pb-4 border-b">
                    <div>
                        <h3 class="font-bold text-gray-800">{{ $sorteo->titulo }}</h3>
                        <p class="text-sm text-gray-500">{{ $descripcion_compra }}</p>
                    </div>
                    <div class="text-xl font-extrabold text-sorteo-green">
                        ${{ number_format($total, 0, ',', '.') }}
                    </div>
                </div>

                <form action="{{ route('checkout.finalizar') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="sorteo_id" value="{{ $sorteo->id }}">
                    <input type="hidden" name="paquete_id" value="{{ $paquete_id }}">
                    <input type="hidden" name="cantidad" value="{{ $cantidad }}">
                    <input type="hidden" name="total" value="{{ $total }}">

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nombre Completo</label>
                        <input type="text" name="nombre" required
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-sorteo-green focus:ring-sorteo-green">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Correo Electrónico</label>
                        <input type="email" name="email" required
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-sorteo-green focus:ring-sorteo-green">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Teléfono / WhatsApp</label>
                        <input type="text" name="telefono" required
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-sorteo-green focus:ring-sorteo-green">
                    </div>

                    <div class="pt-6">
                        <button type="submit"
                            class="w-full bg-sorteo-dark text-white font-bold py-4 rounded-md uppercase tracking-widest hover:bg-sorteo-green transition flex items-center justify-center gap-2">
                            Confirmar y Pagar
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <a href="{{ url('/') }}"
                class="text-sm text-gray-500 hover:text-gray-800 flex items-center justify-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Cancelar y volver
            </a>
        </div>
    </div>
@endsection