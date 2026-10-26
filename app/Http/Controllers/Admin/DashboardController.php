<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pregunta;
use App\Models\ProgresoUsuario;
use App\Models\OportunidadAdicional;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $alumnos = User::where('role', 'alumno')
            ->with(['progresos.pregunta'])
            ->get();
        
        $preguntas = Pregunta::orderBy('numero')->get();
        
        return view('admin.dashboard', compact('alumnos', 'preguntas'));
    }

    public function togglePregunta($id)
    {
        $id = (int) $id;
        $pregunta = Pregunta::findOrFail($id);
        $pregunta->activa = !$pregunta->activa;
        $pregunta->save();

        return response()->json([
            'success' => true,
            'activa' => $pregunta->activa,
            'mensaje' => $pregunta->activa ? 'Pregunta activada' : 'Pregunta desactivada'
        ]);
    }

    public function verProgreso($userId)
    {
        $userId = (int) $userId;
        $alumno = User::with(['progresos.pregunta', 'oportunidadesAdicionales'])->findOrFail($userId);

        if (! $alumno->isAlumno()) {
            abort(404, 'No se encontró el progreso del alumno.');
        }

        $preguntas = Pregunta::orderBy('numero')->get();
        
        // Crear array de progreso
        $progreso = [];
        foreach ($preguntas as $pregunta) {
            $progresoItem = $alumno->progresos->where('pregunta_id', $pregunta->id)->first();
            $oportunidad = $alumno->oportunidadesAdicionales->where('pregunta_id', $pregunta->id)->first();
            
            $progreso[$pregunta->id] = [
                'pregunta' => $pregunta,
                'progreso' => $progresoItem,
                'oportunidad' => $oportunidad,
            ];
        }
        
        return view('admin.progreso-alumno', compact('alumno', 'progreso'));
    }
    
    public function otorgarOportunidad(Request $request, $userId, $preguntaId)
    {
        $userId = (int) $userId;
        $preguntaId = (int) $preguntaId;
        
        $alumno = User::findOrFail($userId);
        $pregunta = Pregunta::findOrFail($preguntaId);
        
        if (! $alumno->isAlumno()) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Solo se pueden otorgar oportunidades a alumnos.'
            ], 400);
        }
        
        // Verificar que el alumno ya haya respondido la pregunta
        $progreso = ProgresoUsuario::where('user_id', $userId)
            ->where('pregunta_id', $preguntaId)
            ->first();
            
        if (!$progreso) {
            return response()->json([
                'error' => true,
                'mensaje' => 'El alumno aún no ha respondido esta pregunta.'
            ], 400);
        }
        
        // Verificar si ya tiene una oportunidad activa
        $oportunidadExistente = OportunidadAdicional::where('user_id', $userId)
            ->where('pregunta_id', $preguntaId)
            ->first();
            
        if ($oportunidadExistente) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Este alumno ya tiene una oportunidad adicional para esta pregunta.',
                'oportunidad' => [
                    'consumida' => $oportunidadExistente->consumida,
                    'otorgada_at' => $oportunidadExistente->otorgada_at->format('d/m/Y H:i')
                ]
            ], 400);
        }
        
        // Crear la oportunidad adicional
        $oportunidad = OportunidadAdicional::create([
            'user_id' => $userId,
            'pregunta_id' => $preguntaId,
            'otorgada_por' => auth()->id(),
            'otorgada_at' => now(),
            'consumida' => false,
        ]);
        
        return response()->json([
            'success' => true,
            'mensaje' => 'Oportunidad adicional otorgada exitosamente.',
            'oportunidad' => [
                'id' => $oportunidad->id,
                'otorgada_at' => $oportunidad->otorgada_at->format('d/m/Y H:i'),
                'consumida' => false
            ]
        ]);
    }
    
}