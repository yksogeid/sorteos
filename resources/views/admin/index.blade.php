@extends('layouts.admin')

@section('header', 'Dashboard de Sorteos')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold">Lista de Sorteos</h3>
        <a href="{{ route('admin.create') }}"
            class="bg-sorteo-green text-white px-4 py-2 rounded font-bold hover:bg-green-600 transition">Nuevo Sorteo</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="p-4 font-bold text-sm text-gray-600 uppercase">Título</th>
                    <th class="p-4 font-bold text-sm text-gray-600 uppercase">Progreso</th>
                    <th class="p-4 font-bold text-sm text-gray-600 uppercase">Tickets</th>
                    <th class="p-4 font-bold text-sm text-gray-600 uppercase">Estado</th>
                    <th class="p-4 font-bold text-sm text-gray-600 uppercase text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sorteos as $sorteo)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4">
                            <div class="font-bold text-gray-800">{{ $sorteo->titulo }}</div>
                            <div class="text-xs text-gray-400">ID: {{ $sorteo->id }}</div>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <div class="w-24 bg-gray-200 h-2 rounded-full overflow-hidden">
                                    @php $porcentaje = ($sorteo->tickets_vendidos / $sorteo->total_tickets) * 100; @endphp
                                    <div class="bg-sorteo-green h-full" style="width: {{ $porcentaje }}%"></div>
                                </div>
                                <span class="text-xs font-bold">{{ round($porcentaje) }}%</span>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="text-sm">
                                <span class="font-bold">{{ number_format($sorteo->tickets_vendidos) }}</span> /
                                <span class="text-gray-400">{{ number_format($sorteo->total_tickets) }}</span>
                            </div>
                        </td>
                        <td class="p-4">
                            @if($sorteo->activo)
                                <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-bold">Activo</span>
                            @else
                                <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-full font-bold">Inactivo</span>
                            @endif
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <a href="{{ route('admin.edit', $sorteo) }}"
                                class="text-blue-600 hover:text-blue-800 text-sm font-bold">Editar</a>
                            <form action="{{ route('admin.destroy', $sorteo) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-bold"
                                    onclick="return confirm('¿Eliminar este sorteo?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection