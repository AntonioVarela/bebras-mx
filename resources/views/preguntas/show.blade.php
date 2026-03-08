<x-layouts.app :title="$pregunta->titulo . ' - Bebras Lab'">
    @if(in_array($pregunta->tipo_interaccion, ['seleccion_simple', 'seleccion_multiple', 'completar']))
    <style>
        /* Borde eléctrico neón (cian → violeta → magenta) para opciones seleccionadas */
        .opcion-seleccionada-multicolor:has(input:checked),
        .opcion-seleccion-multicolor:has(input:checked),
        .opcion-btn.opcion-seleccionada {
            border: 4px solid transparent !important;
            background: linear-gradient(#e0f7ff, #e0f7ff) padding-box,
                        linear-gradient(90deg, #00f5ff 0%, #bf00ff 50%, #ff00aa 100%) border-box !important;
            background-origin: border-box !important;
            background-clip: padding-box, border-box !important;
            box-shadow: 0 4px 24px rgba(0, 245, 255, 0.45), 0 0 0 1px rgba(191, 0, 255, 0.3) !important;
        }
        .dark .opcion-seleccionada-multicolor:has(input:checked),
        .dark .opcion-seleccion-multicolor:has(input:checked),
        .dark .opcion-btn.opcion-seleccionada {
            background: linear-gradient(#1a1a2e, #1a1a2e) padding-box,
                        linear-gradient(90deg, #00f5ff 0%, #bf00ff 50%, #ff00aa 100%) border-box !important;
            background-origin: border-box !important;
            background-clip: padding-box, border-box !important;
            box-shadow: 0 4px 24px rgba(0, 245, 255, 0.55), 0 0 0 1px rgba(191, 0, 255, 0.4) !important;
        }
        /* Borde eléctrico al hacer hover o click (feedback inmediato) */
        .opcion-btn:hover,
        .opcion-btn:active,
        .opcion-seleccionada-multicolor:hover,
        .opcion-seleccionada-multicolor:active {
            border: 4px solid transparent !important;
            background: linear-gradient(#e0f7ff, #e0f7ff) padding-box,
                        linear-gradient(90deg, #00f5ff 0%, #bf00ff 50%, #ff00aa 100%) border-box !important;
            background-origin: border-box !important;
            background-clip: padding-box, border-box !important;
            box-shadow: 0 4px 24px rgba(0, 245, 255, 0.45), 0 0 0 1px rgba(191, 0, 255, 0.3) !important;
        }
        .dark .opcion-btn:hover,
        .dark .opcion-btn:active,
        .dark .opcion-seleccionada-multicolor:hover,
        .dark .opcion-seleccionada-multicolor:active {
            background: linear-gradient(#1a1a2e, #1a1a2e) padding-box,
                        linear-gradient(90deg, #00f5ff 0%, #bf00ff 50%, #ff00aa 100%) border-box !important;
            background-origin: border-box !important;
            background-clip: padding-box, border-box !important;
            box-shadow: 0 4px 24px rgba(0, 245, 255, 0.55), 0 0 0 1px rgba(191, 0, 255, 0.4) !important;
        }
    </style>
    @endif
    @if($pregunta->tipo_interaccion === 'ordenar')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    @endif

    <div class="flex flex-col gap-6 p-4 lg:p-6">

        {{-- Barra superior: volver + número de pregunta --}}
        <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-lg border border-neutral-200 dark:border-neutral-800 px-3 sm:px-4 py-3 flex items-center justify-between gap-2">
            <a href="{{ route('preguntas.index') }}"
               class="text-pink-600 hover:text-pink-700 dark:text-pink-400 dark:hover:text-pink-300 flex items-center gap-1.5 sm:gap-2 font-semibold text-sm sm:text-base transition-colors min-h-[44px] min-w-[44px] flex-shrink-0"
>
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="hidden xs:inline sm:inline">Volver</span>
            </a>
            <span class="text-xs sm:text-sm font-semibold text-neutral-700 dark:text-neutral-300 bg-neutral-100 dark:bg-neutral-800 px-3 sm:px-4 py-1.5 rounded-full whitespace-nowrap">
                {{ $pregunta->numero }}/27
            </span>
        </div>

        {{-- Descripción --}}
        <div class="bg-white dark:bg-neutral-900 rounded-3xl shadow-xl border border-neutral-200 dark:border-neutral-800 p-4 sm:p-6">
            <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">
                {{ $pregunta->numero }}. {{ $pregunta->titulo }}
            </h2>
            <div class="flex gap-2 mb-4">
                <span class="px-2.5 py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-xs font-semibold">Nivel {{ $pregunta->nivel }}</span>
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                    {{ $pregunta->dificultad === 'Baja' ? 'bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300' : '' }}
                    {{ $pregunta->dificultad === 'Media' ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : '' }}
                    {{ $pregunta->dificultad === 'Alta' ? 'bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300' : '' }}">
                    {{ $pregunta->dificultad }}
                </span>
            </div>
            <p class="text-sm text-neutral-700 dark:text-neutral-300 leading-relaxed whitespace-pre-line">{{ $pregunta->descripcion }}</p>
            @if($pregunta->imagen_descripcion)
                <div class="mt-4 flex justify-center overflow-x-auto">
                    <img src="{{ asset('storage/' . $pregunta->imagen_descripcion) }}" alt="Descripción"
                         class="max-w-full max-h-36 sm:max-h-48 rounded-xl shadow-lg object-contain border border-neutral-200 dark:border-neutral-700">
                </div>
            @endif
        </div>

        {{-- Pregunta e interacción --}}
        <div class="bg-white dark:bg-neutral-900 rounded-3xl shadow-xl border border-neutral-200 dark:border-neutral-800 p-4 sm:p-6">
            <h3 class="text-lg font-bold text-neutral-800 dark:text-white mb-4 pb-3 border-b-2 border-pink-500">
                {{ $pregunta->pregunta }}
            </h3>
            @if($pregunta->imagen_pregunta)
                <div class="mb-4 flex justify-center overflow-x-auto">
                    <img src="{{ asset('storage/' . $pregunta->imagen_pregunta) }}" alt="Pregunta"
                         class="max-w-full max-h-36 sm:max-h-48 rounded-xl shadow-lg object-contain border border-neutral-200 dark:border-neutral-700">
                </div>
            @endif

            <div id="contenedor-interaccion" class="mb-4">
                @if(!empty($pregunta->tipo_interaccion))
                    @php
                        $tipoVista = 'preguntas.tipos.' . $pregunta->tipo_interaccion;
                        $vistaExiste = view()->exists($tipoVista);
                    @endphp
                    @if($vistaExiste)
                        @include($tipoVista, ['config' => $pregunta->configuracion, 'pregunta' => $pregunta])
                    @else
                        <div class="bg-red-50 dark:bg-red-900/20 border-2 border-red-400 dark:border-red-700 rounded-2xl p-6 text-center">
                            <h4 class="text-lg font-bold text-red-800 dark:text-red-200 mb-2">Vista No Encontrada</h4>
                            <p class="text-red-700 dark:text-red-300 text-sm">No se encontró la vista para el tipo: <strong>{{ $pregunta->tipo_interaccion }}</strong></p>
                        </div>
                    @endif
                @else
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border-2 border-yellow-400 dark:border-yellow-700 rounded-2xl p-6 text-center">
                        <h4 class="text-lg font-bold text-yellow-800 dark:text-yellow-200 mb-2">Tipo de Interacción No Implementado</h4>
                        <p class="text-yellow-700 dark:text-yellow-300 text-sm">Esta pregunta aún no tiene un tipo de interacción implementado.</p>
                    </div>
                @endif
            </div>

            {{-- Botón verificar --}}
            <button id="btnVerificar"
                    onclick="verificarRespuesta()"
                    @if(empty($pregunta->tipo_interaccion)) disabled @endif
                    class="w-full min-h-[48px] bg-gradient-to-r from-yellow-400 via-pink-400 to-purple-500 hover:from-yellow-500 hover:via-pink-500 hover:to-purple-600 text-white py-3.5 px-4 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 font-bold text-sm sm:text-base flex items-center justify-center gap-2 touch-manipulation @if(empty($pregunta->tipo_interaccion)) opacity-50 cursor-not-allowed @endif">
                @if(empty($pregunta->tipo_interaccion))
                    Tipo de Interacción No Disponible
                @else
                    <span>Verificar Respuesta</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @endif
            </button>

            <div id="resultado" class="hidden mt-4"></div>

            {{-- Navegación --}}
            <div id="navegacion" class="hidden mt-4 flex flex-col sm:flex-row gap-3">
                @php
                    $preguntaAnterior = \App\Models\Pregunta::where('numero', '<', $pregunta->numero)->orderBy('numero', 'desc')->first();
                    $preguntaSiguiente = \App\Models\Pregunta::where('numero', '>', $pregunta->numero)->orderBy('numero', 'asc')->first();
                @endphp
                @if($preguntaAnterior)
                    <a href="{{ route('preguntas.show', $preguntaAnterior->id) }}"
                       class="flex-1 min-h-[44px] py-2.5 px-4 rounded-2xl font-semibold text-sm border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 text-neutral-800 dark:text-neutral-200 hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors flex items-center justify-center gap-2 touch-manipulation"
>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Anterior
                    </a>
                @else
                    <div class="flex-1"></div>
                @endif
                @if($preguntaSiguiente)
                    <a href="{{ route('preguntas.show', $preguntaSiguiente->id) }}"
                       class="flex-1 min-h-[44px] bg-gradient-to-r from-yellow-400 via-pink-400 to-purple-500 hover:from-yellow-500 hover:via-pink-500 hover:to-purple-600 text-white py-2.5 px-4 rounded-2xl font-semibold text-sm shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2 touch-manipulation"
>
                        Siguiente
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @else
                    <a href="{{ route('preguntas.index') }}"
                       class="flex-1 min-h-[44px] bg-gradient-to-r from-yellow-400 via-pink-400 to-purple-500 hover:from-yellow-500 hover:via-pink-500 hover:to-purple-600 text-white py-2.5 px-4 rounded-2xl font-semibold text-sm shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2 touch-manipulation"
>
                        Finalizar
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </a>
                @endif
            </div>
        </div>
    </div>

    @if(!empty($pregunta->tipo_interaccion))
        @php $tipoScript = 'preguntas.scripts.' . $pregunta->tipo_interaccion; @endphp
        @if(view()->exists($tipoScript))
            @include($tipoScript, ['config' => $pregunta->configuracion, 'progresoUsuario' => $progresoUsuario ?? null])
        @endif
    @endif

    <script>
        window._bebrasResp = {{ $yaRespondio ? 'true' : 'false' }};
        window._bebrasPregId = {{ $pregunta->id }};
        window._bebrasYaResp = {{ $yaRespondio ? 'true' : 'false' }};

        function escapeHtml(str) {
            if (str == null || str === undefined) return '';
            const div = document.createElement('div');
            div.textContent = String(str);
            return div.innerHTML;
        }

        @if($yaRespondio)
        document.addEventListener('DOMContentLoaded', function() {
            const btnVerificar = document.getElementById('btnVerificar');
            btnVerificar.disabled = true;
            btnVerificar.classList.add('opacity-50', 'cursor-not-allowed');
            btnVerificar.innerHTML = '<span>Ya Respondiste Esta Pregunta</span>';
            deshabilitarInteraccion();
            mostrarResultadoPrevio({
                correcta: {{ $progresoUsuario->es_correcta ? 'true' : 'false' }},
                explicacion: @json($pregunta->explicacion),
                respuesta_correcta_visual: '',
                imagen_respuesta: @json($pregunta->imagen_respuesta)
            });
            mostrarNavegacion();
        });
        function mostrarResultadoPrevio(data) {
            const resultado = document.getElementById('resultado');
            resultado.classList.remove('hidden');
            if (data.correcta) {
                resultado.className = 'mt-4 p-4 rounded-2xl bg-green-50 dark:bg-green-900/20 border-2 border-green-500 dark:border-green-600';
                resultado.innerHTML = '<div class="flex items-start gap-2"><svg class="w-8 h-8 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><div class="flex-1"><h4 class="font-bold text-green-800 dark:text-green-200 text-lg mb-2">¡Respondiste Correctamente! 🎉</h4><p class="text-sm text-green-700 dark:text-green-300 leading-snug mb-2">' + escapeHtml(data.explicacion) + '</p>' + (data.imagen_respuesta ? '<div class="mt-2 flex justify-center"><img src="/storage/' + escapeHtml(data.imagen_respuesta) + '" alt="Solución" class="max-w-full max-h-48 rounded-xl shadow-md object-contain"></div>' : '') + '</div></div>';
            } else {
                resultado.className = 'mt-4 p-4 rounded-2xl bg-red-50 dark:bg-red-900/20 border-2 border-red-500 dark:border-red-600';
                resultado.innerHTML = '<div class="flex items-start gap-2"><svg class="w-8 h-8 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><div class="flex-1"><h4 class="font-bold text-red-800 dark:text-red-200 text-lg mb-2">Tu respuesta fue incorrecta</h4><p class="text-sm text-red-700 dark:text-red-300 leading-snug mb-2">' + escapeHtml(data.explicacion) + '</p>' + (data.imagen_respuesta ? '<div class="mt-2 flex justify-center"><img src="/storage/' + escapeHtml(data.imagen_respuesta) + '" alt="Solución" class="max-w-full max-h-48 rounded-xl shadow-md object-contain"></div>' : '') + '</div></div>';
            }
        }
        @endif

        function verificarRespuesta() {
            const btnVerificar = document.getElementById('btnVerificar');
            if (window._bebrasResp || window._bebrasYaResp) {
                btnVerificar.disabled = true;
                return; // No mostrar alert en móvil (evita modal intrusivo por doble toque)
            }
            const respuesta = obtenerRespuesta();
            if (!respuesta) {
                const msg = (typeof getMensajeIncompleto === 'function') ? getMensajeIncompleto() : 'Por favor completa tu respuesta antes de verificar';
                alert(msg);
                return;
            }
            btnVerificar.disabled = true;
            btnVerificar.classList.add('opacity-50', 'cursor-not-allowed');
            btnVerificar.innerHTML = '<span>Verificando...</span>';
            fetch('/preguntas/' + window._bebrasPregId + '/verificar', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: JSON.stringify({ respuesta })
            })
            .then(r => r.json())
            .then(data => { window._bebrasResp = true; mostrarResultado(data); deshabilitarInteraccion(); mostrarNavegacion(); })
            .catch(e => { console.error(e); alert('Hubo un error al verificar la respuesta'); });
        }

        function mostrarResultado(data) {
            const resultado = document.getElementById('resultado');
            const btnVerificar = document.getElementById('btnVerificar');
            resultado.classList.remove('hidden');
            btnVerificar.disabled = true;
            btnVerificar.classList.add('opacity-50', 'cursor-not-allowed');
            if (data.correcta) {
                resultado.className = 'mt-4 p-4 rounded-2xl bg-green-50 dark:bg-green-900/20 border-2 border-green-500 dark:border-green-600';
                resultado.innerHTML = '<div class="flex items-start gap-2"><svg class="w-8 h-8 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><div class="flex-1"><h4 class="font-bold text-green-800 dark:text-green-200 text-lg mb-2">¡Correcto!</h4><p class="text-sm text-green-700 dark:text-green-300 leading-snug mb-2">' + escapeHtml(data.explicacion) + '</p>' + (data.imagen_respuesta ? '<div class="mt-4 flex justify-center"><img src="/storage/' + escapeHtml(data.imagen_respuesta) + '" alt="Solución" class="max-w-full rounded-xl shadow-md"></div>' : '') + '</div></div>';
            } else {
                resultado.className = 'mt-4 p-4 rounded-2xl bg-red-50 dark:bg-red-900/20 border-2 border-red-500 dark:border-red-600';
                resultado.innerHTML = '<div class="flex items-start gap-2"><svg class="w-8 h-8 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><div class="flex-1"><h4 class="font-bold text-red-800 dark:text-red-200 text-lg mb-2">Incorrecto</h4><p class="text-sm text-red-700 dark:text-red-300 leading-snug mb-2">' + escapeHtml(data.explicacion) + '</p>' + (data.imagen_respuesta ? '<div class="mt-4 flex justify-center"><img src="/storage/' + escapeHtml(data.imagen_respuesta) + '" alt="Solución" class="max-w-full rounded-xl shadow-md"></div>' : '') + (data.respuesta_correcta_visual ? '<div class="mt-4 p-4 bg-white dark:bg-neutral-800 rounded-xl border border-red-200 dark:border-red-800"><p class="font-semibold text-red-800 dark:text-red-200 mb-2">Respuesta correcta:</p><p class="text-red-700 dark:text-red-300">' + escapeHtml(data.respuesta_correcta_visual) + '</p></div>' : '') + '</div></div>';
            }
            resultado.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        function mostrarNavegacion() {
            const navegacion = document.getElementById('navegacion');
            navegacion.classList.remove('hidden');
            setTimeout(() => navegacion.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 300);
        }
    </script>
</x-layouts.app>
