
@php
    $config = is_string($pregunta->configuracion) ? json_decode($pregunta->configuracion, true) : $pregunta->configuracion;
@endphp

@if(isset($config['computadoras']))
    {{-- Formato para pregunta 23: computadoras con estados --}}
    <div class="space-y-3">
        @php
            $computadoras = $config['computadoras'] ?? 12;
            $opcionesPorComputadora = $config['opciones_por_computadora'] ?? ['virus_rojo', 'virus_azul', 'desconectada'];
            $estadosMap = [
                'virus_rojo' => ['nombre' => 'Virus Rojo', 'color' => 'text-red-600', 'bg' => 'bg-red-50'],
                'virus_azul' => ['nombre' => 'Virus Azul', 'color' => 'text-blue-600', 'bg' => 'bg-blue-50'],
                'desconectada' => ['nombre' => 'Desconectada', 'color' => 'text-gray-600', 'bg' => 'bg-gray-50'],
            ];
        @endphp
        
        @for($i = 1; $i <= $computadoras; $i++)
            <div class="border-2 border-gray-200 rounded-lg p-3">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Computadora {{ $i }}:
                </label>
                <div class="grid grid-cols-3 gap-2">
                    @foreach($opcionesPorComputadora as $opcion)
                        @php
                            $estadoInfo = $estadosMap[$opcion] ?? ['nombre' => ucfirst($opcion), 'color' => 'text-gray-600', 'bg' => 'bg-gray-50'];
                        @endphp
                        <label class="opcion-seleccionada-multicolor flex items-center p-2 border-2 border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-500 cursor-pointer transition-all {{ $estadoInfo['bg'] }}">
                            <input 
                                type="radio" 
                                name="computadora_{{ $i }}" 
                                value="{{ $opcion }}"
                                class="w-4 h-4 text-blue-600 focus:ring-blue-500 mr-2 computadora-estado"
                                data-computadora="{{ $i }}"
                                data-estado="{{ $opcion }}">
                            <span class="flex-1 text-sm {{ $estadoInfo['color'] }} font-medium">
                                {{ $estadoInfo['nombre'] }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endfor
    </div>
@else
    {{-- Formato estándar: lista de opciones con checkboxes --}}
    <div class="space-y-2">
        @foreach($config['opciones'] ?? [] as $opcion)
            <label class="opcion-seleccionada-multicolor flex items-center p-2 border-2 border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-500 cursor-pointer transition-all">
                <input 
                    type="checkbox" 
                    name="opciones[]" 
                    value="{{ $opcion['id'] }}"
                    class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500 mr-2">
                <span class="flex-1 text-sm text-neutral-800 dark:text-neutral-100">
                    <span class="font-bold text-blue-600 mr-2">{{ $opcion['id'] }})</span>
                    <span>{{ $opcion['valor'] }}</span>
                </span>
            </label>
        @endforeach
    </div>
@endif

@if(isset($config['nota']))
    <p class="text-xs text-gray-600 mt-2 italic">ℹ️ {{ $config['nota'] }}</p>
@endif