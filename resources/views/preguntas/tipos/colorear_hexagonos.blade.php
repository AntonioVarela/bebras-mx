@php
    $config = is_string($config) ? json_decode($config, true) : $config;
    $coloresDisponibles = $config['colores_disponibles'] ?? ['verde', 'amarillo', 'azul'];
    $filas = $config['filas'] ?? 5;
    $hexagonosIniciales = $config['hexagonos_iniciales'] ?? [];
    
    // Mapeo de colores en español a clases CSS
    $colorMap = [
        'verde' => ['nombre' => 'Verde', 'clase' => 'bg-green-500', 'valor' => 'verde'],
        'amarillo' => ['nombre' => 'Amarillo', 'clase' => 'bg-yellow-400', 'valor' => 'amarillo'],
        'azul' => ['nombre' => 'Azul', 'clase' => 'bg-blue-500', 'valor' => 'azul'],
    ];
    
    // Crear estructura de la pirámide
    $estructura = [];
    $coloresFijos = [];
    foreach ($hexagonosIniciales as $hex) {
        $fila = $hex['posicion'][0];
        $col = $hex['posicion'][1];
        $coloresFijos["$fila-$col"] = $hex['color'];
    }
    
    // Generar estructura piramidal: fila 0 = 1 hex, fila 1 = 2 hex, ... fila (filas-1) = filas hex (base)
    for ($fila = 0; $fila < $filas; $fila++) {
        $estructura[$fila] = [];
        $numHexagonos = $fila + 1;
        for ($col = 0; $col < $numHexagonos; $col++) {
            $key = "$fila-$col";
            $estructura[$fila][$col] = [
                'fija' => isset($coloresFijos[$key]),
                'color' => $coloresFijos[$key] ?? null
            ];
        }
    }
@endphp

<div class="colorear-hexagonos-container">
    {{-- Instrucciones --}}
    <div class="bg-blue-50 border-l-4 border-blue-500 p-2 rounded mb-2 text-xs text-blue-800">
        <strong>Instrucciones:</strong> Selecciona un color y haz clic en un hexágono vacío para colorearlo. Cada triángulo formado (hexágono nuevo + 2 de abajo) debe tener todas las piezas del mismo color O todas de colores diferentes.
    </div>

    {{-- Paleta de colores --}}
    <div class="mb-3">
        <h4 class="text-sm font-semibold text-gray-800 mb-2">Selecciona un color:</h4>
        <div class="flex gap-2 justify-center">
            @foreach($coloresDisponibles as $color)
                @php
                    $colorInfo = $colorMap[$color] ?? ['nombre' => ucfirst($color), 'clase' => 'bg-gray-500', 'valor' => $color];
                @endphp
                <button 
                    type="button"
                    class="color-btn px-4 py-2 rounded-lg text-sm font-semibold text-white transition-all shadow-md border-2 {{ $colorInfo['clase'] }} hover:opacity-80"
                    data-color="{{ $colorInfo['valor'] }}"
                    onclick="seleccionarColor('{{ $colorInfo['valor'] }}')">
                    {{ $colorInfo['nombre'] }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Grid piramidal del rompecabezas --}}
    <div class="bg-white border-2 border-gray-300 rounded-lg p-4">
        @php
            $totalCeldas = 0;
            foreach ($estructura as $fila) {
                $totalCeldas += count($fila);
            }
            $totalAColorear = $totalCeldas - count($hexagonosIniciales);
        @endphp
        <h4 class="text-sm font-semibold text-gray-700 mb-3 text-center">
            Rompecabezas: 
            <span class="text-xs font-normal text-gray-500" id="contador-coloreados">
                (0/{{ $totalAColorear }} coloreados)
            </span>
        </h4>
        
        {{-- Pirámide normal: 1 hex arriba, 6 hex en la base (coincide con filas 0..5 del seeder) --}}
        <div id="grid-piramide" class="flex flex-col items-center gap-1">
            @php $numeroHexagono = 0; @endphp
            @foreach($estructura as $filaIndex => $fila)
                @php
                    $hexEnFila = count($fila);
                    $maxHex = $filas;
                    $margen = (int) (($maxHex - $hexEnFila) * 18 / 2);
                @endphp
                <div class="flex gap-1 justify-center" style="margin-left: {{ $margen }}px;">
                    @foreach($fila as $colIndex => $hexagono)
                        @php $numeroHexagono++; @endphp
                        @if($hexagono['fija'])
                            {{-- Hexágono fijo (ya coloreado inicialmente) --}}
                            <div class="hexagono-celda w-16 h-16 flex items-center justify-center border-2 relative cursor-default"
                                 style="background-color: {{ $hexagono['color'] === 'verde' ? '#10b981' : ($hexagono['color'] === 'amarillo' ? '#facc15' : '#3b82f6') }}; border-color: {{ $hexagono['color'] === 'verde' ? '#059669' : ($hexagono['color'] === 'amarillo' ? '#eab308' : '#2563eb') }};"
                                 data-fila="{{ $filaIndex }}"
                                 data-columna="{{ $colIndex }}"
                                 data-fija="true"
                                 data-color="{{ $hexagono['color'] }}">
                                <span class="text-xs font-semibold text-white drop-shadow-sm">{{ $numeroHexagono }}</span>
                            </div>
                        @else
                            {{-- Hexágono vacío para colorear --}}
                            <div class="hexagono-celda w-16 h-16 border-2 border-gray-300 bg-gray-50 hover:bg-gray-100 transition-all cursor-pointer flex items-center justify-center relative"
                                 data-fila="{{ $filaIndex }}"
                                 data-columna="{{ $colIndex }}"
                                 data-fija="false"
                                 data-color=""
                                 onclick="colorearHexagono(this)">
                                <span class="text-xs font-semibold text-gray-500">{{ $numeroHexagono }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    {{-- Resumen de colocación --}}
    <div class="mt-2 bg-gray-50 border border-gray-200 rounded-lg p-2">
        <h5 class="text-xs font-semibold text-gray-700 mb-1">Hexágonos coloreados:</h5>
        <div id="resumen-colocacion" class="text-xs text-gray-600">
            <p>Ningún hexágono coloreado aún.</p>
        </div>
    </div>
</div>

<style>
    .hexagono-celda {
        position: relative;
        user-select: none;
        /* Forma hexagonal para asemejar el diagrama */
        clip-path: polygon(
            25% 3%, 75% 3%,
            97% 50%,
            75% 97%, 25% 97%,
            3% 50%
        );
    }
    
    .hexagono-celda.coloreado {
        border-width: 3px;
    }
    
    .hexagono-celda:hover:not([data-fija="true"]):not(.coloreado) {
        background-color: #e0e7ff;
        border-color: #6366f1;
    }
    
    .color-btn.seleccionado {
        transform: scale(1.1);
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.3);
    }
</style>

