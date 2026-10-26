<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pregunta>
 */
class PreguntaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'numero' => fake()->unique()->numberBetween(1, 100),
            'titulo' => fake()->sentence(),
            'descripcion' => fake()->paragraph(),
            'imagen_descripcion' => null,
            'pregunta' => fake()->sentence() . '?',
            'imagen_pregunta' => null,
            'tipo_interaccion' => 'seleccion_simple',
            'configuracion' => [],
            'respuesta_correcta' => ['A'],
            'explicacion' => fake()->paragraph(),
            'imagen_respuesta' => null,
            'nivel' => fake()->randomElement(['I', 'II', 'III', 'IV', 'V', 'VI']),
            'dificultad' => fake()->randomElement(['Baja', 'Media', 'Alta']),
            'pais_origen' => fake()->country(),
            'codigo_tarea' => fake()->bothify('????-??-##'),
            'activa' => true,
        ];
    }
}
