@php
    $config = is_string($config) ? json_decode($config, true) : $config;
    $abejas = $config['abejas'] ?? [];
    $celdasHexagonales = $config['celdas_hexagonales'] ?? 19;
    
    // Mezclar abejas para que aparezcan en orden aleatorio
    $abejasMezcladas = $abejas;
    shuffle($abejasMezcladas);
@endphp

<div class="colocar-piezas-container">
    {{-- Instrucciones --}}
    <div class="bg-blue-50 border-l-4 border-blue-500 p-2 rounded mb-2 text-xs text-blue-800">
        <strong>Instrucciones:</strong> Arrastra cada abeja desde la lista y colócala en la celda del panal según su regla.
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
        {{-- Panel de abejas disponibles --}}
        <div class="lg:col-span-1">
            <h4 class="text-sm font-semibold text-gray-700 mb-2">
                Abejas: 
                <span class="text-xs font-normal text-gray-500" id="contador-abejas">
                    ({{ count($abejasMezcladas) }})
                </span>
            </h4>
            <div id="abejas-disponibles" class="bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg p-2 min-h-[200px] space-y-2 max-h-[400px] overflow-y-auto">
                @foreach($abejasMezcladas as $abeja)
                    <div class="abeja-item bg-white border-2 border-gray-300 rounded-lg p-2 cursor-move hover:shadow-lg transition-shadow"
                         data-abeja-id="{{ $abeja['id'] }}"
                         draggable="true">
                        <div class="flex items-center gap-2">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('storage/' . $abeja['imagen']) }}" 
                                     alt="Abeja {{ $abeja['id'] }}" 
                                     class="w-12 h-12 object-contain">
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-gray-800">Abeja {{ $abeja['id'] }}</p>
                            </div>
                        </div>
                       
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Panal hexagonal --}}
        <div class="lg:col-span-2">
            <h4 class="text-sm font-semibold text-gray-700 mb-2">
                Panal final
                <span class="text-xs font-normal text-gray-500" id="contador-celdas">
                    (0/{{ $celdasHexagonales }} celdas ocupadas)
                </span>
            </h4>
            
            {{-- Grid de celdas del panal en forma de panal.
                 - Si hay 7 celdas, se muestra un panal compacto de 7 hexágonos (2-3-2).
                 - En otros casos, se usa un panal de 19 celdas (3-4-5-4-3). --}}
            <div class="bg-white border-2 border-gray-300 rounded-lg p-3">
                <div id="grid-hexagonal" class="flex flex-col items-center gap-2 max-w-xl mx-auto {{ $celdasHexagonales === 7 ? 'panal-7-rotado' : '' }}">
                    @php
                        // Distribución de celdas por fila para formar el panal
                        if ($celdasHexagonales === 7) {
                            // Panal compacto de 7 espacios (uno por abeja)
                            $filasPanal = [2, 3, 2]; // 2-3-2 = 7
                        } else {
                            // Panal completo de 19 celdas
                            $filasPanal = [3, 4, 5, 4, 3];
                        }
                        $indiceCentro = intdiv(count($filasPanal) - 1, 2);
                        $celdaActual = 1;
                    @endphp

                    @foreach($filasPanal as $indiceFila => $cantidadCeldas)
                        <div class="flex gap-2 justify-center"
                             style="margin-left: {{ abs($indiceCentro - $indiceFila) * 18 }}px;">
                            @for($j = 0; $j < $cantidadCeldas && $celdaActual <= $celdasHexagonales; $j++, $celdaActual++)
                                <div class="celda-panal relative border-2 border-gray-300 bg-gray-50 hover:bg-gray-100 transition-all cursor-pointer flex items-center justify-center group"
                                     data-celda="{{ $celdaActual }}"
                                     data-ocupada="false">
                                    <span class="text-xs text-gray-700 font-semibold bg-white/80 px-1 rounded-sm">
                                        {{ $celdaActual }}
                                    </span>
                                    <div class="abeja-en-celda hidden absolute inset-0 flex items-center justify-center bg-yellow-50 border-2 border-yellow-300 overflow-hidden">
                                        <img src="" alt="" class="w-full h-full object-contain p-2">
                                        <button class="absolute top-1 right-1 w-5 h-5 bg-red-500 text-white rounded-full text-xs hover:bg-red-600 opacity-0 group-hover:opacity-100 transition-opacity"
                                                onclick="event.stopPropagation(); removerAbejaDeCeldaManual({{ $celdaActual }})"
                                                title="Remover abeja">
                                            ×
                                        </button>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Resumen de colocación --}}
    <div class="mt-2 bg-gray-50 border border-gray-200 rounded-lg p-2">
        <h5 class="text-xs font-semibold text-gray-700 mb-1">Abejas colocadas:</h5>
        <div id="resumen-colocacion" class="text-xs text-gray-600">
            <p>Ninguna abeja colocada aún.</p>
        </div>
    </div>
</div>

<style>
    .abeja-item {
        user-select: none;
    }
    
    .abeja-item.dragging {
        opacity: 0.5;
    }
    
    .celda-panal {
        position: relative;
    }
    
    /* Forma hexagonal para las celdas del panal y las abejas dentro - responsive */
    .celda-panal,
    .celda-panal .abeja-en-celda {
        width: 2.5rem;
        height: 2.5rem;
    }
    @media (min-width: 640px) {
        .celda-panal,
        .celda-panal .abeja-en-celda {
            width: 3rem;
            height: 3rem;
        }
    }
    @media (min-width: 768px) {
        .celda-panal,
        .celda-panal .abeja-en-celda {
            width: 4rem;
            height: 4rem;
        clip-path: polygon(
            25% 3%, 75% 3%,
            97% 50%,
            75% 97%, 25% 97%,
            3% 50%
        );
    }
    
    .celda-panal.ocupada {
        background-color: #fef3c7;
        border-color: #f59e0b;
    }
    
    .celda-panal.drag-over {
        background-color: #dbeafe;
        border-color: #3b82f6;
        transform: scale(1.05);
    }
    
    .celda-panal:hover:not(.ocupada) {
        background-color: #e0e7ff;
        border-color: #6366f1;
    }

    /* Rotar ligeramente el panal compacto de 7 celdas para asemejar la imagen de solución */
    .panal-7-rotado {
        transform: rotate(30deg);
        transform-origin: center;
    }

    /* Mantener las abejas en posición "normal" al compensar la rotación del panal */
    .panal-7-rotado .abeja-en-celda img {
        transform: rotate(-30deg);
    }
</style>

