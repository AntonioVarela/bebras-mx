<x-layouts.app :title="__('Panel de Administración')">
    <div class="flex flex-col gap-6 p-4 lg:p-6">

        {{-- Header dentro del layout principal --}}
        <div
            class="bg-white/95 dark:bg-neutral-900/90 border border-yellow-300/70 rounded-3xl shadow-xl px-6 py-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-neutral-900 dark:text-white tracking-tight">
                    Panel de Administración
                </h1>
                <p class="text-sm md:text-base text-neutral-600 dark:text-neutral-300 font-medium">
                    Bebras Lab - Primavera 2025
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('preguntas.index') }}"
                    class="inline-flex items-center gap-2 rounded-2xl border border-purple-300 bg-purple-50 px-4 py-2 text-sm font-semibold text-purple-700 hover:bg-purple-100 hover:border-purple-400 transition-colors">
                    <span>Ver Preguntas</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-2xl border border-red-300 bg-red-50 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-100 hover:border-red-400 transition-colors">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>

        {{-- Contenedor principal con tabs y contenido en tarjeta --}}
        <div
            class="bg-white/95 dark:bg-neutral-950/90 rounded-3xl shadow-xl border border-neutral-200 dark:border-neutral-800 px-4 py-5 md:px-6 md:py-6">
        
            {{-- Tabs --}}
            <div class="mb-5">
                <div class="border-b border-neutral-200 dark:border-neutral-700">
                    <nav class="-mb-px flex flex-wrap gap-4">
                        <button onclick="mostrarTab('alumnos')" id="tab-alumnos"
                            class="tab-button border-b-2 border-pink-500 py-3 px-1 text-sm font-semibold text-pink-600">
                            Alumnos ({{ $alumnos->count() }})
                        </button>
                        <button onclick="mostrarTab('preguntas')" id="tab-preguntas"
                            class="tab-button border-b-2 border-transparent py-3 px-1 text-sm font-semibold text-neutral-500 hover:text-neutral-800 hover:border-neutral-300 dark:text-neutral-400 dark:hover:text-neutral-100 dark:hover:border-neutral-500">
                            Gestionar Preguntas ({{ $preguntas->count() }})
                        </button>
                    </nav>
                </div>
            </div>

            {{-- Tab de Alumnos --}}
            <div id="content-alumnos" class="tab-content">
                <div
                    class="rounded-2xl border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-800">
                            <thead class="bg-neutral-50 dark:bg-neutral-900">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wide">
                                    Alumno
                                </th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wide">
                                    Respondidas
                                </th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wide">
                                    Correctas
                                </th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wide">
                                    Incorrectas
                                </th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wide">
                                    % Éxito
                                </th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wide">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-neutral-900 divide-y divide-neutral-200 dark:divide-neutral-800">
                            @foreach ($alumnos as $alumno)
                                @php
                                    $total = $alumno->progresos->count();
                                    $correctas = $alumno->progresos->where('es_correcta', true)->count();
                                    $incorrectas = $alumno->progresos->where('es_correcta', false)->count();
                                    $porcentaje = $total > 0 ? round(($correctas / $total) * 100) : 0;
                                @endphp
                                <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/70 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-yellow-400 via-pink-400 to-purple-500 rounded-full flex items-center justify-center shadow-md">
                                                <span class="text-white font-bold text-sm">
                                                    {{ substr($alumno->name, 0, 1) }}
                                                </span>
                                            </div>
                                            <div class="ml-4">
                                                <div
                                                    class="text-sm font-semibold text-neutral-900 dark:text-neutral-50">
                                                    {{ $alumno->name }}
                                                </div>
                                                <div class="text-sm text-neutral-500 dark:text-neutral-400">
                                                    {{ $alumno->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span
                                            class="inline-flex items-center justify-center rounded-full bg-neutral-100 dark:bg-neutral-800 px-3 py-1 text-xs font-semibold text-neutral-800 dark:text-neutral-100">
                                            {{ $total }}/27
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300">
                                            {{ $correctas }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300">
                                            {{ $incorrectas }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <div
                                                class="w-20 bg-neutral-200 dark:bg-neutral-800 rounded-full h-2 overflow-hidden">
                                                <div
                                                    class="bg-gradient-to-r from-yellow-400 via-pink-400 to-purple-500 h-2 rounded-full"
                                                    style="width: {{ $porcentaje }}%">
                                                </div>
                                            </div>
                                            <span
                                                class="text-sm font-semibold text-neutral-700 dark:text-neutral-200">{{ $porcentaje }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.progreso', $alumno->id) }}"
                                            class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 hover:bg-blue-100 dark:bg-blue-900/40 dark:text-blue-200 dark:hover:bg-blue-900/70 transition-colors">
                                            Ver Detalle
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

            {{-- Tab de Preguntas --}}
            <div id="content-preguntas" class="tab-content hidden">
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach ($preguntas as $pregunta)
                        <div
                            class="relative bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-sm p-5 transition-all {{ !$pregunta->activa ? 'opacity-60' : '' }}">
                            {{-- Toggle Switch --}}
                            <div class="absolute top-4 right-4">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" {{ $pregunta->activa ? 'checked' : '' }}
                                        onchange="togglePregunta({{ $pregunta->id }}, this)">
                                    <div
                                        class="w-11 h-6 bg-neutral-200 dark:bg-neutral-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-pink-300/60 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gradient-to-r from-yellow-400 via-pink-400 to-purple-500">
                                    </div>
                                </label>
                            </div>

                            <h3 class="text-base font-bold text-neutral-900 dark:text-neutral-50 mb-2 pr-16">
                                {{ $pregunta->numero }}. {{ $pregunta->titulo }}
                            </h3>

                            <div class="flex flex-wrap gap-2 mb-3">
                                <span
                                    class="px-2 py-1 bg-blue-50 text-blue-700 dark:bg-blue-900/40 dark:text-blue-200 rounded-full text-[11px] font-semibold">
                                    Nivel {{ $pregunta->nivel }}
                                </span>
                                <span
                                    class="px-2 py-1 rounded-full text-[11px] font-semibold
                                        {{ $pregunta->dificultad === 'Baja' ? 'bg-green-50 text-green-700 dark:bg-green-900/40 dark:text-green-200' : '' }}
                                        {{ $pregunta->dificultad === 'Media' ? 'bg-yellow-50 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-200' : '' }}
                                        {{ $pregunta->dificultad === 'Alta' ? 'bg-red-50 text-red-700 dark:bg-red-900/40 dark:text-red-200' : '' }}">
                                    {{ $pregunta->dificultad }}
                                </span>
                            </div>

                            <p class="text-sm text-neutral-600 dark:text-neutral-300 line-clamp-2 mb-4">
                                {{ $pregunta->descripcion }}
                            </p>

                            <div class="flex items-center justify-between text-xs md:text-sm">
                                <span class="text-neutral-500 dark:text-neutral-400">
                                    {{ $pregunta->pais_origen }}
                                </span>
                                <span
                                    class="font-semibold {{ $pregunta->activa ? 'text-green-600 dark:text-green-300' : 'text-red-600 dark:text-red-300' }}">
                                    {{ $pregunta->activa ? 'Activa' : 'Desactivada' }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        function mostrarTab(tab) {
            // Ocultar todos
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-button').forEach(el => {
                el.classList.remove('border-pink-500', 'text-pink-600');
                el.classList.add('border-transparent', 'text-neutral-500', 'dark:text-neutral-400');
            });

            // Mostrar el seleccionado
            document.getElementById('content-' + tab).classList.remove('hidden');
            const tabButton = document.getElementById('tab-' + tab);
            tabButton.classList.remove('border-transparent', 'text-neutral-500', 'dark:text-neutral-400');
            tabButton.classList.add('border-pink-500', 'text-pink-600');
        }

        function togglePregunta(id, checkbox) {
            fetch(`/admin/preguntas/${id}/toggle`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content || '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const card = checkbox.closest('.bg-white, .dark\\:bg-neutral-900') || checkbox.closest('div');
                        const estadoEl = card.querySelector('.font-semibold:last-child');

                        if (data.activa) {
                            card.classList.remove('opacity-60');
                            estadoEl.textContent = 'Activa';
                            estadoEl.classList.remove('text-red-600', 'dark:text-red-300');
                            estadoEl.classList.add('text-green-600', 'dark:text-green-300');
                        } else {
                            card.classList.add('opacity-60');
                            estadoEl.textContent = 'Desactivada';
                            estadoEl.classList.remove('text-green-600', 'dark:text-green-300');
                            estadoEl.classList.add('text-red-600', 'dark:text-red-300');
                        }
                    }
                });
        }
    </script>
</x-layouts.app>