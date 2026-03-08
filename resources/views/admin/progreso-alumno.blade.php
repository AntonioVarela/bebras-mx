<x-layouts.app :title="'Progreso de ' . $alumno->name . ' - Bebras Lab'">
    <div class="flex flex-col gap-6 p-4 lg:p-6">
        @php
            $total = count($progreso);
            $respondidas = collect($progreso)->filter(fn($p) => $p['progreso'] !== null)->count();
            $correctas = collect($progreso)->filter(fn($p) => $p['progreso'] && $p['progreso']->es_correcta)->count();
            $porcentaje = $respondidas > 0 ? round(($correctas / $respondidas) * 100) : 0;
        @endphp

        {{-- Header con volver y datos del alumno --}}
        <div class="bg-white/95 dark:bg-neutral-900/90 border border-neutral-200 dark:border-neutral-800 rounded-3xl shadow-xl px-6 py-5">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-pink-600 hover:text-pink-700 dark:text-pink-400 dark:hover:text-pink-300 mb-4" wire:navigate>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Volver al Panel
            </a>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-neutral-900 dark:text-white tracking-tight">
                        Progreso de {{ $alumno->name }}
                    </h1>
                    <p class="text-sm md:text-base text-neutral-600 dark:text-neutral-400 mt-1">{{ $alumno->email }}</p>
                </div>
                <div class="flex flex-wrap items-baseline gap-4 md:gap-6">
                    <div class="text-center md:text-right">
                        <div class="text-2xl md:text-3xl font-bold text-pink-600 dark:text-pink-400">{{ $respondidas }}/{{ $total }}</div>
                        <div class="text-xs font-medium text-neutral-500 dark:text-neutral-400">respondidas</div>
                    </div>
                    <div class="text-center md:text-right">
                        <div class="text-2xl md:text-3xl font-bold text-neutral-800 dark:text-white">{{ $porcentaje }}%</div>
                        <div class="text-xs font-medium text-neutral-500 dark:text-neutral-400">éxito</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Resumen en tarjetas --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-lg p-5">
                <div class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Total</div>
                <div class="text-2xl font-bold text-neutral-900 dark:text-white mt-1">{{ $total }}</div>
            </div>
            <div class="bg-green-50 dark:bg-green-900/20 rounded-2xl border border-green-200 dark:border-green-800 shadow-lg p-5">
                <div class="text-sm font-medium text-green-600 dark:text-green-400">Correctas</div>
                <div class="text-2xl font-bold text-green-700 dark:text-green-300 mt-1">{{ $correctas }}</div>
            </div>
            <div class="bg-red-50 dark:bg-red-900/20 rounded-2xl border border-red-200 dark:border-red-800 shadow-lg p-5">
                <div class="text-sm font-medium text-red-600 dark:text-red-400">Incorrectas</div>
                <div class="text-2xl font-bold text-red-700 dark:text-red-300 mt-1">{{ $respondidas - $correctas }}</div>
            </div>
            <div class="bg-neutral-50 dark:bg-neutral-800/50 rounded-2xl border border-neutral-200 dark:border-neutral-700 shadow-lg p-5">
                <div class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Pendientes</div>
                <div class="text-2xl font-bold text-neutral-700 dark:text-neutral-200 mt-1">{{ $total - $respondidas }}</div>
            </div>
        </div>

        {{-- Tabla de preguntas --}}
        <div class="bg-white/95 dark:bg-neutral-900/90 rounded-3xl shadow-xl border border-neutral-200 dark:border-neutral-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-800">
                    <thead class="bg-neutral-50 dark:bg-neutral-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wide">#</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wide">Pregunta</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wide">Nivel</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wide">Dificultad</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wide">Estado</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wide">Fecha</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-neutral-800">
                        @foreach($progreso as $item)
                            <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900 dark:text-white">
                                    {{ $item['pregunta']->numero }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-neutral-900 dark:text-white">{{ $item['pregunta']->titulo }}</div>
                                    <div class="text-xs text-neutral-500 dark:text-neutral-400">{{ $item['pregunta']->pais_origen }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex px-2 py-1 rounded-lg text-xs font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                        {{ $item['pregunta']->nivel }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex px-2 py-1 rounded-lg text-xs font-semibold
                                        {{ $item['pregunta']->dificultad === 'Baja' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : '' }}
                                        {{ $item['pregunta']->dificultad === 'Media' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300' : '' }}
                                        {{ $item['pregunta']->dificultad === 'Alta' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300' : '' }}">
                                        {{ $item['pregunta']->dificultad }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($item['progreso'])
                                        @if($item['progreso']->es_correcta)
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                                Correcta
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-200">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                                Incorrecta
                                            </span>
                                        @endif
                                    @else
                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-neutral-100 text-neutral-600 dark:bg-neutral-700 dark:text-neutral-300">
                                            Sin responder
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-neutral-500 dark:text-neutral-400">
                                    @if($item['progreso'] && $item['progreso']->completada_at)
                                        {{ $item['progreso']->completada_at->format('d/m/Y H:i') }}
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
