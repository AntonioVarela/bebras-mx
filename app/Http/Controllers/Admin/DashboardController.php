<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pregunta;
use App\Models\ProgresoUsuario;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Optimización: solo cargar relaciones necesarias y seleccionar campos específicos
        $alumnos = User::where('role', 'alumno')
            ->select('id', 'name', 'email', 'created_at')
            ->with(['progresos' => function($query) {
                $query->select('id', 'user_id', 'pregunta_id', 'es_correcta', 'completada_at');
            }])
            ->get();
        
        $preguntas = Pregunta::select('id', 'numero', 'titulo', 'activa')
            ->orderBy('numero')
            ->get();
        
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
        
        // Optimización: cargar solo campos necesarios
        $alumno = User::select('id', 'name', 'email', 'role', 'created_at')
            ->with(['progresos' => function($query) {
                $query->select('id', 'user_id', 'pregunta_id', 'respuesta_usuario', 'es_correcta', 'completada_at');
            }])
            ->findOrFail($userId);

        if (! $alumno->isAlumno()) {
            abort(404, 'No se encontró el progreso del alumno.');
        }

        $preguntas = Pregunta::orderBy('numero')->get();
        
        // Optimización: crear un mapa de progreso indexado por pregunta_id para acceso O(1)
        $mapaProgreso = [];
        foreach ($alumno->progresos as $progresoItem) {
            $mapaProgreso[$progresoItem->pregunta_id] = $progresoItem;
        }
        
        // Crear array de progreso
        $progreso = [];
        foreach ($preguntas as $pregunta) {
            $progreso[$pregunta->id] = [
                'pregunta' => $pregunta,
                'progreso' => $mapaProgreso[$pregunta->id] ?? null,
            ];
        }
        
        return view('admin.progreso-alumno', compact('alumno', 'progreso'));
    }
    
}