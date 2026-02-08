@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
    <div class="bg-gray-200 aspect-[16/9] max-h-[720px] w-full flex items-center justify-center">
        <span class="text-4xl font-bold text-gray-400">1280 X 720</span>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-sorteo-dark">{{ $sorteo->titulo }}</h2>
            <p class="text-lg text-gray-600 font-semibold">{{ $sorteo->descripcion }}</p>
        </div>

        <div class="max-w-2xl mx-auto mb-12">
            <div class="text-center mb-2">
                <span class="text-sm italic">¡Corre!</span>
            </div>
            <div class="relative w-full bg-gray-300 h-8 rounded-full overflow-hidden">
            @php 
                $total = max(1, $sorteo->total_tickets);
                $porcentaje = ($sorteo->tickets_vendidos / $total) * 100; 
            @endphp
            <div class="absolute top-0 left-0 h-full bg-sorteo-dark flex items-center justify-center text-white text-sm font-bold" style="width: {{ $porcentaje }}%">
                {{ round($porcentaje) }}%
            </div>
        </div>
            <div class="text-center mt-2">
                <span class="text-xs font-bold text-gray-700 italic">¡Se acaban!</span>
            </div>
        </div>

        <div class="bg-sorteo-dark text-white py-2 text-center font-bold uppercase tracking-widest mb-8">
            Premios
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
            @foreach($sorteo->premios as $premio)
                <div class="flex flex-col items-center">
                    <div class="bg-sorteo-dark text-white px-8 py-2 rounded-t-3xl font-bold text-lg mb-4">
                        {{ $premio['nombre'] }}
                    </div>
                    <div
                        class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex flex-col items-center justify-center min-h-[300px] w-full">
                        @if($premio['nombre'] == 'Premio Mayor')
                            <div class="flex gap-4 items-end">
                                <img src="https://img.icons8.com/color/200/motorcycle.png" alt="moto" class="w-32">
                                <img src="https://img.icons8.com/color/200/car.png" alt="car" class="w-48">
                            </div>
                        @else
                            <img src="https://img.icons8.com/color/200/playstation-5.png" alt="ps5" class="w-40">
                        @endif
                        <div class="flex flex-wrap justify-center gap-2 mt-4 text-sm font-bold">
                            @foreach($premio['prizes'] as $p)
                                <span class="bg-gray-100 px-3 py-1 rounded">{{ $p }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mb-16">
            <h3 class="text-xl font-bold mb-6">Numeros premiados para anticipados</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($sorteo->numeros_anticipados as $anticipado)
                    <div class="flex flex-col">
                        <div class="bg-sorteo-green text-white text-center py-1 font-bold">
                            {{ $anticipado['titulo'] }}
                        </div>
                        <div class="flex flex-wrap gap-2 justify-center p-2 bg-gray-50 border border-t-0">
                            @foreach($anticipado['numeros'] as $num)
                                <span class="bg-sorteo-dark text-white px-4 py-0.5 rounded text-sm font-bold">{{ $num }}</span>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-sorteo-dark text-white py-2 text-center font-bold uppercase tracking-widest mb-8">
            Stickers
        </div>

        <div class="text-center mb-8">
            <p class="text-gray-600 italic">Elije el paquete de stickers para mayor probabilidad ahora mismo</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12" id="paquetes-grid">
            @foreach($sorteo->paquetes as $paquete)
                <button onclick="selectPaquete({{ $paquete->id }}, {{ $paquete->cantidad }}, {{ $paquete->precio }})"
                    class="paquete-btn relative flex flex-col items-center border-[3px] border-transparent transition group"
                    data-id="{{ $paquete->id }}">
                    <div
                        class="bg-sorteo-dark text-white w-full py-2 font-bold uppercase group-hover:bg-sorteo-green transition">
                        Comprar {{ $paquete->cantidad }} Stickers
                    </div>
                    <div class="bg-sorteo-green text-white w-full py-1 font-bold text-sm">
                        ${{ number_format($paquete->precio, 0, ',', '.') }}
                    </div>
                    @if($paquete->es_extra)
                        <div class="absolute -right-2 top-0 bottom-0 flex items-center">
                            <span
                                class="bg-sorteo-green text-white text-[10px] font-bold px-1 h-full flex items-center [writing-mode:vertical-lr] border-l border-white">EXTRA</span>
                        </div>
                    @endif
                </button>
            @endforeach
        </div>

        <form action="{{ route('checkout.iniciar') }}" method="POST"
            class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            @csrf
            <input type="hidden" name="sorteo_id" value="{{ $sorteo->id }}">
            <input type="hidden" name="paquete_id" id="paquete_id_input">

            <div class="flex flex-col items-center gap-6">
                <div class="flex items-center gap-2">
                    <button type="button" onclick="changeQty(-1)"
                        class="bg-sorteo-dark text-white w-10 h-10 flex items-center justify-center font-bold text-2xl">-</button>
                    <input type="number" name="cantidad" id="qty-input" value="1" min="1"
                        class="border h-10 w-16 text-center font-bold text-lg bg-gray-100">
                    <button type="button" onclick="changeQty(1)"
                        class="bg-sorteo-dark text-white w-10 h-10 flex items-center justify-center font-bold text-2xl">+</button>
                    <button type="submit"
                        class="bg-sorteo-dark text-white px-8 h-10 font-bold uppercase hover:bg-sorteo-green transition">Comprar
                        Ahora</button>
                </div>
                <div class="text-lg font-bold">
                    Total a pagar: <span class="text-gray-900" id="total-text">$0</span>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        let selectedPaquete = null;
        const precioBase = {{ $sorteo->precio_ticket }};

        function selectPaquete(id, qty, precio) {
            // Deselect previous
            document.querySelectorAll('.paquete-btn').forEach(btn => {
                btn.classList.remove('border-sorteo-green');
            });

            const btn = document.querySelector(`.paquete-btn[data-id="${id}"]`);
            btn.classList.add('border-sorteo-green');

            document.getElementById('paquete_id_input').value = id;
            document.getElementById('qty-input').value = 1; // Default qty of packages is 1?
            // Wait, the design suggests you can buy X quantity of a selected package or just raw quantity.
            // Actually, the plus/minus usually applies to the selected package or individual tickets.
            // I'll assume if no package is selected, it's individual price.
            updateTotal();
        }

        function changeQty(delta) {
            const input = document.getElementById('qty-input');
            let val = parseInt(input.value) + delta;
            if (val < 1) val = 1;
            input.value = val;
            updateTotal();
        }

        function updateTotal() {
            const qty = parseInt(document.getElementById('qty-input').value);
            const paqueteId = document.getElementById('paquete_id_input').value;
            let total = 0;

            if (paqueteId) {
                const btn = document.querySelector(`.paquete-btn[data-id="${paqueteId}"]`);
                // Extract price from current seeder data or just find it from attribute
                // I'll add attributes to the button
                const price = parseFloat({{ Js::from($sorteo->paquetes->keyBy('id')->map->precio) }}[paqueteId]);
                total = price * qty;
            } else {
                total = qty * precioBase;
            }

            document.getElementById('total-text').innerText = '$' + total.toLocaleString('es-CO');
        }

        document.getElementById('qty-input').addEventListener('change', updateTotal);
        updateTotal();
    </script>
@endpush