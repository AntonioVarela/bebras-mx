<?php

use App\Models\User;
use App\Models\Pregunta;
use App\Models\ProgresoUsuario;
use App\Models\OportunidadAdicional;

test('admin can grant additional opportunity to student', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $alumno = User::factory()->create(['role' => 'alumno']);
    $pregunta = Pregunta::factory()->create();
    
    // El alumno responde la pregunta
    ProgresoUsuario::create([
        'user_id' => $alumno->id,
        'pregunta_id' => $pregunta->id,
        'respuesta_usuario' => ['respuesta'],
        'es_correcta' => false,
        'completada_at' => now(),
    ]);
    
    $this->actingAs($admin)
        ->postJson("/admin/alumno/{$alumno->id}/pregunta/{$pregunta->id}/otorgar-oportunidad")
        ->assertJson([
            'success' => true,
            'mensaje' => 'Oportunidad adicional otorgada exitosamente.'
        ]);
    
    $this->assertDatabaseHas('oportunidades_adicionales', [
        'user_id' => $alumno->id,
        'pregunta_id' => $pregunta->id,
        'otorgada_por' => $admin->id,
        'consumida' => false,
    ]);
});

test('non-admin cannot grant additional opportunity', function () {
    $alumno1 = User::factory()->create(['role' => 'alumno']);
    $alumno2 = User::factory()->create(['role' => 'alumno']);
    $pregunta = Pregunta::factory()->create();
    
    ProgresoUsuario::create([
        'user_id' => $alumno2->id,
        'pregunta_id' => $pregunta->id,
        'respuesta_usuario' => ['respuesta'],
        'es_correcta' => false,
        'completada_at' => now(),
    ]);
    
    $this->actingAs($alumno1)
        ->postJson("/admin/alumno/{$alumno2->id}/pregunta/{$pregunta->id}/otorgar-oportunidad")
        ->assertStatus(403);
});

test('cannot grant opportunity if student has not answered question', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $alumno = User::factory()->create(['role' => 'alumno']);
    $pregunta = Pregunta::factory()->create();
    
    $this->actingAs($admin)
        ->postJson("/admin/alumno/{$alumno->id}/pregunta/{$pregunta->id}/otorgar-oportunidad")
        ->assertJson([
            'error' => true,
            'mensaje' => 'El alumno aún no ha respondido esta pregunta.'
        ])
        ->assertStatus(400);
});

test('cannot grant opportunity if one already exists', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $alumno = User::factory()->create(['role' => 'alumno']);
    $pregunta = Pregunta::factory()->create();
    
    ProgresoUsuario::create([
        'user_id' => $alumno->id,
        'pregunta_id' => $pregunta->id,
        'respuesta_usuario' => ['respuesta'],
        'es_correcta' => false,
        'completada_at' => now(),
    ]);
    
    OportunidadAdicional::create([
        'user_id' => $alumno->id,
        'pregunta_id' => $pregunta->id,
        'otorgada_por' => $admin->id,
        'otorgada_at' => now(),
        'consumida' => false,
    ]);
    
    $this->actingAs($admin)
        ->postJson("/admin/alumno/{$alumno->id}/pregunta/{$pregunta->id}/otorgar-oportunidad")
        ->assertJson([
            'error' => true,
            'mensaje' => 'Este alumno ya tiene una oportunidad adicional para esta pregunta.'
        ])
        ->assertStatus(400);
});

test('student with opportunity can answer question again', function () {
    $alumno = User::factory()->create(['role' => 'alumno']);
    $pregunta = Pregunta::factory()->create([
        'respuesta_correcta' => ['A'],
        'tipo_interaccion' => 'seleccion_simple',
        'configuracion' => []
    ]);
    
    // Primera respuesta incorrecta
    ProgresoUsuario::create([
        'user_id' => $alumno->id,
        'pregunta_id' => $pregunta->id,
        'respuesta_usuario' => ['B'],
        'es_correcta' => false,
        'completada_at' => now(),
    ]);
    
    // Otorgar oportunidad
    $oportunidad = OportunidadAdicional::create([
        'user_id' => $alumno->id,
        'pregunta_id' => $pregunta->id,
        'otorgada_por' => User::factory()->create(['role' => 'admin'])->id,
        'otorgada_at' => now(),
        'consumida' => false,
    ]);
    
    // Responder de nuevo
    $this->actingAs($alumno)
        ->postJson("/preguntas/{$pregunta->id}/verificar", [
            'respuesta' => ['A']
        ])
        ->assertJson([
            'correcta' => true
        ]);
    
    // Verificar que la oportunidad fue consumida
    $oportunidad->refresh();
    expect($oportunidad->consumida)->toBeTrue();
    expect($oportunidad->consumida_at)->not->toBeNull();
});

test('student without opportunity cannot answer question again', function () {
    $alumno = User::factory()->create(['role' => 'alumno']);
    $pregunta = Pregunta::factory()->create([
        'respuesta_correcta' => ['A'],
        'tipo_interaccion' => 'seleccion_simple',
        'configuracion' => []
    ]);
    
    ProgresoUsuario::create([
        'user_id' => $alumno->id,
        'pregunta_id' => $pregunta->id,
        'respuesta_usuario' => ['B'],
        'es_correcta' => false,
        'completada_at' => now(),
    ]);
    
    $this->actingAs($alumno)
        ->postJson("/preguntas/{$pregunta->id}/verificar", [
            'respuesta' => ['A']
        ])
        ->assertJson([
            'error' => true,
            'mensaje' => 'Ya respondiste esta pregunta anteriormente.'
        ])
        ->assertStatus(403);
});

test('consumed opportunity cannot be used again', function () {
    $alumno = User::factory()->create(['role' => 'alumno']);
    $pregunta = Pregunta::factory()->create([
        'respuesta_correcta' => ['A'],
        'tipo_interaccion' => 'seleccion_simple',
        'configuracion' => []
    ]);
    
    // Primera respuesta
    ProgresoUsuario::create([
        'user_id' => $alumno->id,
        'pregunta_id' => $pregunta->id,
        'respuesta_usuario' => ['B'],
        'es_correcta' => false,
        'completada_at' => now(),
    ]);
    
    // Oportunidad ya consumida
    OportunidadAdicional::create([
        'user_id' => $alumno->id,
        'pregunta_id' => $pregunta->id,
        'otorgada_por' => User::factory()->create(['role' => 'admin'])->id,
        'otorgada_at' => now(),
        'consumida' => true,
        'consumida_at' => now(),
    ]);
    
    // Segunda respuesta (con nueva entrada de progreso)
    ProgresoUsuario::create([
        'user_id' => $alumno->id,
        'pregunta_id' => $pregunta->id,
        'respuesta_usuario' => ['A'],
        'es_correcta' => true,
        'completada_at' => now(),
    ]);
    
    // Intentar responder de nuevo
    $this->actingAs($alumno)
        ->postJson("/preguntas/{$pregunta->id}/verificar", [
            'respuesta' => ['A']
        ])
        ->assertJson([
            'error' => true,
            'mensaje' => 'Ya respondiste esta pregunta anteriormente.'
        ])
        ->assertStatus(403);
});

test('admin cannot grant opportunity to another admin', function () {
    $admin1 = User::factory()->create(['role' => 'admin']);
    $admin2 = User::factory()->create(['role' => 'admin']);
    $pregunta = Pregunta::factory()->create();
    
    ProgresoUsuario::create([
        'user_id' => $admin2->id,
        'pregunta_id' => $pregunta->id,
        'respuesta_usuario' => ['respuesta'],
        'es_correcta' => false,
        'completada_at' => now(),
    ]);
    
    $this->actingAs($admin1)
        ->postJson("/admin/alumno/{$admin2->id}/pregunta/{$pregunta->id}/otorgar-oportunidad")
        ->assertJson([
            'error' => true,
            'mensaje' => 'Solo se pueden otorgar oportunidades a alumnos.'
        ])
        ->assertStatus(400);
});

test('opportunity deletes previous progress when consumed', function () {
    $alumno = User::factory()->create(['role' => 'alumno']);
    $pregunta = Pregunta::factory()->create([
        'respuesta_correcta' => ['A'],
        'tipo_interaccion' => 'seleccion_simple',
        'configuracion' => []
    ]);
    
    // Primera respuesta incorrecta
    $primerProgreso = ProgresoUsuario::create([
        'user_id' => $alumno->id,
        'pregunta_id' => $pregunta->id,
        'respuesta_usuario' => ['B'],
        'es_correcta' => false,
        'completada_at' => now(),
    ]);
    
    $primerProgresoId = $primerProgreso->id;
    
    // Otorgar oportunidad
    OportunidadAdicional::create([
        'user_id' => $alumno->id,
        'pregunta_id' => $pregunta->id,
        'otorgada_por' => User::factory()->create(['role' => 'admin'])->id,
        'otorgada_at' => now(),
        'consumida' => false,
    ]);
    
    // Responder de nuevo (correctamente)
    $this->actingAs($alumno)
        ->postJson("/preguntas/{$pregunta->id}/verificar", [
            'respuesta' => ['A']
        ])
        ->assertJson([
            'correcta' => true
        ]);
    
    // Verificar que el progreso anterior fue eliminado
    $this->assertDatabaseMissing('progreso_usuarios', [
        'id' => $primerProgresoId
    ]);
    
    // Verificar que existe un nuevo progreso
    $this->assertDatabaseHas('progreso_usuarios', [
        'user_id' => $alumno->id,
        'pregunta_id' => $pregunta->id,
        'es_correcta' => true,
    ]);
});
