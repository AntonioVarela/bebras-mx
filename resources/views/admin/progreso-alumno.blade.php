<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progreso de {{ $alumno->name }} - Nestbytes Olimpo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 pb-20">
    
    {{-- Header --}}
    <div class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800 text-sm mb-2 inline-block">
                        ← Volver al Dashboard
                    </a>
                    <h1 class="text-2xl font-bold text-gray-800">Progreso de {{ $alumno->name }}</h1>
                    <p class="text-sm text-gray-600">{{ $alumno->email }}</p>
                </div>
                <div class="text-right">
                    @php
                        $total = count($progreso);
                        $respondidas = collect($progreso)->filter(fn($p) => $p['progreso'] !== null)->count();
                        $correctas = collect($progreso)->filter(fn($p) => $p['progreso'] && $p['progreso']->es_correcta)->count();
                        $porcentaje = $respondidas > 0 ? round(($correctas / $respondidas) * 100) : 0;
                    @endphp
                    <div class="text-3xl font-bold text-blue-600">{{ $respondidas }}/{{ $total }}</div>
                    <div class="text-sm text-gray-600">Preguntas respondidas</div>
                    <div class="text-lg font-semibold text-gray-700 mt-2">{{ $porcentaje }}% de éxito</div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8">
        
        {{-- Resumen --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-sm text-gray-600 mb-1">Total Preguntas</div>
                <div class="text-3xl font-bold text-gray-800">{{ $total }}</div>
            </div>
            <div class="bg-green-50 rounded-lg shadow p-6">
                <div class="text-sm text-green-600 mb-1">Correctas</div>
                <div class="text-3xl font-bold text-green-700">{{ $correctas }}</div>
            </div>
            <div class="bg-red-50 rounded-lg shadow p-6">
                <div class="text-sm text-red-600 mb-1">Incorrectas</div>
                <div class="text-3xl font-bold text-red-700">{{ $respondidas - $correctas }}</div>
            </div>
            <div class="bg-gray-50 rounded-lg shadow p-6">
                <div class="text-sm text-gray-600 mb-1">Pendientes</div>
                <div class="text-3xl font-bold text-gray-700">{{ $total - $respondidas }}</div>
            </div>
        </div>

        {{-- Tabla de preguntas --}}
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                #
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pregunta
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nivel
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dificultad
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fecha Respuesta
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($progreso as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $item['pregunta']->numero }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $item['pregunta']->titulo }}</div>
                                    <div class="text-sm text-gray-500">{{ $item['pregunta']->pais_origen }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold">
                                        {{ $item['pregunta']->nivel }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold
                                        {{ $item['pregunta']->dificultad === 'Baja' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $item['pregunta']->dificultad === 'Media' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $item['pregunta']->dificultad === 'Alta' ? 'bg-red-100 text-red-700' : '' }}">
                                        {{ $item['pregunta']->dificultad }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($item['progreso'])
                                        @if($item['progreso']->es_correcta)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                                Correcta
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                </svg>
                                                Incorrecta
                                            </span>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-600">
                                            Sin responder
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                    @if($item['progreso'] && $item['progreso']->completada_at)
                                        {{ $item['progreso']->completada_at->format('d/m/Y H:i') }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    @include('layouts.footer')
</body>
</html>