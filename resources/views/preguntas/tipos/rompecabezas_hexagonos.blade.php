@php
    $config = is_string($config) ? json_decode($config, true) : $config;
    $piezasDisponibles = $config['piezas_disponibles'] ?? [];
    $estructura = $config['estructura'] ?? [];
    $colores = $config['colores'] ?? ['red', 'blue', 'green'];
    
    // Mezclar piezas para orden aleatorio
    $piezasMezcladas = $piezasDisponibles;
    shuffle($piezasMezcladas);
@endphp

<div class="rompecabezas-hexagonos-container">
    {{-- Instrucciones (se muestra la correcta según dispositivo vía JS) --}}
    <div class="instrucciones-arrastre-rp bg-blue-50 border-l-4 border-blue-500 p-2 rounded mb-2 text-xs text-blue-800">
        <strong>Instrucciones:</strong> Arrastra las piezas hexagonales al rompecabezas. Haz clic en una pieza colocada para rotarla. Doble clic para removerla. Cada triángulo formado (pieza nueva + 2 de abajo) debe tener todas las piezas del mismo color O todas de colores diferentes.
    </div>
    <div class="instrucciones-toque-rp bg-blue-50 border-l-4 border-blue-500 p-2 rounded mb-2 text-xs text-blue-800" style="display:none">
        <strong>Instrucciones:</strong> Toca una pieza para seleccionarla, luego toca la celda donde colocarla. Toca una celda ocupada (sin pieza seleccionada) para removerla. Toca la celda con una pieza ya seleccionada para rotarla.
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
        {{-- Panel de piezas disponibles --}}
        <div class="lg:col-span-1">
            <h4 class="text-sm font-semibold text-gray-700 mb-2">
                Piezas disponibles: 
                <span class="text-xs font-normal text-gray-500" id="contador-piezas">
                    ({{ count($piezasMezcladas) }})
                </span>
            </h4>
            <div id="piezas-disponibles" class="bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg p-2 min-h-[200px] space-y-2 max-h-[400px] overflow-y-auto">
                @foreach($piezasMezcladas as $pieza)
                    <div class="pieza-item bg-white border-2 border-gray-300 rounded-lg p-2 cursor-move hover:shadow-lg transition-shadow touch-manipulation"
                         data-pieza-id="{{ $pieza['id'] }}"
                         data-color="{{ $pieza['color'] }}"
                         data-imagen="{{ $pieza['imagen'] ?? '' }}"
                         draggable="true">
                        <div class="flex items-center gap-2">
                            <div class="flex-shrink-0 pieza-hexagono flex items-center justify-center border-2 overflow-hidden"
                                 style="background-color: {{ $pieza['color'] }}; border-color: {{ $pieza['color'] }};">
                                @if(!empty($pieza['imagen'] ?? null))
                                    <img src="{{ asset('storage/' . $pieza['imagen']) }}"
                                         alt="Pieza {{ $pieza['id'] }}"
                                         class="w-full h-full object-contain">
                                @else
                                    <span class="text-xs font-bold text-white drop-shadow">{{ $pieza['id'] }}</span>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-gray-800">Pieza {{ $pieza['id'] }}</p>
                                <p class="text-xs text-gray-500 capitalize">{{ $pieza['color'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Grid del rompecabezas --}}
        <div class="lg:col-span-2">
            <h4 class="text-sm font-semibold text-gray-700 mb-2">
                Rompecabezas: 
                <span class="text-xs font-normal text-gray-500" id="contador-colocadas">
                    (0/{{ count($estructura) }} colocadas)
                </span>
            </h4>
            
            {{-- Grid hexagonal del rompecabezas --}}
            <div class="bg-white border-2 border-gray-300 rounded-lg p-3">
                <div id="grid-rompecabezas" class="flex flex-col items-center gap-1">
                    @foreach($estructura as $filaIndex => $fila)
                        <div class="flex gap-1 justify-center" style="margin-left: {{ $filaIndex * 18 }}px;">
                            @foreach($fila as $colIndex => $celda)
                                @if($celda === null)
                                    {{-- Celda vacía, no se muestra --}}
                                @elseif(isset($celda['fija']) && $celda['fija'])
                                    {{-- Celda fija (ya colocada inicialmente) --}}
                                    <div class="celda-hexagono flex items-center justify-center border-2 relative"
                                         style="background-color: {{ $celda['color'] }}; border-color: {{ $celda['color'] }};"
                                         data-fila="{{ $filaIndex }}"
                                         data-columna="{{ $celda['columna'] ?? $colIndex }}"
                                         data-fija="true"
                                         data-color="{{ $celda['color'] }}">
                                        <span class="text-xs font-bold text-white drop-shadow">{{ $celda['id'] ?? '' }}</span>
                                    </div>
                                @else
                                    {{-- Celda vacía para colocar pieza --}}
                                    <div class="celda-hexagono border-2 border-gray-300 bg-gray-50 hover:bg-gray-100 transition-all cursor-pointer flex items-center justify-center relative"
                                         data-fila="{{ $filaIndex }}"
                                         data-columna="{{ $celda['columna'] ?? $colIndex }}"
                                         data-fija="false"
                                         data-ocupada="false">
                                        <span class="text-xs text-gray-400">{{ $celda['columna'] ?? $colIndex }}</span>
                                        <div class="pieza-en-celda hidden absolute inset-0 flex items-center justify-center border-2 overflow-hidden">
                                            <img class="pieza-en-celda-imagen hidden w-full h-full object-contain" alt="">
                                            <span class="text-xs font-bold text-white drop-shadow"></span>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Resumen de colocación --}}
    <div class="mt-2 bg-gray-50 border border-gray-200 rounded-lg p-2">
        <h5 class="text-xs font-semibold text-gray-700 mb-1">Piezas colocadas:</h5>
        <div id="resumen-colocacion" class="text-xs text-gray-600">
            <p>Ninguna pieza colocada aún.</p>
        </div>
    </div>
</div>

<style>
    .pieza-item {
        user-select: none;
        touch-action: manipulation;
    }

    .pieza-item.dragging {
        opacity: 0.5;
    }

    /* Pieza seleccionada en modo táctil */
    .pieza-item.pieza-toque-activa {
        border-color: #ec4899 !important;
        background-color: #fdf2f8;
        box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.45);
    }

    .celda-hexagono {
        touch-action: manipulation;
    }
    
    /* Forma hexagonal para piezas y celdas del rompecabezas - responsive */
    .pieza-hexagono,
    .celda-hexagono,
    .celda-hexagono .pieza-en-celda {
        width: 2.25rem;
        height: 2.25rem;
        clip-path: polygon(
            25% 3%, 75% 3%,
            97% 50%,
            75% 97%, 25% 97%,
            3% 50%
        );
    }
    
    .celda-hexagono {
        position: relative;
    }
    
    .celda-hexagono.ocupada {
        background-color: #fef3c7;
        border-color: #f59e0b;
    }
    
    .celda-hexagono.drag-over {
        background-color: #dbeafe;
        border-color: #3b82f6;
        transform: scale(1.05);
    }
    
    .celda-hexagono:hover:not(.ocupada):not([data-fija="true"]) {
        background-color: #e0e7ff;
        border-color: #6366f1;
    }
    
    .celda-hexagono[data-fija="true"] {
        cursor: default;
    }
    
    @media (min-width: 640px) {
        .pieza-hexagono,
        .celda-hexagono,
        .celda-hexagono .pieza-en-celda {
            width: 2.75rem;
            height: 2.75rem;
        }
    }
    
    @media (min-width: 768px) {
        .pieza-hexagono,
        .celda-hexagono,
        .celda-hexagono .pieza-en-celda {
            width: 3.25rem;
            height: 3.25rem;
        }
    }
</style>

