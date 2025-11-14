<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Nestbytes Olimpo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 pb-20">
    
    {{-- Header --}}
    <div class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Panel de Administración</h1>
                <p class="text-sm text-gray-600">Nestbytes Olimpo - Primavera 2025</p>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('preguntas.index') }}" class="text-blue-600 hover:text-blue-800">
                    Ver Preguntas
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8">
        
        {{-- Tabs --}}
        <div class="mb-6">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button onclick="mostrarTab('alumnos')" id="tab-alumnos" 
                            class="tab-button border-b-2 border-blue-500 py-4 px-1 text-sm font-medium text-blue-600">
                        Alumnos ({{ $alumnos->count() }})
                    </button>
                    <button onclick="mostrarTab('preguntas')" id="tab-preguntas"
                            class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Gestionar Preguntas ({{ $preguntas->count() }})
                    </button>
                </nav>
            </div>
        </div>

        {{-- Tab de Alumnos --}}
        <div id="content-alumnos" class="tab-content">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Alumno
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Respondidas
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Correctas
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Incorrectas
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    % Éxito
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($alumnos as $alumno)
                                @php
                                    $total = $alumno->progresos->count();
                                    $correctas = $alumno->progresos->where('es_correcta', true)->count();
                                    $incorrectas = $alumno->progresos->where('es_correcta', false)->count();
                                    $porcentaje = $total > 0 ? round(($correctas / $total) * 100) : 0;
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-blue-500 rounded-full flex items-center justify-center">
                                                <span class="text-white font-semibold">{{ substr($alumno->name, 0, 1) }}</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $alumno->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $alumno->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="text-sm font-semibold text-gray-900">{{ $total }}/27</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ $correctas }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            {{ $incorrectas }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center">
                                            <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $porcentaje }}%"></div>
                                            </div>
                                            <span class="text-sm font-medium text-gray-700">{{ $porcentaje }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.progreso', $alumno->id) }}" 
                                           class="text-blue-600 hover:text-blue-900">
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
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($preguntas as $pregunta)
                    <div class="bg-white rounded-lg shadow-md p-6 relative {{ !$pregunta->activa ? 'opacity-60' : '' }}">
                        {{-- Toggle Switch --}}
                        <div class="absolute top-4 right-4">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       class="sr-only peer" 
                                       {{ $pregunta->activa ? 'checked' : '' }}
                                       onchange="togglePregunta({{ $pregunta->id }}, this)">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <h3 class="text-lg font-bold text-gray-800 mb-2 pr-16">
                            {{ $pregunta->numero }}. {{ $pregunta->titulo }}
                        </h3>
                        
                        <div class="flex gap-2 mb-3">
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold">
                                Nivel {{ $pregunta->nivel }}
                            </span>
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                {{ $pregunta->dificultad === 'Baja' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $pregunta->dificultad === 'Media' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $pregunta->dificultad === 'Alta' ? 'bg-red-100 text-red-700' : '' }}">
                                {{ $pregunta->dificultad }}
                            </span>
                        </div>

                        <p class="text-sm text-gray-600 line-clamp-2 mb-4">{{ $pregunta->descripcion }}</p>

                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">{{ $pregunta->pais_origen }}</span>
                            <span class="font-semibold {{ $pregunta->activa ? 'text-green-600' : 'text-red-600' }}">
                                {{ $pregunta->activa ? 'Activa' : 'Desactivada' }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <script>
        function mostrarTab(tab) {
            // Ocultar todos
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-button').forEach(el => {
                el.classList.remove('border-blue-500', 'text-blue-600');
                el.classList.add('border-transparent', 'text-gray-500');
            });

            // Mostrar el seleccionado
            document.getElementById('content-' + tab).classList.remove('hidden');
            document.getElementById('tab-' + tab).classList.remove('border-transparent', 'text-gray-500');
            document.getElementById('tab-' + tab).classList.add('border-blue-500', 'text-blue-600');
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
                    const card = checkbox.closest('.bg-white');
                    if (data.activa) {
                        card.classList.remove('opacity-60');
                        card.querySelector('.font-semibold:last-child').textContent = 'Activa';
                        card.querySelector('.font-semibold:last-child').classList.remove('text-red-600');
                        card.querySelector('.font-semibold:last-child').classList.add('text-green-600');
                    } else {
                        card.classList.add('opacity-60');
                        card.querySelector('.font-semibold:last-child').textContent = 'Desactivada';
                        card.querySelector('.font-semibold:last-child').classList.remove('text-green-600');
                        card.querySelector('.font-semibold:last-child').classList.add('text-red-600');
                    }
                }
            });
        }
    </script>
    @include('layouts.footer')
</body>
</html>