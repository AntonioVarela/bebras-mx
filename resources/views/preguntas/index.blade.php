<x-layouts.app :title="__('Biblioteca de Preguntas')">
        <div class="flex flex-col gap-4 sm:gap-6 p-3 sm:p-4 lg:p-6">

        {{-- Header --}}
        <div class="bg-white/95 dark:bg-neutral-900/90 border border-yellow-300/70 dark:border-neutral-700 rounded-3xl shadow-xl px-4 sm:px-6 py-4 sm:py-5">
            <h1 class="text-2xl md:text-3xl font-extrabold text-neutral-900 dark:text-white tracking-tight">
                Biblioteca de Preguntas
            </h1>
            <p class="text-sm md:text-base text-neutral-600 dark:text-neutral-300 font-medium mt-1">
                Bebras Lab - Primavera 2025 · Pensamiento Computacional
            </p>
            @auth
                @if(auth()->user()->isAdmin())
                    <div class="mt-4">
                        <a href="{{ route('admin.dashboard') }}"
                            class="inline-flex items-center gap-2 rounded-2xl border border-purple-300 bg-purple-50 dark:bg-purple-900/30 px-4 py-2 text-sm font-semibold text-purple-700 dark:text-purple-200 hover:bg-purple-100 dark:hover:bg-purple-900/50 transition-colors">
                            Panel Admin
                        </a>
                    </div>
                @endif
            @endauth
        </div>

        {{-- Estadísticas del alumno --}}
        @auth
            @if(auth()->user()->isAlumno())
                @php
                    $totalPreguntas = $preguntas->count();
                    $respondidas = $progreso->count();
                    $correctas = $progreso->filter(fn($p) => $p)->count();
                    $porcentaje = $respondidas > 0 ? round(($correctas / $respondidas) * 100) : 0;
                @endphp
                <div class="bg-white dark:bg-neutral-900 rounded-3xl shadow-xl border border-neutral-200 dark:border-neutral-800 p-6">
                    <h2 class="text-lg font-bold text-neutral-800 dark:text-white mb-4">Tu Progreso</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center bg-neutral-50 dark:bg-neutral-800/50 rounded-2xl p-4 border border-neutral-200 dark:border-neutral-700">
                            <div class="text-2xl font-bold bg-gradient-to-r from-yellow-500 via-pink-500 to-purple-500 bg-clip-text text-transparent">{{ $respondidas }}</div>
                            <div class="text-xs font-medium text-neutral-600 dark:text-neutral-400">Respondidas</div>
                        </div>
                        <div class="text-center bg-green-50 dark:bg-green-900/20 rounded-2xl p-4 border border-green-200 dark:border-green-800">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $correctas }}</div>
                            <div class="text-xs font-medium text-neutral-600 dark:text-neutral-400">Correctas</div>
                        </div>
                        <div class="text-center bg-red-50 dark:bg-red-900/20 rounded-2xl p-4 border border-red-200 dark:border-red-800">
                            <div class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $respondidas - $correctas }}</div>
                            <div class="text-xs font-medium text-neutral-600 dark:text-neutral-400">Incorrectas</div>
                        </div>
                        <div class="text-center bg-neutral-50 dark:bg-neutral-800/50 rounded-2xl p-4 border border-neutral-200 dark:border-neutral-700">
                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $porcentaje }}%</div>
                            <div class="text-xs font-medium text-neutral-600 dark:text-neutral-400">Éxito</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="w-full bg-neutral-200 dark:bg-neutral-700 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-yellow-400 via-pink-400 to-purple-500 h-2 rounded-full transition-all"
                                 style="width: {{ $totalPreguntas > 0 ? round(($respondidas / $totalPreguntas) * 100) : 0 }}%"></div>
                        </div>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-2 text-center font-medium">
                            {{ $respondidas }} de {{ $totalPreguntas }} preguntas completadas
                        </p>
                    </div>
                </div>
            @endif
        @endauth

        {{-- Filtros --}}
        <div class="bg-white dark:bg-neutral-900 rounded-3xl shadow-xl border border-neutral-200 dark:border-neutral-800 p-4 sm:p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">Nivel</label>
                    <select id="filtro-nivel" class="w-full min-h-[44px] border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 rounded-xl px-3 py-2.5 text-neutral-800 dark:text-neutral-200 focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all touch-manipulation">
                        <option value="">Todos</option>
                        <option value="I">Nivel I</option>
                        <option value="II">Nivel II</option>
                        <option value="III">Nivel III</option>
                        <option value="IV">Nivel IV</option>
                        <option value="V">Nivel V</option>
                        <option value="VI">Nivel VI</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">Dificultad</label>
                    <select id="filtro-dificultad" class="w-full min-h-[44px] border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 rounded-xl px-3 py-2.5 text-neutral-800 dark:text-neutral-200 focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all touch-manipulation">
                        <option value="">Todas</option>
                        <option value="Baja">Baja</option>
                        <option value="Media">Media</option>
                        <option value="Alta">Alta</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">Estado</label>
                    <select id="filtro-estado" class="w-full min-h-[44px] border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 rounded-xl px-3 py-2.5 text-neutral-800 dark:text-neutral-200 focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all touch-manipulation">
                        <option value="">Todas</option>
                        <option value="correcta">Correctas</option>
                        <option value="incorrecta">Incorrectas</option>
                        <option value="pendiente">Pendientes</option>
                    </select>
                </div>
                <div class="flex items-end sm:col-span-2 md:col-span-1">
                    <button onclick="aplicarFiltros()"
                            class="w-full min-h-[44px] bg-gradient-to-r from-yellow-400 via-pink-400 to-purple-500 hover:from-yellow-500 hover:via-pink-500 hover:to-purple-600 text-white py-3 sm:py-2.5 rounded-2xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 touch-manipulation">
                        Aplicar Filtros
                    </button>
                </div>
            </div>
        </div>

        {{-- Grid de Preguntas --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($preguntas as $pregunta)
                @php
                    $yaRespondio = $progreso->has($pregunta->id);
                    $esCorrecta = $yaRespondio && $progreso->get($pregunta->id);
                @endphp

                <a href="{{ route('preguntas.show', $pregunta->id) }}"
                   class="pregunta-card block bg-white dark:bg-neutral-900 rounded-2xl shadow-lg hover:shadow-xl border border-neutral-200 dark:border-neutral-800 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden group min-h-[44px] active:scale-[0.98] touch-manipulation"
                   data-nivel="{{ $pregunta->nivel }}"
                   data-dificultad="{{ $pregunta->dificultad }}"
                   data-estado="{{ $yaRespondio ? ($esCorrecta ? 'correcta' : 'incorrecta') : 'pendiente' }}"
                   wire:navigate>

                    <div class="p-5">
                        <div class="flex items-start justify-between mb-3 {{ $yaRespondio ? 'pr-20' : '' }}">
                            <div class="flex-1">
                                <span class="text-3xl font-bold bg-gradient-to-r from-yellow-500 via-pink-500 to-purple-500 bg-clip-text text-transparent block mb-2">{{ $pregunta->numero }}</span>
                                <div class="flex gap-2 flex-wrap">
                                    <span class="px-2 py-0.5 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-xs font-semibold">
                                        Nivel {{ $pregunta->nivel }}
                                    </span>
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                        {{ $pregunta->dificultad === 'Baja' ? 'bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300' : '' }}
                                        {{ $pregunta->dificultad === 'Media' ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : '' }}
                                        {{ $pregunta->dificultad === 'Alta' ? 'bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300' : '' }}">
                                        {{ $pregunta->dificultad }}
                                    </span>
                                </div>
                            </div>
                            @if($yaRespondio)
                                <div class="absolute top-4 right-4">
                                    @if($esCorrecta)
                                        <span class="bg-green-500 text-white px-2.5 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                            Correcta
                                        </span>
                                    @else
                                        <span class="bg-red-500 text-white px-2.5 py-1 rounded-full text-xs font-bold">Incorrecta</span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <h3 class="text-lg font-bold text-neutral-800 dark:text-white mb-2 group-hover:text-pink-600 dark:group-hover:text-pink-400 transition-colors line-clamp-2">{{ $pregunta->titulo }}</h3>
                        <p class="text-neutral-600 dark:text-neutral-400 text-sm line-clamp-3 leading-relaxed">{{ Str::limit($pregunta->descripcion, 120) }}</p>

                        <div class="mt-4 pt-3 border-t border-neutral-200 dark:border-neutral-700 flex items-center justify-between text-sm">
                            <span class="text-neutral-500 dark:text-neutral-400 text-xs">{{ $pregunta->pais_origen }}</span>
                            <span class="font-semibold text-pink-600 dark:text-pink-400 flex items-center gap-1 text-xs">
                                {{ $yaRespondio ? 'Ver resultado' : 'Resolver' }}
                                <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <script>
        function aplicarFiltros() {
            const nivel = document.getElementById('filtro-nivel').value;
            const dificultad = document.getElementById('filtro-dificultad').value;
            const estado = document.getElementById('filtro-estado').value;

            document.querySelectorAll('.pregunta-card').forEach(card => {
                let mostrar = true;
                if (nivel && card.dataset.nivel !== nivel) mostrar = false;
                if (dificultad && card.dataset.dificultad !== dificultad) mostrar = false;
                if (estado && card.dataset.estado !== estado) mostrar = false;
                card.style.display = mostrar ? 'block' : 'none';
            });
        }
    </script>
</x-layouts.app>
