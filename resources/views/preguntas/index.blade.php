<!-- resources/views/preguntas/index.blade.php - ACTUALIZAR -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca de Preguntas - Nestbytes Olimpo</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
    
    {{-- Header --}}
    <div class="relative z-10 bg-white/95 dark:bg-neutral-900/95 backdrop-blur-xl shadow-lg border-b border-white/30">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">Nestbytes Olimpo - Primavera 2025</h1>
                    <p class="text-neutral-600 dark:text-neutral-400 mt-2">Biblioteca de Preguntas de Pensamiento Computacional</p>
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" 
                               class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                Panel Admin
                            </a>
                        @endif
                        <div class="text-right bg-white/50 dark:bg-neutral-800/50 px-4 py-2 rounded-xl backdrop-blur-sm">
                            <p class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">{{ auth()->user()->role === 'admin' ? 'Administrador' : 'Alumno' }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 text-sm font-semibold transition-colors">
                                Cerrar Sesión
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 py-8 flex-1">
        
        {{-- Estadísticas del alumno --}}
        @auth
            @if(auth()->user()->isAlumno())
                @php
                    $totalPreguntas = $preguntas->count();
                    $respondidas = $progreso->count();
                    $correctas = $progreso->filter(fn($p) => $p)->count();
                    $porcentaje = $respondidas > 0 ? round(($correctas / $respondidas) * 100) : 0;
                @endphp
                <div class="bg-white/95 dark:bg-neutral-900/95 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/30 p-6 mb-6 animate-slide-up">
                    <h2 class="text-xl font-bold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent mb-4">Tu Progreso</h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="text-center bg-white/50 dark:bg-neutral-800/50 backdrop-blur-sm rounded-xl p-4 border border-white/30">
                            <div class="text-3xl font-bold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">{{ $respondidas }}</div>
                            <div class="text-sm text-neutral-600 dark:text-neutral-400 font-medium">Respondidas</div>
                        </div>
                        <div class="text-center bg-white/50 dark:bg-neutral-800/50 backdrop-blur-sm rounded-xl p-4 border border-white/30">
                            <div class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $correctas }}</div>
                            <div class="text-sm text-neutral-600 dark:text-neutral-400 font-medium">Correctas</div>
                        </div>
                        <div class="text-center bg-white/50 dark:bg-neutral-800/50 backdrop-blur-sm rounded-xl p-4 border border-white/30">
                            <div class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $respondidas - $correctas }}</div>
                            <div class="text-sm text-neutral-600 dark:text-neutral-400 font-medium">Incorrectas</div>
                        </div>
                        <div class="text-center bg-white/50 dark:bg-neutral-800/50 backdrop-blur-sm rounded-xl p-4 border border-white/30">
                            <div class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">{{ $porcentaje }}%</div>
                            <div class="text-sm text-neutral-600 dark:text-neutral-400 font-medium">Éxito</div>
                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="w-full bg-white/50 dark:bg-neutral-800/50 backdrop-blur-sm rounded-full h-3 border border-white/30">
                            <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 h-3 rounded-full transition-all shadow-lg" 
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
        <div class="bg-white/95 dark:bg-neutral-900/95 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/30 p-6 mb-6 animate-slide-up" style="animation-delay: 0.1s;">
            <div class="grid md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">Nivel</label>
                    <select id="filtro-nivel" class="w-full border-2 border-white/40 bg-white/50 dark:bg-neutral-800/50 backdrop-blur-sm rounded-xl px-3 py-2 text-neutral-700 dark:text-neutral-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition-all">
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
                    <select id="filtro-dificultad" class="w-full border-2 border-white/40 bg-white/50 dark:bg-neutral-800/50 backdrop-blur-sm rounded-xl px-3 py-2 text-neutral-700 dark:text-neutral-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition-all">
                        <option value="">Todas</option>
                        <option value="Baja">Baja</option>
                        <option value="Media">Media</option>
                        <option value="Alta">Alta</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">Estado</label>
                    <select id="filtro-estado" class="w-full border-2 border-white/40 bg-white/50 dark:bg-neutral-800/50 backdrop-blur-sm rounded-xl px-3 py-2 text-neutral-700 dark:text-neutral-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition-all">
                        <option value="">Todas</option>
                        <option value="correcta">Correctas</option>
                        <option value="incorrecta">Incorrectas</option>
                        <option value="pendiente">Pendientes</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button onclick="aplicarFiltros()" 
                            class="w-full bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white py-2.5 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        Aplicar Filtros
                    </button>
                </div>
            </div>
        </div>

        {{-- Grid de Preguntas --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($preguntas as $pregunta)
                @php
                    $yaRespondio = $progreso->has($pregunta->id);
                    $esCorrecta = $yaRespondio && $progreso->get($pregunta->id);
                @endphp
                
                <a href="{{ route('preguntas.show', $pregunta->id) }}" 
                   class="pregunta-card block bg-white/95 dark:bg-neutral-900/95 backdrop-blur-xl rounded-3xl shadow-xl hover:shadow-2xl border border-white/30 transition-all duration-300 transform hover:-translate-y-2 hover:scale-[1.02] relative overflow-hidden group"
                   data-nivel="{{ $pregunta->nivel }}"
                   data-dificultad="{{ $pregunta->dificultad }}"
                   data-estado="{{ $yaRespondio ? ($esCorrecta ? 'correcta' : 'incorrecta') : 'pendiente' }}">
                    
                    <div class="p-6">
                        {{-- Header con número y badges --}}
                        <div class="flex items-start justify-between mb-4 relative">
                            <div class="flex-1 {{ $yaRespondio ? 'pr-24' : '' }}">
                                <span class="text-4xl font-bold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent block mb-3">{{ $pregunta->numero }}</span>
                                <div class="flex gap-2 flex-wrap">
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
                            
                            {{-- Status Badge - Posicionado en la esquina superior derecha --}}
                            @if($yaRespondio)
                                <div class="absolute top-0 right-0 z-10">
                                    @if($esCorrecta)
                                        <div class="bg-green-500 text-white px-3 py-1.5 rounded-full text-xs font-bold flex items-center gap-1 shadow-lg backdrop-blur-sm whitespace-nowrap">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Correcta
                                        </div>
                                    @else
                                        <div class="bg-red-500 text-white px-3 py-1.5 rounded-full text-xs font-bold shadow-lg backdrop-blur-sm whitespace-nowrap">
                                            Incorrecta
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                        
                        <h3 class="text-xl font-bold text-neutral-800 dark:text-white mb-3 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $pregunta->titulo }}</h3>
                        <p class="text-neutral-600 dark:text-neutral-400 text-sm line-clamp-3 leading-relaxed">{{ Str::limit($pregunta->descripcion, 150) }}</p>
                        
                        <div class="mt-5 pt-4 border-t border-white/30 dark:border-neutral-700/50 flex items-center justify-between text-sm">
                            <span class="text-neutral-500 dark:text-neutral-400">{{ $pregunta->pais_origen }}</span>
                            @if($yaRespondio)
                                <span class="font-semibold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent flex items-center gap-1">
                                    Ver resultado
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            @else
                                <span class="font-semibold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent flex items-center gap-1">
                                    Resolver
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            @endif
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

    <style>
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

    @include('layouts.footer')
</body>
</html>