
<div class="grid md:grid-cols-2 gap-3">
    @php
        $config = $pregunta->configuracion;
        // Aceptar 'elementos' o 'opciones' (mapear valor -> nombre)
        $elementos = $config['elementos'] ?? array_map(function ($o) {
            return ['id' => $o['id'], 'nombre' => $o['valor'] ?? $o['nombre'] ?? $o['id']];
        }, $config['opciones'] ?? []);
        $elementosMezclados = $elementos;
        shuffle($elementosMezclados);
    @endphp
    
    {{-- Elementos desordenados --}}
    <div>
        <h4 class="text-sm font-semibold text-gray-700 mb-2">
            Disponibles: 
            <span class="text-xs font-normal text-gray-500" id="contador-fuente">
                ({{ count($elementosMezclados) }})
            </span>
        </h4>
        <div id="elementos-fuente" class="bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg p-2 min-h-[150px] max-h-[300px] overflow-y-auto">
            @foreach($elementosMezclados as $elemento)
                <div class="elemento-draggable bg-white border-2 border-gray-300 rounded-lg p-2 mb-1 cursor-move hover:shadow-lg transition-shadow touch-manipulation"
                     data-id="{{ $elemento['id'] }}">
                    @if(isset($elemento['imagen']))
                        <img src="{{ asset('storage/' . $elemento['imagen']) }}" alt="{{ $elemento['id'] }}" class="full w-auto h-12 object-contain">
                    @else
                        <span class="text-sm font-medium">{{ $elemento['nombre'] ?? $elemento['id'] }}</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    {{-- Área de ordenamiento --}}
    <div>
        <h4 class="text-sm font-semibold text-gray-700 mb-2">
            Orden correcto: 
            <span class="text-xs font-normal text-gray-500" id="contador-destino">(0)</span>
        </h4>
        <div id="area-ordenamiento" class="bg-blue-50 border-2 border-dashed border-blue-300 rounded-lg p-2 min-h-[150px] max-h-[300px] overflow-y-auto">
            <p class="text-xs text-gray-400 text-center py-4" id="placeholder-orden">Arrastra los elementos aquí</p>
        </div>
    </div>
</div>

@if(isset($pregunta->configuracion['mostrar_numeros']) && $pregunta->configuracion['mostrar_numeros'])
    <p class="text-sm text-gray-600 mt-3">Pista: Puedes ponerles números del 1 al {{ count($elementos) }}</p>
@endif