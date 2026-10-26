<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    use HasFactory;
    protected $fillable = [
        'numero', 'titulo', 'descripcion', 'imagen_descripcion',
        'pregunta', 'imagen_pregunta', 'imagen_respuesta',
        'tipo_interaccion', 'configuracion', 'respuesta_correcta', 
        'explicacion', 'nivel', 'dificultad', 'pais_origen', 'codigo_tarea',
        'activa' // Agregar
    ];

    protected $casts = [
        'configuracion' => 'array',
        'respuesta_correcta' => 'array',
        'activa' => 'boolean', // Agregar
    ];

    // Scope para preguntas activas
    public function scopeActivas($query)
    {
        return $query->where('activa', true);
    }

    public function progresos()
    {
        return $this->hasMany(ProgresoUsuario::class);
    }
}