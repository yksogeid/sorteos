@extends('layouts.admin')

@section('header', 'Dashboard General')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <!-- Stats Card -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="text-slate-500 text-sm font-semibold mb-1">Sorteos Activos</div>
            <div class="text-3xl font-black text-slate-900">{{ $sorteos->where('activo', true)->count() }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="text-slate-500 text-sm font-semibold mb-1">Total Tickets</div>
            <div class="text-3xl font-black text-slate-900">{{ number_format($sorteos->sum('total_tickets')) }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="text-slate-500 text-sm font-semibold mb-1">Tickets Vendidos</div>
            <div class="text-3xl font-black text-emerald-600">{{ number_format($sorteos->sum('vendidos_count')) }}</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h3 class="text-lg font-bold text-slate-800">Sorteos Registrados</h3>
            <a href="{{ route('admin.create') }}"
                class="bg-sorteo-green text-white px-6 py-2.5 rounded-xl font-bold hover:bg-emerald-600 transition shadow-lg shadow-emerald-900/10 text-sm flex items-center gap-2">
                <span>➕</span> Nuevo Sorteo
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-4 font-bold text-xs text-slate-500 uppercase tracking-widest">Sorteo</th>
                        <th class="px-6 py-4 font-bold text-xs text-slate-500 uppercase tracking-widest">Progreso de Ventas</th>
                        <th class="px-6 py-4 font-bold text-xs text-slate-500 uppercase tracking-widest text-center">Estado</th>
                        <th class="px-6 py-4 font-bold text-xs text-slate-500 uppercase tracking-widest text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($sorteos as $sorteo)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5">
                                <div class="font-bold text-slate-900">{{ $sorteo->titulo }}</div>
                                <div class="text-xs text-slate-400 font-medium">ID #{{ $sorteo->id }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex flex-col gap-1.5 min-w-[180px]">
                                    @php 
                                        $porcentaje = ($sorteo->total_tickets > 0) ? ($sorteo->vendidos_count / $sorteo->total_tickets) * 100 : 0;
                                    @endphp
                                    <div class="flex justify-between text-[11px] font-bold">
                                        <span class="text-slate-600">{{ number_format($sorteo->vendidos_count) }} vendidos</span>
                                        <span class="text-slate-400">{{ round($porcentaje) }}%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                        <div class="bg-emerald-500 h-full rounded-full transition-all duration-500" style="width: {{ $porcentaje }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                @if($sorteo->activo)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2"></span> Activo
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400 mr-2"></span> Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.edit', $sorteo) }}"
                                        class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all" title="Editar">
                                        <span>✏️</span>
                                    </a>
                                    <form action="{{ route('admin.destroy', $sorteo) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                            onclick="return confirm('¿Seguro de que deseas eliminar este sorteo?')" title="Eliminar">
                                            <span>🗑️</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($sorteos->isEmpty())
            <div class="p-20 text-center">
                <div class="text-4xl mb-4">Empty</div>
                <p class="text-slate-400 font-medium">No hay sorteos registrados todavía.</p>
            </div>
        @endif
    </div>
@endsection