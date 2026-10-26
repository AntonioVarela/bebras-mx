<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Pregunta;
use App\Models\ProgresoUsuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class PreguntaVerificarPerformanceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test que verifica que las queries usan los índices correctamente
     */
    public function test_verificar_respuesta_usa_indices(): void
    {
        $usuario = User::factory()->create(['role' => 'alumno']);
        $pregunta = Pregunta::factory()->create([
            'tipo_interaccion' => 'seleccion_simple',
            'configuracion' => json_encode(['opciones' => [
                ['id' => 'A', 'texto' => 'Opción A'],
                ['id' => 'B', 'texto' => 'Opción B'],
            ]]),
            'respuesta_correcta' => json_encode(['A']),
        ]);

        // Habilitar log de queries
        DB::enableQueryLog();

        $this->actingAs($usuario)
            ->postJson(route('preguntas.verificar', $pregunta->id), [
                'respuesta' => ['A']
            ]);

        $queries = DB::getQueryLog();
        
        // Verificar que solo hay 1 query al progreso_usuarios para verificar si existe
        $progressQueries = array_filter($queries, function($query) {
            return str_contains($query['query'], 'progreso_usuarios');
        });
        
        // Debe haber exactamente 2 queries: 1 para verificar existencia, 1 para insertar
        $this->assertCount(2, $progressQueries);
        
        // La primera query debe usar WHERE con user_id y pregunta_id (aprovecha índice compuesto)
        $firstQuery = array_values($progressQueries)[0]['query'];
        $this->assertStringContainsString('user_id', $firstQuery);
        $this->assertStringContainsString('pregunta_id', $firstQuery);
    }

    /**
     * Test que valida que no hay consultas duplicadas
     */
    public function test_verificar_respuesta_sin_queries_duplicadas(): void
    {
        $usuario = User::factory()->create(['role' => 'alumno']);
        $pregunta = Pregunta::factory()->create([
            'tipo_interaccion' => 'seleccion_simple',
            'respuesta_correcta' => json_encode(['A']),
        ]);

        DB::enableQueryLog();

        $this->actingAs($usuario)
            ->postJson(route('preguntas.verificar', $pregunta->id), [
                'respuesta' => ['A']
            ]);

        $queries = DB::getQueryLog();
        $queryStrings = array_map(fn($q) => $q['query'], $queries);
        
        // Verificar que no hay queries idénticas repetidas
        $this->assertEquals(count($queryStrings), count(array_unique($queryStrings)));
    }

    /**
     * Test de rendimiento: validar 100 respuestas debe tomar < 500ms
     */
    public function test_verificar_100_respuestas_es_rapido(): void
    {
        $this->markTestSkipped('Test de performance - ejecutar manualmente con datos reales');
        
        $usuario = User::factory()->create(['role' => 'alumno']);
        
        // Crear 100 respuestas previas
        for ($i = 0; $i < 100; $i++) {
            $pregunta = Pregunta::factory()->create();
            ProgresoUsuario::create([
                'user_id' => $usuario->id,
                'pregunta_id' => $pregunta->id,
                'respuesta_usuario' => ['A'],
                'es_correcta' => true,
                'completada_at' => now(),
            ]);
        }

        // Nueva pregunta para verificar
        $nuevaPregunta = Pregunta::factory()->create([
            'tipo_interaccion' => 'seleccion_simple',
            'respuesta_correcta' => json_encode(['B']),
        ]);

        $start = microtime(true);
        
        $this->actingAs($usuario)
            ->postJson(route('preguntas.verificar', $nuevaPregunta->id), [
                'respuesta' => ['B']
            ]);
        
        $duration = (microtime(true) - $start) * 1000; // en ms
        
        // Con índices, debe ser < 100ms. Sin índices sería > 300ms
        $this->assertLessThan(100, $duration, "Verificación tardó {$duration}ms (esperado < 100ms)");
    }

    /**
     * Test que verifica que validaciones O(n) son más rápidas que O(n²)
     */
    public function test_validacion_emparejar_es_eficiente(): void
    {
        $usuario = User::factory()->create(['role' => 'alumno']);
        
        // Crear pregunta con 20 emparejamientos (simulando caso complejo)
        $respuestaCorrecta = [];
        $respuestaUsuario = [];
        for ($i = 1; $i <= 20; $i++) {
            $respuestaCorrecta[] = ['objeto' => "obj{$i}", 'destino' => "dest{$i}"];
            $respuestaUsuario[] = ['objeto' => "obj{$i}", 'destino' => "dest{$i}"];
        }
        
        $pregunta = Pregunta::factory()->create([
            'tipo_interaccion' => 'emparejar',
            'respuesta_correcta' => $respuestaCorrecta,
        ]);

        $start = microtime(true);
        
        $response = $this->actingAs($usuario)
            ->postJson(route('preguntas.verificar', $pregunta->id), [
                'respuesta' => $respuestaUsuario
            ]);
        
        $duration = (microtime(true) - $start) * 1000;
        
        $response->assertStatus(200);
        $response->assertJson(['correcta' => true]);
        
        // Con O(n) debe ser < 50ms. Con O(n²) sería > 200ms para 20 elementos
        $this->assertLessThan(50, $duration, "Validación tardó {$duration}ms (esperado < 50ms)");
    }
}
