<?php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use App\Models\ProgresoUsuario;
use Illuminate\Http\Request;

class PreguntaController extends Controller
{
    public function index()
    {
        // Optimización: solo cargar campos necesarios para el listado
        if (auth()->check() && auth()->user()->isAlumno()) {
            $preguntas = Pregunta::activas()
                ->select('id', 'numero', 'titulo', 'nivel', 'dificultad')
                ->orderBy('numero')
                ->get();
        } else {
            // Admin ve todas
            $preguntas = Pregunta::select('id', 'numero', 'titulo', 'nivel', 'dificultad', 'activa')
                ->orderBy('numero')
                ->get();
        }
        
        if (auth()->check()) {
            // Optimización: usar índice compuesto user_id + pregunta_id
            $progreso = ProgresoUsuario::where('user_id', auth()->id())
                ->pluck('es_correcta', 'pregunta_id');
        } else {
            $progreso = collect();
        }
        
        return view('preguntas.index', compact('preguntas', 'progreso'));
    }

    public function show($id)
    {
        $id = (int) $id;
        $pregunta = Pregunta::findOrFail($id);

        // Verificar si el alumno puede ver esta pregunta
        if (auth()->check() && auth()->user()->isAlumno() && !$pregunta->activa) {
            abort(403, 'Esta pregunta no está disponible en este momento.');
        }

        // Verificar si ya respondió
        $progresoUsuario = null;
        $yaRespondio = false;

        if (auth()->check()) {
            $progresoUsuario = ProgresoUsuario::where('user_id', auth()->id())
                ->where('pregunta_id', $id)
                ->first();
            
            $yaRespondio = $progresoUsuario !== null;
        }
        
        return view('preguntas.show', compact('pregunta', 'progresoUsuario', 'yaRespondio'));
    }

    public function verificar(Request $request, $id)
    {
        $id = (int) $id;
        
        if (!auth()->check()) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Debes estar autenticado para verificar respuestas.'
            ], 401);
        }
        
        // Verificar si ya respondió (una sola consulta)
        $progresoExistente = ProgresoUsuario::where('user_id', auth()->id())
            ->where('pregunta_id', $id)
            ->exists();
        
        if ($progresoExistente && auth()->user()->isAlumno()) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Ya respondiste esta pregunta anteriormente.'
            ], 403);
        }

        $request->validate([
            'respuesta' => ['present'],
        ], [
            'respuesta.present' => 'Debes enviar una respuesta.',
        ]);

        // Cargar pregunta solo después de validaciones iniciales
        $pregunta = Pregunta::findOrFail($id);
        $respuestaUsuario = $request->input('respuesta');
        $respuestaCorrecta = $pregunta->respuesta_correcta;
        $configuracion = $pregunta->configuracion ?? [];
        
        $esCorrecta = $this->validarRespuesta(
            $pregunta->tipo_interaccion, 
            $respuestaUsuario, 
            $respuestaCorrecta,
            $configuracion
        );
        
        // Guardar progreso
        ProgresoUsuario::create([
            'user_id' => auth()->id(),
            'pregunta_id' => $id,
            'respuesta_usuario' => $respuestaUsuario,
            'es_correcta' => $esCorrecta,
            'completada_at' => now(),
        ]);
        
        return response()->json([
            'correcta' => $esCorrecta,
            'explicacion' => $pregunta->explicacion,
            'respuesta_correcta_visual' => $this->formatearRespuestaCorrecta($pregunta->tipo_interaccion, $respuestaCorrecta),
            'imagen_respuesta' => $pregunta->imagen_respuesta,
        ]);
    }

    /**
     * Valida la respuesta del usuario contra la respuesta correcta.
     * Convención: en las vistas, cada inciso usa el campo 'id' de la opción (ej. 'A', 'B', '1', 'manzana').
     * El front envía ese mismo 'id' (seleccion_simple: [id], seleccion_multiple: [id1, id2], etc.).
     * respuesta_correcta en BD debe usar exactamente los mismos ids que configuracion.opciones[].id.
     */
    private function validarRespuesta($tipo, $usuario, $correcta, $configuracion = [])
    {
        if (!$usuario || empty($tipo)) {
            return false;
        }

        switch ($tipo) {
            case 'seleccion_simple':
                return $this->validarSeleccionSimple($usuario, $correcta);
            
            case 'seleccion_multiple':
                return $this->validarSeleccionMultiple($usuario, $correcta);
            
            case 'ordenar':
                return $this->validarOrdenar($usuario, $correcta);
            
            case 'grid_seleccion':
                return $this->validarGrid($usuario, $correcta);
            
            case 'emparejar':
                return $this->validarEmparejar($usuario, $correcta);
            
            case 'rellenar':
                return $this->validarRellenar($usuario, $correcta, $configuracion);
            
            case 'texto_libre':
                return $this->validarTextoLibre($usuario, $correcta);
            
            case 'colocar_piezas':
                return $this->validarColocarPiezas($usuario, $correcta);
            
            case 'rompecabezas_hexagonos':
                return $this->validarRompecabezasHexagonos($usuario, $correcta);
            
            case 'colorear_hexagonos':
                return $this->validarColorearHexagonos($usuario, $correcta);
            
            case 'tejer_alfombra':
                return $this->validarTejerAlfombra($usuario, $correcta);

            case 'completar':
                return $this->validarCompletar($usuario, $correcta, $configuracion);

            default:
                return false;
        }
    }

    private function validarSeleccionSimple($usuario, $correcta)
    {
        // $correcta puede ser ['B'] o [['B']]
        $correctaFlat = is_array($correcta[0] ?? null) ? $correcta[0] : $correcta;
        return isset($usuario[0]) && in_array($usuario[0], $correctaFlat);
    }

    private function validarSeleccionMultiple($usuario, $correcta)
    {
        // Verificar si es formato de computadoras (pregunta 23)
        if (isset($correcta[0]) && is_array($correcta[0]) && isset($correcta[0]['computadora'])) {
            // Formato: [{computadora: 1, estado: 'virus_rojo'}, ...]
            if (!is_array($usuario) || count($usuario) !== count($correcta)) {
                return false;
            }
            
            // Optimización: usar un mapa hash para O(n) en lugar de O(n²)
            $mapaUsuario = [];
            foreach ($usuario as $respuestaUsuario) {
                if (isset($respuestaUsuario['computadora']) && isset($respuestaUsuario['estado'])) {
                    $comp = (int)$respuestaUsuario['computadora'];
                    $estado = (string)$respuestaUsuario['estado'];
                    $mapaUsuario[$comp] = $estado;
                }
            }
            
            // Verificar que cada computadora tenga el estado correcto
            foreach ($correcta as $respuestaCorrecta) {
                if (!isset($respuestaCorrecta['computadora']) || !isset($respuestaCorrecta['estado'])) {
                    return false;
                }
                $comp = (int)$respuestaCorrecta['computadora'];
                $estadoEsperado = (string)$respuestaCorrecta['estado'];
                
                if (!isset($mapaUsuario[$comp]) || $mapaUsuario[$comp] !== $estadoEsperado) {
                    return false;
                }
            }
            return true;
        }
        
        // Formato estándar: $correcta puede ser [['1', '2', '3']] o ['1', '2', '3']
        $correctaFlat = is_array($correcta[0] ?? null) && is_string($correcta[0]) 
            ? $correcta 
            : ($correcta[0] ?? []);
        
        if (count($usuario) !== count($correctaFlat)) {
            return false;
        }
        
        sort($usuario);
        sort($correctaFlat);
        
        return $usuario === $correctaFlat;
    }

    private function validarOrdenar($usuario, $correcta)
    {
        // Verificar si hay múltiples respuestas correctas posibles
        if (isset($correcta[0]) && is_array($correcta[0])) {
            // Múltiples soluciones posibles
            foreach ($correcta as $solucion) {
                if ($usuario === $solucion) {
                    return true;
                }
            }
            return false;
        }
        
        // Una sola solución
        return $usuario === $correcta;
    }

    private function validarGrid($usuario, $correcta)
    {
        if (!is_array($usuario) || !is_array($correcta)) {
            return false;
        }

        if (count($usuario) !== count($correcta)) {
            return false;
        }
        
        // Optimización: usar un conjunto hash en lugar de ordenar arrays
        $usuarioSet = [];
        foreach ($usuario as $r) {
            if (isset($r['fila']) && isset($r['columna'])) {
                $usuarioSet["{$r['fila']}-{$r['columna']}"] = true;
            }
        }
        
        // Verificar que todas las celdas correctas estén presentes
        foreach ($correcta as $r) {
            if (!isset($r['fila']) || !isset($r['columna'])) {
                return false;
            }
            $key = "{$r['fila']}-{$r['columna']}";
            if (!isset($usuarioSet[$key])) {
                return false;
            }
        }
        
        return true;
    }

    private function validarEmparejar($usuario, $correcta)
    {
        if (!is_array($usuario) || !is_array($correcta)) {
            return false;
        }

        if (count($usuario) !== count($correcta)) {
            return false;
        }
        
        // Optimización: usar un mapa hash objeto->destino
        $mapaUsuario = [];
        foreach ($usuario as $respuesta) {
            if (isset($respuesta['objeto']) && isset($respuesta['destino'])) {
                $mapaUsuario[$respuesta['objeto']] = $respuesta['destino'];
            }
        }
        
        // Verificar cada emparejamiento correcto
        foreach ($correcta as $emparejamiento) {
            if (!isset($emparejamiento['objeto']) || !isset($emparejamiento['destino'])) {
                return false;
            }
            $objeto = $emparejamiento['objeto'];
            $destinoEsperado = $emparejamiento['destino'];
            
            if (!isset($mapaUsuario[$objeto]) || $mapaUsuario[$objeto] !== $destinoEsperado) {
                return false;
            }
        }
        
        return true;
    }

    private function validarRellenar($usuario, $correcta, $configuracion = [])
    {
        if (!is_array($usuario) || !is_array($correcta)) {
            return false;
        }

        if (count($usuario) !== count($correcta)) {
            return false;
        }
        
        // Si hay tipo_validacion flexible, validar contra reglas lógicas
        if (isset($configuracion['tipo_validacion']) && $configuracion['tipo_validacion'] === 'flexible') {
            return $this->validarRellenarFlexible($usuario, $configuracion);
        }
        
        // Validación estándar: comparar contra respuesta exacta
        // Si hay múltiples soluciones (array de arrays), verificar contra todas
        if (isset($correcta[0]) && is_array($correcta[0]) && isset($correcta[0][0]) && is_array($correcta[0][0])) {
            // Múltiples soluciones posibles: [[solucion1], [solucion2], ...]
            foreach ($correcta as $solucion) {
                if ($this->compararRellenar($usuario, $solucion)) {
                    return true;
                }
            }
            return false;
        }
        
        // Una sola solución
        return $this->compararRellenar($usuario, $correcta);
    }
    
    private function compararRellenar($usuario, $correcta)
    {
        // Optimización: usar un mapa hash area->color
        $mapaUsuario = [];
        foreach ($usuario as $respuesta) {
            if (isset($respuesta['area']) && isset($respuesta['color'])) {
                $mapaUsuario[$respuesta['area']] = $respuesta['color'];
            }
        }
        
        // Verificar que todas las áreas tengan el color correcto
        foreach ($correcta as $colorCorrecto) {
            if (!isset($colorCorrecto['area']) || !isset($colorCorrecto['color'])) {
                return false;
            }
            $area = $colorCorrecto['area'];
            $colorEsperado = $colorCorrecto['color'];
            
            if (!isset($mapaUsuario[$area]) || $mapaUsuario[$area] !== $colorEsperado) {
                return false;
            }
        }
        
        return true;
    }
    
    private function validarRellenarFlexible($usuario, $configuracion)
    {
        // Validar que áreas adyacentes no tengan el mismo color
        // Esto requiere definir qué áreas son adyacentes en la configuración
        
        // Por ahora, validar que:
        // 1. Todas las áreas estén coloreadas
        // 2. No haya áreas duplicadas
        // 3. Los colores sean válidos
        
        $areas = $configuracion['areas'] ?? [];
        $coloresValidos = $configuracion['colores_disponibles'] ?? [];
        
        // Mapeo de colores en español a inglés
        $colorMap = [
            'verde' => 'green',
            'amarillo' => 'yellow',
            'azul' => 'blue',
            'green' => 'green',
            'yellow' => 'yellow',
            'blue' => 'blue'
        ];
        
        // Normalizar colores válidos
        $coloresValidosNormalizados = [];
        foreach ($coloresValidos as $color) {
            $normalizado = $colorMap[$color] ?? $color;
            $coloresValidosNormalizados[] = $normalizado;
            // También agregar versión en español
            foreach ($colorMap as $esp => $eng) {
                if ($eng === $normalizado) {
                    $coloresValidosNormalizados[] = $esp;
                }
            }
        }
        
        // Verificar que todas las áreas estén coloreadas
        $areasColoreadas = [];
        foreach ($usuario as $respuesta) {
            if (!isset($respuesta['area']) || !isset($respuesta['color'])) {
                return false;
            }
            
            // Normalizar color de respuesta
            $colorRespuesta = $respuesta['color'];
            $colorNormalizado = $colorMap[$colorRespuesta] ?? $colorRespuesta;
            
            // Verificar que el color sea válido
            if (!in_array($colorRespuesta, $coloresValidosNormalizados) && 
                !in_array($colorNormalizado, $coloresValidosNormalizados)) {
                return false;
            }
            
            // Verificar que no haya áreas duplicadas
            if (isset($areasColoreadas[$respuesta['area']])) {
                return false;
            }
            
            $areasColoreadas[$respuesta['area']] = $colorNormalizado;
        }
        
        // Verificar que todas las áreas requeridas estén coloreadas
        foreach ($areas as $area) {
            if (!isset($areasColoreadas[$area['id']])) {
                return false;
            }
        }
        
        // Validar regla: áreas adyacentes no pueden tener el mismo color
        // Para la pregunta 14 (flor), las reglas son:
        // - Fondo toca todos los pétalos y el centro
        // - Cada pétalo toca el fondo y el centro
        // - El centro toca el fondo y todos los pétalos
        
        // Definir adyacencias para la pregunta 14
        $adyacencias = [
            'fondo' => ['petalo1', 'petalo2', 'petalo3', 'petalo4', 'petalo5', 'centro'],
            'petalo1' => ['fondo', 'centro'],
            'petalo2' => ['fondo', 'centro'],
            'petalo3' => ['fondo', 'centro'],
            'petalo4' => ['fondo', 'centro'],
            'petalo5' => ['fondo', 'centro'],
            'centro' => ['fondo', 'petalo1', 'petalo2', 'petalo3', 'petalo4', 'petalo5']
        ];
        
        // Si hay adyacencias definidas en la configuración, usarlas
        if (isset($configuracion['adyacencias'])) {
            $adyacencias = $configuracion['adyacencias'];
        }
        
        // Verificar que áreas adyacentes no tengan el mismo color
        foreach ($areasColoreadas as $areaId => $colorArea) {
            if (isset($adyacencias[$areaId])) {
                foreach ($adyacencias[$areaId] as $areaAdyacente) {
                    if (isset($areasColoreadas[$areaAdyacente])) {
                        // Normalizar ambos colores para comparar
                        $colorAdyacente = $areasColoreadas[$areaAdyacente];
                        $colorAreaNormalizado = $colorMap[$colorArea] ?? $colorArea;
                        $colorAdyacenteNormalizado = $colorMap[$colorAdyacente] ?? $colorAdyacente;
                        
                        // Si los colores normalizados son iguales, es incorrecto
                        if ($colorAreaNormalizado === $colorAdyacenteNormalizado) {
                            return false;
                        }
                    }
                }
            }
        }
        
        return true;
    }

    private function validarTextoLibre($usuario, $correcta)
    {
        // Validar que el usuario envió algo
        if (!isset($usuario[0]) || empty(trim($usuario[0]))) {
            return false;
        }

        $respuestaUsuario = strtolower(trim($usuario[0]));
        
        // Normalizar $correcta para que siempre sea un array plano de strings
        if (!is_array($correcta)) {
            $correcta = [$correcta];
        }
        
        // Si es array anidado [['4']], aplanar a ['4']
        if (isset($correcta[0]) && is_array($correcta[0])) {
            $correcta = $correcta[0];
        }
        
        // Comparar con cada respuesta válida
        foreach ($correcta as $opcionCorrecta) {
            $opcionCorrecta = strtolower(trim((string)$opcionCorrecta));
            
            if ($respuestaUsuario === $opcionCorrecta) {
                return true;
            }
        }
        
        return false;
    }

    private function validarColocarPiezas($usuario, $correcta)
    {
        if (!is_array($usuario) || !is_array($correcta)) {
            return false;
        }

        if (count($usuario) !== count($correcta)) {
            return false;
        }
        
        // Optimización: usar un mapa hash abeja->celda
        $mapaUsuario = [];
        foreach ($usuario as $colocacionUsuario) {
            if (isset($colocacionUsuario['abeja']) && isset($colocacionUsuario['celda'])) {
                $abeja = (string)$colocacionUsuario['abeja'];
                $celda = (int)$colocacionUsuario['celda'];
                $mapaUsuario[$abeja] = $celda;
            }
        }
        
        // Verificar que cada colocación sea correcta
        foreach ($correcta as $colocacionCorrecta) {
            if (!isset($colocacionCorrecta['abeja']) || !isset($colocacionCorrecta['celda'])) {
                return false;
            }
            $abejaCorrecta = (string)$colocacionCorrecta['abeja'];
            $celdaCorrecta = (int)$colocacionCorrecta['celda'];
            
            if (!isset($mapaUsuario[$abejaCorrecta]) || $mapaUsuario[$abejaCorrecta] !== $celdaCorrecta) {
                return false;
            }
        }
        
        return true;
    }

    private function validarRompecabezasHexagonos($usuario, $correcta)
    {
        if (!is_array($usuario) || !is_array($correcta)) {
            return false;
        }

        if (count($usuario) !== count($correcta)) {
            return false;
        }
        
        // Optimización: usar un mapa hash "fila-columna"->pieza
        $mapaUsuario = [];
        foreach ($usuario as $colocacionUsuario) {
            if (isset($colocacionUsuario['fila']) && isset($colocacionUsuario['columna']) && isset($colocacionUsuario['pieza'])) {
                $fila = (int)$colocacionUsuario['fila'];
                $columna = (int)$colocacionUsuario['columna'];
                $pieza = (string)$colocacionUsuario['pieza'];
                $key = "{$fila}-{$columna}";
                $mapaUsuario[$key] = $pieza;
            }
        }
        
        // Verificar que cada colocación sea correcta
        foreach ($correcta as $colocacionCorrecta) {
            if (!isset($colocacionCorrecta['fila']) || !isset($colocacionCorrecta['columna']) || !isset($colocacionCorrecta['pieza'])) {
                return false;
            }
            $filaCorrecta = (int)$colocacionCorrecta['fila'];
            $columnaCorrecta = (int)$colocacionCorrecta['columna'];
            $piezaCorrecta = (string)$colocacionCorrecta['pieza'];
            $key = "{$filaCorrecta}-{$columnaCorrecta}";
            
            if (!isset($mapaUsuario[$key]) || $mapaUsuario[$key] !== $piezaCorrecta) {
                return false;
            }
        }
        
        return true;
    }

    private function validarColorearHexagonos($usuario, $correcta)
    {
        if (!is_array($usuario) || !is_array($correcta)) {
            return false;
        }

        if (count($usuario) !== count($correcta)) {
            return false;
        }
        
        // Optimización: usar un mapa hash "fila-columna"->color
        $mapaUsuario = [];
        foreach ($usuario as $colocacionUsuario) {
            if (isset($colocacionUsuario['posicion']) && isset($colocacionUsuario['color'])) {
                $posUsuario = $colocacionUsuario['posicion'];
                if (is_array($posUsuario) && count($posUsuario) === 2) {
                    $fila = (int)$posUsuario[0];
                    $columna = (int)$posUsuario[1];
                    $color = (string)$colocacionUsuario['color'];
                    $key = "{$fila}-{$columna}";
                    $mapaUsuario[$key] = $color;
                }
            }
        }
        
        // Verificar que cada colocación sea correcta
        foreach ($correcta as $colocacionCorrecta) {
            if (!isset($colocacionCorrecta['posicion']) || !isset($colocacionCorrecta['color'])) {
                return false;
            }
            $posCorrecta = $colocacionCorrecta['posicion'];
            if (!is_array($posCorrecta) || count($posCorrecta) !== 2) {
                return false;
            }
            $filaCorrecta = (int)$posCorrecta[0];
            $columnaCorrecta = (int)$posCorrecta[1];
            $colorCorrecta = (string)$colocacionCorrecta['color'];
            $key = "{$filaCorrecta}-{$columnaCorrecta}";
            
            if (!isset($mapaUsuario[$key]) || $mapaUsuario[$key] !== $colorCorrecta) {
                return false;
            }
        }
        
        return true;
    }

    private function validarTejerAlfombra($usuario, $correcta)
    {
        if (!is_array($usuario) || !is_array($correcta)) {
            return false;
        }

        // Verificar que tengan el mismo número de filas
        if (count($usuario) !== count($correcta)) {
            return false;
        }

        // Comparar cada fila
        for ($i = 0; $i < count($usuario); $i++) {
            if (!is_array($usuario[$i]) || !is_array($correcta[$i])) {
                return false;
            }

            // Verificar que tengan el mismo número de columnas
            if (count($usuario[$i]) !== count($correcta[$i])) {
                return false;
            }

            // Comparar cada celda
            for ($j = 0; $j < count($usuario[$i]); $j++) {
                $usuarioValor = (string)($usuario[$i][$j] ?? '');
                $correctaValor = (string)($correcta[$i][$j] ?? '');
                
                if ($usuarioValor !== $correctaValor) {
                    return false;
                }
            }
        }

        return true;
    }

    private function validarCompletar($usuario, $correcta, $configuracion = [])
    {
        if (!$usuario || !$correcta) {
            return false;
        }

        // Respuesta como string (ej: 'XXXBNBXNXNB')
        if (is_string($correcta)) {
            $correcta = [$correcta];
        }
        if (isset($correcta[0]) && is_string($correcta[0]) && !is_array($correcta[0])) {
            $respuestaUsuario = is_array($usuario) ? ($usuario[0] ?? '') : (string)$usuario;
            foreach ((array)$correcta as $opcion) {
                if (trim(strtolower((string)$respuestaUsuario)) === trim(strtolower((string)$opcion))) {
                    return true;
                }
            }
            return false;
        }

        // Respuesta como array de ids (orden importa salvo que config indique comparar como conjunto)
        if (isset($correcta[0]) && is_string($correcta[0])) {
            $usuarioFlat = is_array($usuario) ? $usuario : [$usuario];
            if (count($usuarioFlat) !== count($correcta)) {
                return false;
            }
            if (!empty($configuracion['comparar_como_conjunto'])) {
                sort($usuarioFlat);
                $correctaSorted = $correcta;
                sort($correctaSorted);
                return $usuarioFlat === $correctaSorted;
            }
            return $usuarioFlat === $correcta;
        }

        // Respuesta como objeto/array asociativo (ej: {martes: 'manzana', miercoles: 'pera})
        if (is_array($correcta) && isset($correcta[0]) && is_array($correcta[0])) {
            foreach ($correcta as $solucion) {
                if ($this->compararCompletarObjeto($usuario, $solucion)) {
                    return true;
                }
            }
            return false;
        }

        if (is_array($correcta) && !isset($correcta[0])) {
            return $this->compararCompletarObjeto($usuario, $correcta);
        }

        return false;
    }

    private function compararCompletarObjeto($usuario, $correcta)
    {
        if (!is_array($usuario) || !is_array($correcta)) {
            return false;
        }
        foreach ($correcta as $key => $valorCorrecto) {
            $valorUsuario = $usuario[$key] ?? null;
            if (is_array($valorCorrecto)) {
                if (!is_array($valorUsuario) || count($valorUsuario) !== count($valorCorrecto)) {
                    return false;
                }
                sort($valorUsuario);
                sort($valorCorrecto);
                if ($valorUsuario !== $valorCorrecto) {
                    return false;
                }
            } elseif (($usuario[$key] ?? null) != $valorCorrecto) {
                return false;
            }
        }
        return true;
    }

    private function formatearRespuestaCorrecta($tipo, $correcta)
    {
        switch ($tipo) {
            case 'seleccion_simple':
                $opciones = is_array($correcta[0] ?? null) ? $correcta[0] : $correcta;
                return 'Opción correcta: ' . implode(', ', $opciones);
            
            case 'seleccion_multiple':
                $opciones = is_array($correcta[0] ?? null) && is_string($correcta[0]) 
                    ? $correcta 
                    : ($correcta[0] ?? []);
                return 'Opciones correctas: ' . implode(', ', $opciones);
            
            case 'ordenar':
                if (isset($correcta[0]) && is_array($correcta[0])) {
                    return 'Una respuesta posible: ' . implode(' → ', $correcta[0]);
                }
                return 'Orden correcto: ' . implode(' → ', $correcta);
            
            case 'grid_seleccion':
                $texto = 'Celdas correctas: ';
                foreach ($correcta as $celda) {
                    $texto .= "Fila " . ($celda['fila'] + 1) . ", Columna " . ($celda['columna'] + 1) . "; ";
                }
                return rtrim($texto, '; ');
            
            case 'emparejar':
                $texto = 'Emparejamientos correctos: ';
                foreach ($correcta as $par) {
                    $texto .= "{$par['objeto']} → {$par['destino']}, ";
                }
                return rtrim($texto, ', ');
            
            case 'texto_libre':
                $opciones = is_array($correcta[0] ?? null) ? $correcta : [$correcta[0] ?? 'N/A'];
                return 'Respuesta correcta: ' . implode(' o ', $opciones);
            
            case 'rellenar':
                return 'Revisa la explicación para ver la solución completa.';
            
            case 'colocar_piezas':
                $texto = 'Colocación correcta: ';
                foreach ($correcta as $colocacion) {
                    $texto .= "Abeja {$colocacion['abeja']} en celda {$colocacion['celda']}, ";
                }
                return rtrim($texto, ', ');
            
            case 'rompecabezas_hexagonos':
                $texto = 'Colocación correcta: ';
                foreach ($correcta as $colocacion) {
                    $texto .= "Pieza {$colocacion['pieza']} en fila {$colocacion['fila']}, columna {$colocacion['columna']}, ";
                }
                return rtrim($texto, ', ');
            
            case 'colorear_hexagonos':
                $texto = 'Colocación correcta: ';
                foreach ($correcta as $colocacion) {
                    $pos = $colocacion['posicion'];
                    $texto .= "Fila {$pos[0]}, columna {$pos[1]}: {$colocacion['color']}, ";
                }
                return rtrim($texto, ', ');
            
            case 'tejer_alfombra':
                return 'Revisa la explicación para ver la solución completa del grid.';

            case 'completar':
                if (is_array($correcta) && isset($correcta[0]) && is_string($correcta[0]) && array_is_list($correcta)) {
                    return 'Opciones correctas: ' . implode(', ', $correcta);
                }
                return 'Revisa la explicación para ver la solución completa.';

            default:
                return '';
        }
    }
}