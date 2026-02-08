@extends('layouts.admin')

@section('header', 'Editar Sorteo')

@section('content')
    <form action="{{ route('admin.update', $sorteo) }}" method="POST" class="max-w-2xl">
        @csrf
        @method('PUT')
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Título del Sorteo</label>
                <input type="text" name="titulo" required value="{{ old('titulo', $sorteo->titulo) }}"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-sorteo-green focus:ring-sorteo-green">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Descripción</label>
                <textarea name="descripcion" rows="3"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-sorteo-green focus:ring-sorteo-green">{{ old('descripcion', $sorteo->descripcion) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Precio por Ticket ($)</label>
                    <input type="number" name="precio_ticket" required
                        value="{{ old('precio_ticket', $sorteo->precio_ticket) }}"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-sorteo-green focus:ring-sorteo-green">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Total de Tickets Disponibles</label>
                    <input type="number" name="total_tickets" required
                        value="{{ old('total_tickets', $sorteo->total_tickets) }}"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-sorteo-green focus:ring-sorteo-green">
                    <p class="text-xs text-gray-400 mt-1">Este valor define el límite del sorteo.</p>
                </div>
            </div>

            <div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="activo" value="1" {{ $sorteo->activo ? 'checked' : '' }}
                        class="rounded border-gray-300 text-sorteo-green focus:ring-sorteo-green">
                    <span class="text-sm font-bold text-gray-700">Sorteo Activo</span>
                </label>
            </div>

            <div class="bg-gray-50 p-4 rounded-md">
                <h4 class="font-bold text-sm mb-2 uppercase text-gray-400 tracking-wider">Estadísticas Actuales</h4>
                <div class="flex justify-between">
                    <div>
                        <span class="text-xs text-gray-500 block">Tickets Vendidos</span>
                        <span class="font-bold">{{ number_format($sorteo->tickets_vendidos) }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 block">Recaudado</span>
                        <span
                            class="font-bold text-sorteo-green">${{ number_format($sorteo->tickets_vendidos * $sorteo->precio_ticket, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t flex justify-end gap-3">
                <a href="{{ route('admin.index') }}"
                    class="px-4 py-2 text-gray-600 font-bold hover:text-gray-800 transition">Cancelar</a>
                <button type="submit"
                    class="bg-sorteo-dark text-white px-6 py-2 rounded font-bold hover:bg-sorteo-green transition">Guardar
                    Cambios</button>
            </div>
        </div>
    </form>
@endsection