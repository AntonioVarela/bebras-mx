@php
    $config = is_array($config ?? null) ? $config : (is_string($pregunta->configuracion ?? null) ? json_decode($pregunta->configuracion, true) : ($pregunta->configuracion ?? []));
    $opciones = $config['opciones'] ?? [];
    $formato = $config['formato'] ?? null;
    $tieneImagen = !empty($opciones[0]['imagen'] ?? null);
@endphp

@if(isset($config['dias']))
    {{-- P48: Velas por día - checkboxes por cada día --}}
    <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4">Selecciona al menos una opción en cada día, luego haz clic en <strong>Verificar Respuesta</strong>.</p>
    <div class="space-y-4">
        @foreach($config['dias'] as $idx => $diaLabel)
            @php $diaKey = 'domingo' . ($idx + 1); @endphp
            <div class="border-2 border-neutral-200 dark:border-neutral-700 rounded-xl p-3">
                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">{{ $diaLabel }}</label>
                <div class="flex flex-wrap gap-2">
                    @foreach($opciones as $opcion)
                        <label class="opcion-seleccionada-multicolor flex items-center p-2 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg hover:bg-pink-50 dark:hover:bg-pink-900/20 cursor-pointer transition-all min-h-[44px] touch-manipulation">
                            <input type="checkbox" name="completar_dia_{{ $diaKey }}[]" value="{{ $opcion['id'] }}"
                                   class="w-4 h-4 text-pink-600 rounded focus:ring-pink-500 mr-2 completar-dia" data-dia="{{ $diaKey }}">
                            <span class="text-sm text-neutral-800 dark:text-neutral-200">{{ $opcion['valor'] ?? $opcion['id'] }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

@elseif(isset($config['zancos']))
    {{-- P36: Castores en zancos - emparejar --}}
    <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4">Asigna un zanco a cada castor usando los menús desplegables. Debes seleccionar todos antes de verificar.</p>
    <div class="space-y-3">
        @foreach($opciones as $opcion)
            <div class="flex flex-nowrap items-center gap-3 p-2 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl">
                <span class="flex-1 text-sm font-medium text-neutral-800 dark:text-neutral-200 min-w-0 truncate">{{ $opcion['valor'] ?? $opcion['id'] }}</span>
                <select class="completar-zanco flex-shrink-0 w-20 min-w-[5rem] h-9 border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 rounded-lg px-2 py-1.5 text-sm text-neutral-800 dark:text-neutral-200 focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all" data-castor="{{ $opcion['id'] }}">
                    <option value="">Zanco...</option>
                    @foreach($config['zancos'] as $zanco)
                        <option value="{{ $zanco }}">{{ $zanco }}</option>
                    @endforeach
                </select>
            </div>
        @endforeach
    </div>

@elseif($formato === 'slots' && !empty($config['slots']))
    {{-- P28: Slots (martes, miércoles) con selects --}}
    <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4">Elige una opción en cada casilla (ej. martes, miércoles…). Completa todas antes de verificar.</p>
    <div class="space-y-3">
        @foreach($config['slots'] as $slotKey => $slotLabel)
            <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                <label class="text-sm font-semibold text-neutral-700 dark:text-neutral-300 sm:w-28">{{ $slotLabel }}:</label>
                <select class="completar-slot flex-1 h-9 border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 rounded-lg px-3 py-1.5 text-sm text-neutral-800 dark:text-neutral-200 focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all" data-slot="{{ $slotKey }}">
                    <option value="">Selecciona...</option>
                    @foreach($opciones as $opcion)
                        <option value="{{ $opcion['id'] }}">{{ $opcion['valor'] ?? $opcion['id'] }}</option>
                    @endforeach
                </select>
            </div>
        @endforeach
    </div>

@elseif(isset($config['blanks']) && $config['blanks'] > 0)
    {{-- P49: Blanks en secuencia (padre/madre) --}}
    <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4">Selecciona la opción correcta en cada casilla numerada. Debes completar todas para verificar.</p>
    <div class="space-y-3">
        @for($i = 0; $i < (int)$config['blanks']; $i++)
            <div class="flex items-center gap-2">
                <label class="text-sm font-semibold text-neutral-700 dark:text-neutral-300 w-20">Casilla {{ $i + 1 }}:</label>
                <select class="completar-blank flex-1 h-9 border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 rounded-lg px-3 py-1.5 text-sm text-neutral-800 dark:text-neutral-200 focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all" data-index="{{ $i }}">
                    <option value="">Selecciona...</option>
                    @foreach($opciones as $opcion)
                        <option value="{{ $opcion['id'] }}">{{ $opcion['valor'] ?? $opcion['id'] }}</option>
                    @endforeach
                </select>
            </div>
        @endfor
    </div>

@elseif($formato === 'string')
    {{-- P55: String con input y botones B,N,X --}}
    <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4">Escribe la secuencia usando el teclado o los botones B, N y X. Puedes hacer clic en los botones para agregar cada letra.</p>
    <div class="space-y-2">
        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">Escribe tu respuesta (usa B, N y X):</label>
        <input type="text" id="completar-string" class="w-full border border-neutral-300 dark:border-neutral-600 rounded-lg px-3 py-2 text-sm dark:bg-neutral-800 dark:text-white focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all" placeholder="Ej: XXXBNBXNXNB" maxlength="50" autocomplete="off">
        <div class="flex flex-wrap gap-2 mt-2">
            @foreach($opciones as $opcion)
                <button type="button" class="completar-char-btn px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg text-sm font-bold hover:bg-pink-100 dark:hover:bg-pink-900/30 transition-all" data-char="{{ $opcion['id'] }}">{{ $opcion['valor'] ?? $opcion['id'] }}</button>
            @endforeach
        </div>
    </div>

@elseif($tieneImagen)
    {{-- P29: Ordenar con imágenes - Sortable --}}
    <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4">Arrastra los elementos desde <strong>Disponibles</strong> hasta <strong>Orden</strong>, colocándolos en el orden correcto de arriba a abajo.</p>
    @php
        $elementos = $opciones;
        $elementosMezclados = $elementos;
        shuffle($elementosMezclados);
    @endphp
    <div class="grid md:grid-cols-2 gap-3">
        <div>
            <h4 class="text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">Disponibles:</h4>
            <div id="completar-fuente" class="bg-neutral-100 dark:bg-neutral-800 border-2 border-dashed border-neutral-300 dark:border-neutral-600 rounded-xl p-2 min-h-[120px] overflow-y-auto">
                @foreach($elementosMezclados as $el)
                    <div class="completar-draggable bg-white dark:bg-neutral-800 border-2 border-neutral-300 dark:border-neutral-600 rounded-lg p-2 mb-1 cursor-move hover:shadow-lg transition-shadow touch-manipulation" data-id="{{ $el['id'] }}">
                        <img src="{{ asset('storage/' . ($el['imagen'] ?? '')) }}" alt="{{ $el['id'] }}" class="w-full h-16 object-contain">
                    </div>
                @endforeach
            </div>
        </div>
        <div>
            <h4 class="text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">Orden (arriba a abajo):</h4>
            <div id="completar-destino" class="bg-pink-50 dark:bg-pink-900/20 border-2 border-dashed border-pink-300 dark:border-pink-700 rounded-xl p-2 min-h-[120px] overflow-y-auto">
                <p class="text-xs text-neutral-400 text-center py-4" id="completar-placeholder">Arrastra aquí</p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

@else
    {{-- P50, P57: Selección múltiple (checkboxes, orden aleatorio) --}}
    @php
        $opcionesCheckbox = $opciones;
        shuffle($opcionesCheckbox);
    @endphp
    <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4">Marca todas las opciones correctas (puede haber más de una). Luego haz clic en <strong>Verificar Respuesta</strong>.</p>
    <div class="space-y-2">
        @foreach($opcionesCheckbox as $opcion)
            <label class="opcion-seleccionada-multicolor flex items-center p-3 border-2 border-neutral-300 dark:border-neutral-600 rounded-xl hover:bg-pink-50 dark:hover:bg-pink-900/20 cursor-pointer transition-all min-h-[44px] touch-manipulation">
                <input type="checkbox" name="completar_opciones[]" value="{{ $opcion['id'] }}" class="completar-checkbox w-4 h-4 text-pink-600 rounded focus:ring-pink-500 mr-3">
                <span class="text-sm text-neutral-800 dark:text-neutral-200">{{ $opcion['valor'] ?? $opcion['id'] }}</span>
            </label>
        @endforeach
    </div>
@endif
