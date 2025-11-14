<!-- resources/views/preguntas/show.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pregunta->titulo }} - Nestbytes Olimpo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @if($pregunta->tipo_interaccion === 'ordenar')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    @endif
</head>
<body class="min-h-screen flex flex-col relative">
    <!-- Fondo con gradiente animado -->
    <div class="fixed inset-0 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 dark:from-indigo-900 dark:via-purple-900 dark:to-pink-900">
        <!-- Patrón de puntos decorativo -->
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 30px 30px;"></div>
        <!-- Círculos decorativos animados -->
        <div class="absolute top-0 -left-4 w-96 h-96 bg-purple-400 rounded-full mix-blend-multiply opacity-30 animate-pulse" style="filter: blur(80px); animation-duration: 8s;"></div>
        <div class="absolute top-0 -right-4 w-96 h-96 bg-pink-400 rounded-full mix-blend-multiply opacity-30 animate-pulse" style="filter: blur(80px); animation-duration: 10s; animation-delay: 2s;"></div>
        <div class="absolute -bottom-8 left-20 w-96 h-96 bg-indigo-400 rounded-full mix-blend-multiply opacity-30 animate-pulse" style="filter: blur(80px); animation-duration: 12s; animation-delay: 4s;"></div>
    </div>
    
    {{-- Navegación Superior --}}
    <div class="relative z-10 bg-white/95 dark:bg-neutral-900/95 backdrop-blur-xl shadow-lg border-b border-white/30">
        <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('preguntas.index') }}" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 flex items-center gap-2 font-semibold transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver a preguntas
            </a>
            <div class="text-sm font-semibold text-neutral-700 dark:text-neutral-300 bg-white/50 dark:bg-neutral-800/50 px-4 py-1.5 rounded-full backdrop-blur-sm">
                Pregunta {{ $pregunta->numero }} de 27
            </div>
        </div>
    </div>

    <div class="relative z-10 max-w-5xl mx-auto py-6 px-4 flex-1">
        
        {{-- Descripción --}}
        <div class="bg-white/95 dark:bg-neutral-900/95 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/30 p-6 mb-6 animate-slide-up">
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1">
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent mb-2">
                        {{ $pregunta->numero }}. {{ $pregunta->titulo }}
                    </h2>
                    <div class="flex gap-2 mb-3">
                        <span class="px-3 py-1 bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 rounded-full text-xs font-semibold backdrop-blur-sm">
                            Nivel {{ $pregunta->nivel }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-sm
                            {{ $pregunta->dificultad === 'Baja' ? 'bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300' : '' }}
                            {{ $pregunta->dificultad === 'Media' ? 'bg-yellow-100 dark:bg-yellow-900/50 text-yellow-700 dark:text-yellow-300' : '' }}
                            {{ $pregunta->dificultad === 'Alta' ? 'bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300' : '' }}">
                            {{ $pregunta->dificultad }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="prose max-w-none">
                <p class="text-sm text-neutral-700 dark:text-neutral-300 leading-relaxed whitespace-pre-line">{{ $pregunta->descripcion }}</p>
            </div>
            
            @if($pregunta->imagen_descripcion)
                <div class="mt-4 flex justify-center">
                    <img src="{{ asset('storage/' . $pregunta->imagen_descripcion) }}" 
                         alt="Descripción" 
                         class="max-w-full max-h-48 rounded-xl shadow-lg object-contain border-2 border-white/30">
                </div>
            @endif
        </div>

        {{-- Pregunta --}}
        <div class="bg-white/95 dark:bg-neutral-900/95 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/30 p-6 animate-slide-up" style="animation-delay: 0.1s;">
            <h3 class="text-xl font-bold text-neutral-800 dark:text-white mb-4 pb-3 border-b-2 border-indigo-500">
                {{ $pregunta->pregunta }}
            </h3>
            
            @if($pregunta->imagen_pregunta)
                <div class="mb-4 flex justify-center">
                    <img src="{{ asset('storage/' . $pregunta->imagen_pregunta) }}" 
                         alt="Pregunta" 
                         class="max-w-full max-h-48 rounded-xl shadow-lg object-contain border-2 border-white/30">
                </div>
            @endif

            {{-- Contenedor dinámico según tipo de interacción --}}
            <div id="contenedor-interaccion" class="mb-3">
                @if(!empty($pregunta->tipo_interaccion))
                    @php
                        $tipoVista = 'preguntas.tipos.' . $pregunta->tipo_interaccion;
                        $vistaExiste = view()->exists($tipoVista);
                    @endphp
                    @if($vistaExiste)
                        @include($tipoVista, ['config' => $pregunta->configuracion, 'pregunta' => $pregunta])
                    @else
                        <div class="bg-red-50 border-2 border-red-400 rounded-lg p-6 text-center">
                            <svg class="w-16 h-16 text-red-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <h4 class="text-xl font-bold text-red-800 mb-2">Vista No Encontrada</h4>
                            <p class="text-red-700 mb-2">No se encontró la vista para el tipo: <strong>{{ $pregunta->tipo_interaccion }}</strong></p>
                            <p class="text-sm text-red-600">Vista esperada: <code>{{ $tipoVista }}</code></p>
                        </div>
                    @endif
                @else
                    <div class="bg-yellow-50 border-2 border-yellow-400 rounded-lg p-6 text-center">
                        <svg class="w-16 h-16 text-yellow-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <h4 class="text-xl font-bold text-yellow-800 mb-2">Tipo de Interacción No Implementado</h4>
                        <p class="text-yellow-700">Esta pregunta aún no tiene un tipo de interacción implementado. Por favor, contacta al administrador.</p>
                    </div>
                @endif
            </div>

            {{-- Botón de verificar --}}
            <button 
                id="btnVerificar"
                onclick="verificarRespuesta()"
                @if(empty($pregunta->tipo_interaccion)) disabled @endif
                class="w-full bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white py-3.5 px-4 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300 font-bold text-base flex items-center justify-center gap-2 group @if(empty($pregunta->tipo_interaccion)) opacity-50 cursor-not-allowed @endif">
                @if(empty($pregunta->tipo_interaccion))
                    Tipo de Interacción No Disponible
                @else
                    <span>Verificar Respuesta</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @endif
            </button>

            {{-- Resultado (oculto inicialmente) --}}
            <div id="resultado" class="hidden mt-3"></div>

            {{-- Botones de navegación (ocultos inicialmente) --}}
            <div id="navegacion" class="hidden mt-3 flex gap-2">
                @php
                    $preguntaAnterior = \App\Models\Pregunta::where('numero', '<', $pregunta->numero)
                        ->orderBy('numero', 'desc')
                        ->first();
                    $preguntaSiguiente = \App\Models\Pregunta::where('numero', '>', $pregunta->numero)
                        ->orderBy('numero', 'asc')
                        ->first();
                @endphp

                @if($preguntaAnterior)
                    <a href="{{ route('preguntas.show', $preguntaAnterior->id) }}" 
                       class="flex-1 bg-white/20 dark:bg-neutral-800/20 backdrop-blur-md hover:bg-white/30 dark:hover:bg-neutral-800/30 text-neutral-800 dark:text-neutral-200 border-2 border-white/30 hover:border-white/50 py-2.5 px-4 rounded-xl font-semibold text-sm transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Anterior
                    </a>
                @else
                    <div class="flex-1"></div>
                @endif

                @if($preguntaSiguiente)
                    <a href="{{ route('preguntas.show', $preguntaSiguiente->id) }}" 
                       class="flex-1 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white py-2.5 px-4 rounded-xl font-semibold text-sm transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center gap-2">
                        Siguiente
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('preguntas.index') }}" 
                       class="flex-1 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white py-2.5 px-4 rounded-xl font-semibold text-sm transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center gap-2">
                        Finalizar
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </a>
                @endif
            </div>
        </div>

    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-slide-up {
            animation: slide-up 0.8s ease-out both;
        }
    </style>

    {{-- Scripts específicos por tipo --}}
    @if(!empty($pregunta->tipo_interaccion))
        @php
            $tipoScript = 'preguntas.scripts.' . $pregunta->tipo_interaccion;
            $scriptExiste = view()->exists($tipoScript);
        @endphp
        @if($scriptExiste)
            @include($tipoScript, ['config' => $pregunta->configuracion, 'progresoUsuario' => $progresoUsuario ?? null])
        @endif
    @endif

    {{-- Script general de verificación --}}
    <script>
        let respondido = {{ $yaRespondio ? 'true' : 'false' }};
        const preguntaId = {{ $pregunta->id }};
        const yaRespondioAntes = {{ $yaRespondio ? 'true' : 'false' }};

        @if($yaRespondio)
            document.addEventListener('DOMContentLoaded', function() {
                const btnVerificar = document.getElementById('btnVerificar');
                btnVerificar.disabled = true;
                btnVerificar.classList.add('opacity-50', 'cursor-not-allowed');
                btnVerificar.textContent = 'Ya Respondiste Esta Pregunta';
                
                deshabilitarInteraccion();
                
                // Mostrar resultado previo
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
                    resultado.className = 'mt-3 p-3 rounded-lg bg-green-50 border-2 border-green-500';
                    resultado.innerHTML = `
                        <div class="flex items-start gap-2">
                            <svg class="w-8 h-8 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex-1">
                                <h4 class="font-bold text-green-800 text-lg mb-2">¡Respondiste Correctamente! 🎉</h4>
                                <p class="text-sm text-green-700 leading-snug mb-2">${data.explicacion}</p>
                                ${data.imagen_respuesta ? `
                                    <div class="mt-2 flex justify-center">
                                        <img src="/storage/${data.imagen_respuesta}" 
                                            alt="Solución" 
                                            class="max-w-full max-h-48 rounded-lg shadow-md object-contain">
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                    `;
                } else {
                    resultado.className = 'mt-3 p-3 rounded-lg bg-red-50 border-2 border-red-500';
                    resultado.innerHTML = `
                        <div class="flex items-start gap-2">
                            <svg class="w-8 h-8 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex-1">
                                <h4 class="font-bold text-red-800 text-lg mb-2">Tu respuesta fue incorrecta</h4>
                                <p class="text-sm text-red-700 leading-snug mb-2">${data.explicacion}</p>
                                ${data.imagen_respuesta ? `
                                    <div class="mt-2 flex justify-center">
                                        <img src="/storage/${data.imagen_respuesta}" 
                                            alt="Solución" 
                                            class="max-w-full max-h-48 rounded-lg shadow-md object-contain">
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                    `;
                }
            }
        @endif
        function verificarRespuesta() {
            if (respondido || yaRespondioAntes) {
                alert('Ya respondiste esta pregunta anteriormente.');
                return;
            }

            const respuesta = obtenerRespuesta();
            
            if (!respuesta) {
                alert('Por favor completa tu respuesta antes de verificar');
                return;
            }

            // Enviar a Laravel
            fetch(`/preguntas/${preguntaId}/verificar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ respuesta })
            })
            .then(response => response.json())
            .then(data => {
                respondido = true;
                mostrarResultado(data);
                deshabilitarInteraccion();
                mostrarNavegacion(); // 
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Hubo un error al verificar la respuesta');
            });
        }

        function mostrarResultado(data) {
            const resultado = document.getElementById('resultado');
            const btnVerificar = document.getElementById('btnVerificar');

            resultado.classList.remove('hidden');
            btnVerificar.disabled = true;
            btnVerificar.classList.add('opacity-50', 'cursor-not-allowed');

                if (data.correcta) {
                    resultado.className = 'mt-3 p-3 rounded-lg bg-green-50 border-2 border-green-500';
                    resultado.innerHTML = `
                        <div class="flex items-start gap-2">
                            <svg class="w-8 h-8 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex-1">
                                <h4 class="font-bold text-green-800 text-lg mb-2">Correcto!!!</h4>
                                <p class="text-sm text-green-700 leading-snug mb-2">${data.explicacion}</p>
                            ${data.imagen_respuesta ? `
                                <div class="mt-4 flex justify-center">
                                    <img src="/storage/${data.imagen_respuesta}" 
                                        alt="Solución" 
                                        class="max-w-full rounded-lg shadow-md">
                                </div>
                            ` : ''}
                        </div>
                    </div>
                `;
            } else {
                resultado.className = 'mt-3 p-3 rounded-lg bg-red-50 border-2 border-red-500';
                resultado.innerHTML = `
                    <div class="flex items-start gap-2">
                        <svg class="w-8 h-8 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="flex-1">
                            <h4 class="font-bold text-red-800 text-lg mb-2">Incorrecto </h4>
                            <p class="text-sm text-red-700 leading-snug mb-2">${data.explicacion}</p>
                            ${data.imagen_respuesta ? `
                                <div class="mt-4 flex justify-center">
                                    <img src="/storage/${data.imagen_respuesta}" 
                                        alt="Solución" 
                                        class="max-w-full rounded-lg shadow-md">
                                </div>
                            ` : ''}
                            ${data.respuesta_correcta_visual ? `
                                <div class="mt-4 p-4 bg-white rounded border border-red-200">
                                    <p class="font-semibold text-red-800 mb-2">Respuesta correcta:</p>
                                    <p class="text-red-700">${data.respuesta_correcta_visual}</p>
                                </div>
                            ` : ''}
                        </div>
                    </div>
                `;
            }

            // Scroll suave al resultado
            resultado.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        // Funcion para mostrar los botones de navegación
        function mostrarNavegacion() {
            const navegacion = document.getElementById('navegacion');
            navegacion.classList.remove('hidden');
            navegacion.classList.add('animate-fadeIn');
            
            // Scroll suave hacia los botones
            setTimeout(() => {
                navegacion.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }, 500);
        }
    </script>

@include('layouts.footer')
</body>

</html>