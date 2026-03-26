@php
    $config = is_string($config) ? json_decode($config, true) : $config;
    $colores = $config['colores_disponibles'] ?? ['green', 'yellow', 'blue'];
    $areas = $config['areas'] ?? [];
    
    // Mapeo de colores en español a inglés para la respuesta
    $colorMap = [
        'verde' => 'green',
        'amarillo' => 'yellow',
        'azul' => 'blue',
        'green' => 'green',
        'yellow' => 'yellow',
        'blue' => 'blue'
    ];
@endphp

<div class="rellenar-container">
    {{-- Paleta de colores --}}
    <div class="mb-3">
        <h4 class="text-sm font-semibold text-gray-800 dark:text-neutral-200 mb-2">Selecciona un color:</h4>
        <div class="flex flex-wrap gap-2 justify-center">
            @foreach($colores as $color)
                @php
                    $colorNombre = $colorMap[$color] ?? $color;
                    $colorDisplay = [
                        'green' => ['nombre' => 'Verde', 'clase' => 'bg-green-500', 'hover' => 'hover:bg-green-600', 'border' => 'border-green-700'],
                        'yellow' => ['nombre' => 'Amarillo', 'clase' => 'bg-yellow-400', 'hover' => 'hover:bg-yellow-500', 'border' => 'border-yellow-600'],
                        'blue' => ['nombre' => 'Azul', 'clase' => 'bg-blue-500', 'hover' => 'hover:bg-blue-600', 'border' => 'border-blue-700'],
                    ][$colorNombre] ?? ['nombre' => ucfirst($color), 'clase' => 'bg-gray-500', 'hover' => 'hover:bg-gray-600', 'border' => 'border-gray-700'];
                @endphp
                <button 
                    type="button"
                    class="color-btn px-4 py-2 min-h-[44px] rounded-lg text-sm font-semibold text-white transition-all shadow-md border-2 touch-manipulation {{ $colorDisplay['clase'] }} {{ $colorDisplay['hover'] }} {{ $colorDisplay['border'] }}"
                    data-color="{{ $colorNombre }}"
                    onclick="seleccionarColor('{{ $colorNombre }}')">
                    {{ $colorDisplay['nombre'] }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Imagen y áreas --}}
    <div class="relative mb-3">
        @if(isset($pregunta) && $pregunta->imagen_descripcion)
            <img 
                src="{{ asset('storage/' . $pregunta->imagen_descripcion) }}" 
                alt="Imagen para colorear" 
                class="max-w-full max-h-48 mx-auto rounded-lg shadow-lg object-contain"
                id="imagen-rellenar">
        @endif
        
        {{-- Lista de áreas para colorear --}}
        <div class="mt-3 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-2">
            @foreach($areas as $area)
                <div class="area-item bg-white dark:bg-neutral-800 border-2 border-gray-300 dark:border-neutral-600 rounded-lg p-3 min-h-[44px] hover:border-blue-500 dark:hover:border-blue-400 transition-all cursor-pointer flex items-center touch-manipulation"
                     data-area-id="{{ $area['id'] }}"
                     onclick="seleccionarArea('{{ $area['id'] }}')">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex-1 min-w-0">
                            <h5 class="text-xs font-semibold text-gray-800 truncate">{{ $area['nombre'] }}</h5>
                        </div>
                        <div class="color-preview w-8 h-8 rounded-full border-2 border-gray-300 bg-gray-100 flex items-center justify-center flex-shrink-0"
                             id="preview-{{ $area['id'] }}">
                            <span class="text-xs text-gray-400">?</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Instrucciones --}}
    <div class="bg-blue-50 border-l-4 border-blue-500 p-2 rounded mb-2 text-xs text-blue-800">
        <strong>Instrucciones:</strong> Selecciona un color y luego haz clic en el área que quieres colorear. Áreas adyacentes no pueden tener el mismo color.
    </div>
</div>

<style>
    .color-btn.seleccionado {
        transform: scale(1.1);
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.3);
    }
    
    .area-item.seleccionada {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }
    
    .color-preview.coloreado {
        border-width: 3px;
    }
</style>

