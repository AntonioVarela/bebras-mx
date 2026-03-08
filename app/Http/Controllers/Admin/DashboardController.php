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
        $alumno = User::with(['progresos.pregunta'])->findOrFail($userId);

        if (! $alumno->isAlumno()) {
            abort(404, 'No se encontró el progreso del alumno.');
        }

        $preguntas = Pregunta::orderBy('numero')->get();
        
        // Crear array de progreso
        $progreso = [];
        foreach ($preguntas as $pregunta) {
            $progresoItem = $alumno->progresos->where('pregunta_id', $pregunta->id)->first();
            $progreso[$pregunta->id] = [
                'pregunta' => $pregunta,
                'progreso' => $progresoItem,
            ];
        }
        
        return view('admin.progreso-alumno', compact('alumno', 'progreso'));
    }
    
}