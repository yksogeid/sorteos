@extends('layouts.app')

@section('title', $sorteo->titulo ?? 'Sin sorteos activos')

@section('content')
    @if($sorteo)
        <!-- Banner -->
        <div class="bg-[#dcdcdc] w-full flex items-center justify-center relative shadow-inner overflow-hidden h-64 md:h-[400px]">
            @php 
                $defaultBanner = \App\Models\Setting::get('banner');
                $bannerUrl = ($defaultBanner ? asset('storage/' . $defaultBanner) : null);
            @endphp
            
            @if($bannerUrl)
                <img src="{{ $bannerUrl }}" alt="{{ $sorteo->titulo }}" class="w-full h-full object-cover">
            @else
                <span class="text-4xl md:text-6xl font-black text-gray-400 opacity-50 transform -rotate-12">1920 X 720</span>
            @endif
        </div>

        <div class="container mx-auto px-4 py-12 md:py-16">
            <!-- Título -->
            <div class="text-center mb-10">
                <h2 class="text-3xl md:text-5xl font-black text-black uppercase tracking-tight mb-2">{{ $sorteo->titulo }}</h2>
                <p class="text-base md:text-lg text-black font-bold uppercase tracking-wide opacity-80">{{ $sorteo->descripcion }}</p>
            </div>

            <!-- Barra de progreso -->
            <div class="max-w-md mx-auto mb-20">
                <div class="text-center mb-1">
                    <span class="text-xs font-bold text-gray-900">¡Corre!</span>
                </div>
                <div class="relative w-full bg-gray-200 h-8 rounded-full overflow-hidden border border-gray-300">
                    @php 
                        if ($sorteo->proceso_manual) {
                            $porcentaje = $sorteo->porcentaje_manual;
                        } else {
                            $total = max(1, $sorteo->total_tickets);
                            $porcentaje = ($sorteo->tickets_vendidos / $total) * 100;
                        }
                    @endphp
                    <div class="absolute top-0 left-0 h-full bg-black flex items-center justify-center text-white text-xs font-black transition-all duration-1000" style="width: {{ $porcentaje }}%">
                        {{ round($porcentaje) }}%
                    </div>
                </div>
                <div class="text-center mt-1">
                    <span class="text-xs font-bold text-gray-600 italic">¡Se acaban!</span>
                </div>
            </div>
        </div>

        <!-- Sección Premios -->
        <div class="bg-black text-white py-3 text-center font-black uppercase tracking-widest mb-16 shadow-lg">
            Premios
        </div>

        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-x-12 gap-y-20 mb-32 max-w-7xl mx-auto">
                @foreach($sorteo->premios as $premio)
                <div class="flex flex-col items-center group">
                    <div class="w-full max-w-[280px] md:max-w-[320px] bg-black text-white py-3 md:py-4 px-6 md:px-8 rounded-t-[50px] md:rounded-t-[60px] font-black text-xl md:text-2xl text-center tracking-tight border-b-4 border-sorteo-green truncate">
                        {{ $premio['nombre'] }}
                    </div>
                    
                    <div class="flex flex-col items-center justify-center w-full pt-10 min-h-[260px]">
                        <div class="relative flex flex-col items-center transition-transform duration-500 group-hover:scale-105">
                            @if(isset($premio['imagen_url']))
                                <img src="{{ asset($premio['imagen_url']) }}" alt="{{ $premio['nombre'] }}" class="w-48 drop-shadow-2xl object-contain">
                            @else
                                {{-- Fallback para premios comunes --}}
                                @if(Str::contains(Str::lower($premio['nombre']), ['moto', 'carro', 'mayor']))
                                    <div class="flex items-end -space-x-10">
                                        <img src="https://img.icons8.com/color/400/motorcycle.png" alt="moto" class="w-40 z-10 drop-shadow-2xl">
                                        <img src="https://img.icons8.com/color/400/car.png" alt="car" class="w-56 drop-shadow-2xl">
                                    </div>
                                @elseif(Str::contains(Str::lower($premio['nombre']), ['play', 'ps5', 'consola']))
                                    <img src="https://img.icons8.com/color/500/playstation-5.png" alt="ps5" class="w-48 drop-shadow-2xl">
                                @else
                                    <img src="https://img.icons8.com/color/400/gift.png" alt="premio" class="w-40 drop-shadow-2xl">
                                @endif
                            @endif

                            @if(isset($premio['detalles']) && is_array($premio['detalles']))
                                <div class="flex flex-wrap justify-center gap-3 mt-8 font-black italic text-black uppercase text-xs rotate-[-3deg]">
                                   @foreach($premio['detalles'] as $detalle)
                                       <span class="bg-gray-100 px-3 py-1 shadow-md border-b-2 border-black">{{ $detalle }}</span>
                                   @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Numeros premiados para anticipados -->
            @if(count($sorteo->numeros_anticipados) > 0)
            <div class="mb-32 max-w-6xl mx-auto px-4">
                <h3 class="text-2xl font-black text-black mb-10 uppercase tracking-tighter">Numeros premiados para anticipados</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-12">
                    @foreach($sorteo->numeros_anticipados as $anticipado)
                    <div class="space-y-4">
                        <div class="bg-sorteo-green text-white text-center py-2.5 font-black uppercase text-sm tracking-widest px-4">
                            {{ $anticipado['titulo'] }}
                        </div>
                        <div class="flex flex-wrap justify-center gap-4">
                            @foreach($anticipado['numeros'] as $num)
                            <div class="bg-black text-white px-8 py-2 font-black text-2xl tracking-widest shadow-md">
                                {{ $num }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Separador Stickers -->
        <div class="bg-black text-white py-4 text-center font-black uppercase tracking-[0.4em] mb-12 w-full shadow-2xl">
            STICKERS
        </div>

        @php
            $disponibles = $sorteo->disponibles_count ?? 0;
        @endphp

        <div class="container mx-auto px-4 mb-32">
            <p class="text-center text-gray-800 text-sm mb-16 font-medium">Elije el paquete de stickers para mayor probabilidad ahora mismo</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-x-12 md:gap-y-12 mb-16 md:20 px-4 max-w-6xl mx-auto" id="paquetes-grid">
                @foreach($sorteo->paquetes as $paquete)
                    @if($disponibles >= $paquete->cantidad)
                        <button type="button" onclick="selectPaquete({{ $paquete->id }}, {{ $paquete->precio }}, {{ $paquete->cantidad }})" 
                            class="paquete-btn relative flex flex-col items-center transition-all duration-300 hover:scale-105 group" data-id="{{ $paquete->id }}">
                            
                            <div class="w-full">
                                <!-- Parte Superior Negra -->
                                <div class="bg-black text-white w-full py-3 md:py-4 font-black uppercase text-[13px] md:text-[15px] tracking-tight leading-none text-center group-hover:bg-gray-900 transition-colors">
                                    COMPRAR {{ $paquete->cantidad }} STICKERS
                                </div>
                                
                                <!-- Parte Inferior Verde -->
                                <div class="bg-sorteo-green text-white w-full py-2 md:py-3 font-black text-lg md:text-2xl leading-none text-center rounded-b-xl border-t-2 border-black/10 shadow-lg">
                                    ${{ number_format($paquete->precio, 0, ',', '.') }}
                                </div>
                            </div>

                            @if($paquete->es_extra)
                            <div class="absolute -right-1 md:-right-2 top-1 md:top-2 h-12 md:h-16 z-20">
                                 <span class="bg-sorteo-green text-white text-[8px] md:text-[10px] font-black px-1.5 md:px-2 h-full flex items-center [writing-mode:vertical-lr] uppercase border-2 border-white shadow-md rounded-full tracking-tighter">EXTRA</span>
                            </div>
                            @endif
                        </button>
                    @endif
                @endforeach
            </div>

            <!-- Formulario de Compra -->
            <form action="{{ route('checkout.iniciar') }}" method="POST" id="purchase-form" class="max-w-3xl mx-auto px-4">
                @csrf
                <input type="hidden" name="sorteo_id" value="{{ $sorteo->id }}">
                <input type="hidden" name="paquete_id" id="paquete_id_input">
                
                <div class="flex flex-col items-center gap-6 md:gap-8">
                    <div class="flex flex-col sm:flex-row items-center gap-4 md:gap-6 w-full sm:w-auto">
                        <!-- Selector Cantidad -->
                        <div class="flex items-center h-14 md:h-16 border-2 border-black overflow-hidden shadow-sm w-full sm:w-auto">
                            <button type="button" onclick="changeQty(-1)" class="bg-black text-white w-12 md:w-14 h-full flex items-center justify-center font-bold text-2xl md:text-3xl hover:bg-gray-900 transition">-</button>
                            <input type="number" name="cantidad" id="qty-input" value="1" min="1" max="{{ $disponibles }}" class="flex-1 sm:w-20 md:w-24 h-full text-center font-black text-2xl md:text-3xl bg-[#f3f4f6] focus:outline-none appearance-none m-0 border-none">
                            <button type="button" onclick="changeQty(1)" class="bg-black text-white w-12 md:w-14 h-full flex items-center justify-center font-bold text-2xl md:text-3xl hover:bg-gray-900 transition">+</button>
                        </div>
                        
                        <!-- Botón Comprar -->
                        <button type="submit" class="bg-black text-white w-full sm:w-auto px-8 md:px-12 h-14 md:h-16 font-black uppercase tracking-widest text-lg md:text-xl hover:bg-gray-900 transition flex items-center justify-center shadow-2xl">
                            COMPRAR AHORA
                        </button>
                    </div>
                    
                    <!-- Total -->
                    <div class="text-xl md:text-2xl font-medium text-gray-900 bg-gray-50 px-6 md:px-8 py-3 md:py-4 rounded-full border border-gray-100 shadow-inner">
                        Total a pagar: <span class="ml-2 font-black text-black" id="total-text">$0</span>
                    </div>
                </div>
            </form>
        </div>
    @else
        <div class="min-h-[60vh] flex flex-col items-center justify-center text-center px-4">
            <div class="w-24 h-24 mb-8 text-gray-200">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <h2 class="text-4xl font-black text-black uppercase tracking-tighter mb-4">Actualmente no hay sorteos en curso</h2>
            <p class="text-gray-500 max-w-md mx-auto font-medium">Estamos preparando nuevas y emocionantes oportunidades para ti. ¡Vuelve pronto para participar!</p>
            <div class="mt-10">
                <a href="{{ route('buscar') }}" class="inline-block bg-black text-white px-8 py-3 font-black uppercase tracking-widest hover:bg-gray-900 transition shadow-xl">
                    Buscar mis tickets anteriores
                </a>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    @if($sorteo)
    <script>
        const precioTicketBase = {{ $sorteo->precio_ticket }};
        const paquetesData = {{ Js::from($sorteo->paquetes->keyBy('id')) }};
        const ticketsDisponibles = {{ $disponibles }};
        let selectedPaqueteId = null;

        function selectPaquete(id, precio, cantidad) {
            const inputHidden = document.getElementById('paquete_id_input');
            const btns = document.querySelectorAll('.paquete-btn');
            const qtyInput = document.getElementById('qty-input');
            
            // Toggle selection
            if (selectedPaqueteId === id) {
                selectedPaqueteId = null;
                inputHidden.value = '';
                btns.forEach(btn => btn.classList.remove('ring-4', 'ring-sorteo-green', 'scale-105'));
                qtyInput.max = ticketsDisponibles;
            } else {
                selectedPaqueteId = id;
                inputHidden.value = id;
                btns.forEach(btn => {
                    if (btn.dataset.id == id) {
                        btn.classList.add('ring-4', 'ring-sorteo-green', 'scale-105');
                    } else {
                        btn.classList.remove('ring-4', 'ring-sorteo-green', 'scale-105');
                    }
                });
                // Update max for packages: how many full packages can fit in remaining tickets
                qtyInput.max = Math.floor(ticketsDisponibles / cantidad);
            }
            
            // Ensure current value doesn't exceed new max
            if (parseInt(qtyInput.value) > parseInt(qtyInput.max)) {
                qtyInput.value = qtyInput.max;
            }
            if (parseInt(qtyInput.value) < 1 && parseInt(qtyInput.max) >= 1) {
                qtyInput.value = 1;
            }

            updateTotal();
        }

        function changeQty(delta) {
            const input = document.getElementById('qty-input');
            let val = parseInt(input.value) + delta;
            if (val < 1) val = 1;
            if (val > parseInt(input.max)) val = parseInt(input.max);
            input.value = val;
            updateTotal();
        }

        function updateTotal() {
            const input = document.getElementById('qty-input');
            let qty = parseInt(input.value) || 0;
            const maxVal = parseInt(input.max);
            
            if (qty > maxVal) {
                qty = maxVal;
                input.value = qty;
            }

            let total = 0;

            if (selectedPaqueteId && paquetesData[selectedPaqueteId]) {
                 total = paquetesData[selectedPaqueteId].precio * qty;
            } else {
                 total = qty * precioTicketBase;
            }

            document.getElementById('total-text').innerText = '$' + total.toLocaleString('es-CO');
        }

        document.getElementById('qty-input').addEventListener('input', updateTotal);
        
        // Initial call
        updateTotal();
    </script>
    @endif
@endpush