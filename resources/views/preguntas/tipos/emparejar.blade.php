
<div class="grid md:grid-cols-2 gap-3">
    {{-- Objetos --}}
    <div>
        <h4 class="text-sm font-semibold text-gray-700 mb-2">Objetos:</h4>
        <div class="space-y-2">
            @foreach($pregunta->configuracion['objetos'] as $objeto)
                <div class="flex items-center gap-2">
                    <img src="{{ asset('storage/' . $objeto['imagen']) }}" 
                         alt="{{ $objeto['nombre'] }}" 
                         class="w-12 h-12 object-contain flex-shrink-0">
                    <span class="text-sm font-medium flex-1 min-w-0 truncate">{{ $objeto['nombre'] }}</span>
                    <select 
                        class="emparejamiento ml-auto flex-shrink-0 h-9 border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 rounded-lg px-3 py-1.5 text-sm text-neutral-800 dark:text-neutral-200 focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all"
                        data-objeto="{{ $objeto['id'] }}">
                        <option value="">Selecciona...</option>
                        @foreach($pregunta->configuracion['destinos'] as $destino)
                            <option value="{{ $destino['id'] }}">{{ $destino['nombre'] }}</option>
                        @endforeach
                    </select>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Destinos (visual) --}}
    <div>
        <h4 class="text-sm font-semibold text-gray-700 mb-2">Destinos:</h4>
        <div class="space-y-2">
            @foreach($pregunta->configuracion['destinos'] as $destino)
                <div class="p-2 bg-gray-100 border-2 border-gray-300 rounded-lg">
                    <span class="font-bold text-sm">{{ $destino['nombre'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>