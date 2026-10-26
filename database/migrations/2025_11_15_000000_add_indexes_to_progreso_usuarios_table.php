<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('progreso_usuarios', function (Blueprint $table) {
            // Índice compuesto para búsquedas por usuario y pregunta (caso más común)
            $table->index(['user_id', 'pregunta_id'], 'idx_progreso_user_pregunta');
            
            // Índice para búsquedas por pregunta (usado en dashboard de admin)
            $table->index('pregunta_id', 'idx_progreso_pregunta');
            
            // Índice para búsquedas por usuario (usado en listados de progreso)
            $table->index('user_id', 'idx_progreso_user');
            
            // Índice para filtrar por respuestas correctas
            $table->index('es_correcta', 'idx_progreso_correcta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('progreso_usuarios', function (Blueprint $table) {
            $table->dropIndex('idx_progreso_user_pregunta');
            $table->dropIndex('idx_progreso_pregunta');
            $table->dropIndex('idx_progreso_user');
            $table->dropIndex('idx_progreso_correcta');
        });
    }
};
