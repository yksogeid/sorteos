@extends('layouts.admin')

@section('header', 'Gestionar Sorteo')

@section('content')
    <div class="space-y-10 pb-20">
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">
            <!-- Sidebar Izquierda: Info Básica y Premios -->
            <div class="xl:col-span-2 space-y-8">
                <!-- FORM: Información General -->
                <form action="{{ route('admin.update', $sorteo) }}" method="POST" enctype="multipart/form-data"
                    class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_section" value="general">

                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <span
                                class="bg-blue-100 text-blue-600 w-8 h-8 rounded-lg flex items-center justify-center font-bold text-sm">📋</span>
                            <h3 class="font-bold text-slate-800 uppercase tracking-wider text-xs">Ajustes Principales</h3>
                        </div>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-blue-700 transition">Guardar
                            General</button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <div class="flex flex-col md:flex-row gap-6">
                                <div class="flex-1">
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Título de la Campaña</label>
                                    <input type="text" name="titulo" required value="{{ old('titulo', $sorteo->titulo) }}"
                                        class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-slate-900 font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none">
                                </div>
                                <div class="w-full md:w-64">
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Imagen Principal</label>
                                    <div class="relative group h-[52px]">
                                        <input type="file" name="imagen" id="main_imagen" class="sr-only">
                                        <label for="main_imagen"
                                            class="flex items-center gap-3 h-full px-4 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100 transition-all">
                                            @if($sorteo->imagen)
                                                <img src="{{ asset('storage/' . $sorteo->imagen) }}"
                                                    class="w-8 h-8 rounded object-cover border border-slate-200">
                                            @else
                                                <span
                                                    class="bg-slate-200 w-8 h-8 rounded flex items-center justify-center text-[10px]">🖼️</span>
                                            @endif
                                            <span class="text-xs font-bold text-slate-600 truncate">Cambiar imagen</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Descripción General</label>
                            <textarea name="descripcion" rows="3"
                                class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-slate-900 font-medium focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none">{{ old('descripcion', $sorteo->descripcion) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Precio Base ($)</label>
                            <input type="number" name="precio_ticket" required
                                value="{{ old('precio_ticket', $sorteo->precio_ticket) }}"
                                class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-slate-900 font-black focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Emisión Total Tickets</label>
                            <input type="number" name="total_tickets" required
                                value="{{ old('total_tickets', $sorteo->total_tickets) }}"
                                class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-slate-900 font-black focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none">
                        </div>

                        <div
                            class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-blue-50/50 rounded-2xl border border-blue-100">
                            <div>
                                <label class="block text-sm font-bold text-blue-900 mb-2">Modo de Barra</label>
                                <label
                                    class="flex items-center gap-3 cursor-pointer group bg-white p-3 rounded-xl border border-blue-200">
                                    <div class="relative">
                                        <input type="checkbox" name="proceso_manual" value="1" {{ $sorteo->proceso_manual ? 'checked' : '' }} class="peer sr-only">
                                        <div
                                            class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                        </div>
                                    </div>
                                    <span class="text-xs font-black text-blue-800 uppercase tracking-tight">Activar Llenado
                                        Manual</span>
                                </label>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-blue-900 mb-2">Porcentaje Visual (%)</label>
                                <div class="relative">
                                    <input type="number" name="porcentaje_manual" min="0" max="100"
                                        value="{{ old('porcentaje_manual', $sorteo->porcentaje_manual) }}"
                                        class="w-full bg-white border-blue-200 rounded-xl px-4 py-3 text-blue-900 font-black focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none">
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-blue-400 font-bold">%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-8 border-t border-slate-100">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" name="activo" value="1" {{ $sorteo->activo ? 'checked' : '' }}
                                    class="peer sr-only">
                                <div
                                    class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500">
                                </div>
                            </div>
                            <span
                                class="text-sm font-bold text-slate-700 group-hover:text-slate-900 transition-colors">Sorteo
                                visible para el público</span>
                        </label>
                    </div>
                </form>

                <!-- FORM: Premios -->
                <form action="{{ route('admin.update', $sorteo) }}" method="POST" enctype="multipart/form-data"
                    class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 text-right">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_section" value="premios">

                    <div class="flex items-center justify-between mb-8 text-left">
                        <div class="flex items-center gap-3">
                            <span
                                class="bg-amber-100 text-amber-600 w-8 h-8 rounded-lg flex items-center justify-center font-bold text-sm">🏆</span>
                            <h3 class="font-bold text-slate-800 uppercase tracking-wider text-xs">Premios de la Campaña</h3>
                        </div>
                        <div class="flex gap-2">
                            <button type="button" onclick="addItem('premios-list', 'premio')"
                                class="bg-slate-100 text-slate-700 px-4 py-2 rounded-xl text-xs font-bold hover:bg-slate-200 transition">
                                + Añadir
                            </button>
                            <button type="submit"
                                class="bg-amber-600 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-amber-700 transition">Guardar
                                Premios</button>
                        </div>
                    </div>

                    <div id="premios-list" class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                        @foreach($sorteo->premios ?? [] as $index => $premio)
                            <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-4 relative group">
                                <div>
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Nombre
                                        del Puesto</label>
                                    <input type="text" name="premios[{{$index}}][nombre]" value="{{$premio['nombre']}}"
                                        class="w-full bg-white border-slate-200 rounded-lg px-3 py-2 text-sm font-bold focus:border-blue-500 outline-none">
                                </div>
                                <div>
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Regalo(s)</label>
                                    <input type="text" name="premios[{{$index}}][prizes][]"
                                        value="{{ implode(', ', $premio['prizes']) }}"
                                        class="w-full bg-white border-slate-200 rounded-lg px-3 py-2 text-sm font-medium focus:border-blue-500 outline-none">
                                </div>

                                <div class="flex items-center gap-4 pt-2">
                                    @if(isset($premio['imagen_url']))
                                        <div
                                            class="relative w-14 h-14 shrink-0 rounded-lg overflow-hidden border-2 border-white shadow-sm">
                                            <img src="{{ asset($premio['imagen_url']) }}" class="w-full h-full object-cover">
                                            <input type="hidden" name="premios[{{$index}}][imagen_url_hidden]"
                                                value="{{ $premio['imagen_url'] }}">
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <input type="file" name="premios[{{$index}}][imagen]"
                                            class="block w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-black file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300 transition-all">
                                    </div>
                                </div>

                                <button type="button" onclick="this.parentElement.remove()"
                                    class="absolute -top-3 -right-3 w-8 h-8 bg-white border border-slate-200 text-red-500 rounded-full flex items-center justify-center shadow-lg hover:bg-red-50 transition-colors">🗑️</button>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>

            <!-- Sidebar Lateral: Paquetes y Anticipados -->
            <div class="space-y-8">
                <!-- FORM: Paquetes de Tickets -->
                <form action="{{ route('admin.update', $sorteo) }}" method="POST"
                    class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 text-right">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_section" value="paquetes">

                    <div class="flex items-center justify-between mb-6 text-left">
                        <div class="flex items-center gap-3">
                            <span
                                class="bg-emerald-100 text-emerald-600 w-8 h-8 rounded-lg flex items-center justify-center font-bold text-sm">🎟️</span>
                            <h3 class="font-bold text-slate-800 uppercase tracking-wider text-xs">Stickers</h3>
                        </div>
                        <div class="flex gap-2">
                            <button type="button" onclick="addItem('packages-list', 'package')"
                                class="text-[10px] font-black uppercase text-slate-500 hover:text-slate-700">+
                                Añadir</button>
                            <button type="submit"
                                class="bg-emerald-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-emerald-700 transition">Guardar</button>
                        </div>
                    </div>

                    <div id="packages-list" class="space-y-4 text-left">
                        @foreach($sorteo->paquetes as $index => $paquete)
                            <div class="flex flex-col gap-3 p-4 bg-slate-50 rounded-xl border border-slate-200 relative group">
                                <div class="flex gap-2">
                                    <div class="flex-1">
                                        <input type="number" name="paquetes[{{$index}}][cantidad]" placeholder="Cant"
                                            value="{{$paquete->cantidad}}"
                                            class="w-full bg-white border-slate-200 rounded-lg px-3 py-2 text-xs font-bold">
                                    </div>
                                    <div class="flex-1">
                                        <input type="number" name="paquetes[{{$index}}][precio]" placeholder="Precio"
                                            value="{{$paquete->precio}}"
                                            class="w-full bg-white border-slate-200 rounded-lg px-3 py-2 text-xs font-black text-emerald-600">
                                    </div>
                                </div>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="paquetes[{{$index}}][es_extra]" {{$paquete->es_extra ? 'checked' : ''}}
                                        class="w-4 h-4 rounded border-slate-300 text-emerald-500 focus:ring-emerald-500/20">
                                    <span class="text-[10px] font-black text-slate-500 uppercase">Es Paquete Extra</span>
                                </label>
                                <button type="button" onclick="this.parentElement.remove()"
                                    class="absolute -top-2 -right-2 w-6 h-6 bg-white border border-slate-100 text-red-400 rounded-full flex items-center justify-center shadow-sm hover:text-red-600">×</button>
                            </div>
                        @endforeach
                    </div>
                </form>

                <!-- FORM: Anticipados -->
                <form action="{{ route('admin.update', $sorteo) }}" method="POST"
                    class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 text-right">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_section" value="anticipados">

                    <div class="flex items-center justify-between mb-6 text-left">
                        <div class="flex items-center gap-3">
                            <span
                                class="bg-indigo-100 text-indigo-600 w-8 h-8 rounded-lg flex items-center justify-center font-bold text-sm">📅</span>
                            <h3 class="font-bold text-slate-800 uppercase tracking-wider text-xs">Anticipados</h3>
                        </div>
                        <div class="flex gap-2">
                            <button type="button" onclick="addItem('anticipados-list', 'anticipado')"
                                class="text-[10px] font-black uppercase text-slate-500 hover:text-slate-700">+ Añadir
                                Grupo</button>
                            <button type="submit"
                                class="bg-indigo-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-indigo-700 transition">Guardar</button>
                        </div>
                    </div>
                    <div id="anticipados-list" class="space-y-4 text-left">
                        @foreach($sorteo->numeros_anticipados ?? [] as $groupIndex => $item)
                            <div class="p-6 bg-slate-50 rounded-2xl border border-slate-200 relative group"
                                id="anticipado-{{ $groupIndex }}">
                                <input type="text" name="numeros_anticipados[{{$groupIndex}}][titulo]"
                                    placeholder="Ej: Bono $500k" value="{{$item['titulo']}}"
                                    class="w-full bg-white border-slate-200 rounded-lg px-3 py-2 text-sm font-bold mb-4 focus:border-indigo-500 outline-none">

                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Números
                                            Ganadores</span>
                                        <button type="button" onclick="openPicker({{ $groupIndex }})"
                                            class="text-[10px] bg-indigo-50 text-indigo-600 px-2 py-1 rounded-md font-black hover:bg-indigo-100 transition-colors uppercase">🔍
                                            Seleccionar de la lista</button>
                                    </div>
                                    <div id="group-nums-{{ $groupIndex }}" class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                                        @foreach($item['numeros'] as $num)
                                            <div
                                                class="flex items-center gap-1 bg-white border border-slate-200 rounded-lg px-2 py-1.5 animate-in fade-in zoom-in duration-200">
                                                <input type="text" name="numeros_anticipados[{{$groupIndex}}][numeros][]"
                                                    value="{{ $num }}"
                                                    class="w-full bg-transparent border-none p-0 text-xs font-bold font-mono text-center focus:ring-0">
                                                <button type="button" onclick="this.parentElement.remove()"
                                                    class="text-red-400 hover:text-red-600 text-sm leading-none">×</button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <button type="button" onclick="this.parentElement.remove()"
                                    class="absolute -top-3 -right-3 w-8 h-8 bg-white border border-slate-200 text-red-500 rounded-full flex items-center justify-center shadow-md hover:bg-red-50 transition-colors">🗑️</button>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Selección de Números -->
        <div id="numberPickerModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-black/60" onclick="closePicker()"></div>

                <div class="inline-block w-full max-w-4xl overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-[2rem] sm:my-8">
                    <div class="p-8 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-slate-800">Seleccionar Números Disponibles</h3>
                            <p class="text-xs text-slate-400 font-medium">Haz clic en los números para añadirlos. Desplázate para ver más.</p>
                        </div>
                        <button onclick="closePicker()" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 rounded-full text-slate-400 hover:text-red-500 transition-all hover:shadow-lg">×</button>
                    </div>

                    <div class="p-0 max-h-[500px] overflow-y-auto custom-scrollbar" onscroll="handlePickerScroll(this)">
                        <table class="w-full text-left border-collapse">
                            <thead class="sticky top-0 bg-slate-50 border-b border-slate-200 z-10">
                                <tr>
                                    <th class="py-4 px-8 text-[10px] font-black uppercase text-slate-400 tracking-widest">Estado</th>
                                    <th class="py-4 px-8 text-[10px] font-black uppercase text-slate-400 tracking-widest">Número de Ticket</th>
                                    <th class="py-4 px-8 text-[10px] font-black uppercase text-slate-400 tracking-widest text-right">Acción</th>
                                </tr>
                            </thead>
                            <tbody id="searchResults">
                                <!-- Filas se cargarán aquí -->
                            </tbody>
                        </table>
                        <div id="pickerLoading" class="hidden py-12 text-center">
                            <div class="inline-block w-8 h-8 border-4 border-slate-200 border-t-black rounded-full animate-spin"></div>
                            <p class="text-[10px] font-black text-slate-400 uppercase mt-4 tracking-widest">Cargando tickets...</p>
                        </div>
                    </div>

                    <div class="p-6 bg-white border-t border-slate-100 flex justify-between items-center px-8">
                        <div id="selectedCountDisplay" class="text-xs font-bold text-slate-500">
                            <span id="selectedCounter">0</span> números seleccionados
                        </div>
                        <button onclick="closePicker()" class="bg-black text-white px-10 py-4 rounded-2xl font-black uppercase tracking-widest text-[11px] hover:bg-slate-800 shadow-xl transition-all active:scale-95">Listo, Finalizar Selección</button>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .custom-scrollbar::-webkit-scrollbar { width: 6px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
        </style>

        <script>
            let packageIdx = {{ count($sorteo->paquetes) }};
            let premioIdx = {{ count($sorteo->premios ?? []) }};
            let anticipadoIdx = {{ count($sorteo->numeros_anticipados ?? []) }};

            let activeGroupForPicker = null;
            let pickerCurrentPage = 1;
            let pickerIsLoading = false;
            let pickerHasMore = true;
            let selectedNumbers = new Set();

            function openPicker(groupIdx) {
                activeGroupForPicker = groupIdx;
                pickerCurrentPage = 1;
                pickerHasMore = true;
                selectedNumbers.clear();
                document.getElementById('selectedCounter').innerText = '0';

                document.getElementById('numberPickerModal').classList.remove('hidden');
                document.getElementById('searchResults').innerHTML = '';
                loadMoreTickets();
            }

            function closePicker() {
                document.getElementById('numberPickerModal').classList.add('hidden');
                activeGroupForPicker = null;
            }

            function handlePickerScroll(el) {
                if (pickerIsLoading || !pickerHasMore) return;
                if (el.scrollTop + el.clientHeight >= el.scrollHeight - 100) {
                    loadMoreTickets();
                }
            }

            async function loadMoreTickets() {
                if (pickerIsLoading || !pickerHasMore) return;

                pickerIsLoading = true;
                document.getElementById('pickerLoading').classList.remove('hidden');

                try {
                    const response = await fetch(`{{ route('admin.tickets.search', $sorteo) }}?page=${pickerCurrentPage}`);
                    const tickets = await response.json();

                    if (tickets.length === 0) {
                        pickerHasMore = false;
                    } else {
                        const results = document.getElementById('searchResults');
                        tickets.forEach(t => {
                            const tr = document.createElement('tr');
                            tr.className = 'border-b border-slate-100 hover:bg-slate-50 transition-colors group';

                            const statusHtml = t.available 
                                ? `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-600 uppercase">Disponible</span>`
                                : `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black bg-slate-100 text-slate-400 uppercase">Vendido</span>`;

                            const actionHtml = t.available
                                ? `<button type="button" onclick="handleTicketSelection(event, '${t.numero}', this)" 
                                    class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-black uppercase hover:bg-black hover:text-white transition-all">Seleccionar</button>`
                                : `<span class="text-[10px] font-bold text-slate-300 uppercase px-4">Bloqueado</span>`;

                            tr.innerHTML = `
                                <td class="py-4 px-8">${statusHtml}</td>
                                <td class="py-4 px-8 font-mono font-bold text-slate-700">${t.numero}</td>
                                <td class="py-4 px-8 text-right">${actionHtml}</td>
                            `;
                            results.appendChild(tr);
                        });
                        pickerCurrentPage++;
                    }
                } catch (error) {
                    console.error('Error loading tickets:', error);
                } finally {
                    pickerIsLoading = false;
                    document.getElementById('pickerLoading').classList.add('hidden');
                }
            }

            window.handleTicketSelection = function(event, number, btnEl) {
                event.preventDefault();
                event.stopPropagation();

                if (selectedNumbers.has(number)) return;

                console.log("Seleccionando ticket:", number, "en grupo:", activeGroupForPicker);

                const success = addNumberToGroup(activeGroupForPicker, number);

                if (success) {
                    selectedNumbers.add(number);
                    document.getElementById('selectedCounter').innerText = selectedNumbers.size;

                    // Feedback visual
                    const rowEl = btnEl.closest('tr');
                    if (rowEl) rowEl.classList.add('bg-emerald-50');

                    btnEl.innerText = ' Añadido ✓';
                    btnEl.classList.remove('bg-slate-100', 'text-slate-600', 'hover:bg-black');
                    btnEl.classList.add('bg-emerald-500', 'text-white');
                    btnEl.disabled = true;
                    btnEl.removeAttribute('onclick');
                }
            }

            function addNumberToGroup(groupIdx, number = '') {
                const container = document.getElementById(`group-nums-${groupIdx}`);
                if (!container) {
                    console.error("No se encontró el contenedor group-nums-" + groupIdx);
                    alert("Error: Por favor vuelve a abrir el selector.");
                    return false;
                }

                const div = document.createElement('div');
                div.className = 'flex items-center gap-1 bg-white border border-slate-200 rounded-lg px-2 py-1.5 animate-in fade-in zoom-in duration-200';
                div.innerHTML = `
                    <input type="text" name="numeros_anticipados[${groupIdx}][numeros][]" value="${number}" placeholder="00000"
                        class="w-full bg-transparent border-none p-0 text-xs font-bold font-mono text-center focus:ring-0">
                    <button type="button" onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 text-sm leading-none">×</button>
                `;
                container.appendChild(div);
                return true;
            }

            function addItem(containerId, type) {
                const container = document.getElementById(containerId);
                let html = '';

                if (type === 'package') {
                    html = `
                        <div class="flex flex-col gap-3 p-4 bg-slate-50 rounded-xl border border-slate-200 relative group text-left">
                            <div class="flex gap-2">
                                <div class="flex-1"><input type="number" name="paquetes[${packageIdx}][cantidad]" placeholder="Cant" class="w-full bg-white border-slate-200 rounded-lg px-3 py-2 text-xs font-bold"></div>
                                <div class="flex-1"><input type="number" name="paquetes[${packageIdx}][precio]" placeholder="Precio" class="w-full bg-white border-slate-200 rounded-lg px-3 py-2 text-xs font-black text-emerald-600"></div>
                            </div>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="paquetes[${packageIdx}][es_extra]" class="w-4 h-4 rounded border-slate-300 text-emerald-500">
                                <span class="text-[10px] font-black text-slate-500 uppercase">Es Paquete Extra</span>
                            </label>
                            <button type="button" onclick="this.parentElement.remove()" class="absolute -top-2 -right-2 w-6 h-6 bg-white border border-slate-100 text-red-400 rounded-full flex items-center justify-center">×</button>
                        </div>`;
                    packageIdx++;
                } else if (type === 'premio') {
                    html = `
                        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-4 relative group text-left">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Nombre del Puesto</label>
                                <input type="text" name="premios[${premioIdx}][nombre]" placeholder="Ej: Premio Mayor" class="w-full bg-white border-slate-200 rounded-lg px-3 py-2 text-sm font-bold outline-none">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Regalo(s)</label>
                                <input type="text" name="premios[${premioIdx}][prizes][]" placeholder="Ej: Moto XTZ" class="w-full bg-white border-slate-200 rounded-lg px-3 py-2 text-sm font-medium outline-none">
                            </div>
                            <div class="pt-2">
                                <input type="file" name="premios[${premioIdx}][imagen]" class="block w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-black file:bg-slate-200 file:text-slate-700">
                            </div>
                            <button type="button" onclick="this.parentElement.remove()" class="absolute -top-3 -right-3 w-8 h-8 bg-white border border-slate-200 text-red-500 rounded-full flex items-center justify-center shadow-lg">🗑️</button>
                        </div>`;
                    premioIdx++;
                } else if (type === 'anticipado') {
                    const currentIdx = anticipadoIdx;
                    html = `
                        <div class="p-6 bg-slate-50 rounded-2xl border border-slate-200 relative group text-left" id="anticipado-${currentIdx}">
                            <input type="text" name="numeros_anticipados[${currentIdx}][titulo]" placeholder="Ej: Bono $500k"
                                class="w-full bg-white border-slate-200 rounded-lg px-3 py-2 text-sm font-bold mb-4 focus:border-indigo-500 outline-none">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Números Ganadores</span>
                                    <button type="button" onclick="openPicker(${currentIdx})" class="text-[10px] bg-indigo-50 text-indigo-600 px-2 py-1 rounded-md font-black hover:bg-indigo-100 transition-colors uppercase">🔍 Seleccionar de la lista</button>
                                </div>
                                <div id="group-nums-${currentIdx}" class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                                    <!-- Números aparecerán aquí -->
                                </div>
                            </div>
                            <button type="button" onclick="this.parentElement.remove()" class="absolute -top-3 -right-3 w-8 h-8 bg-white border border-slate-200 text-red-500 rounded-full flex items-center justify-center shadow-md">🗑️</button>
                        </div>`;
                    anticipadoIdx++;
                }

                const div = document.createElement('div');
                div.innerHTML = html;
                container.appendChild(div.firstElementChild);
            }
        </script>
@endsection