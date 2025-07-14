<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Esta migración añade una tabla para estadísticas agregadas precalculadas
     * que puede ser actualizada periódicamente mediante un comando programado
     */
    public function up(): void
    {
        Schema::create('dashboard_statistics', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->string('location');
            $table->string('modality');
            $table->string('role');
            $table->string('direction');
            $table->integer('count');
            $table->timestamps();
            
            // Índice para búsquedas rápidas
            $table->index(['year', 'location', 'modality', 'role', 'direction']);
        });
        
        Schema::create('activity_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained('activities')->cascadeOnDelete();
            $table->integer('total_events');
            $table->integer('total_assistances');
            $table->timestamps();
            
            // Índice para búsqueda por actividad
            $table->index('activity_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dashboard_statistics');
        Schema::dropIfExists('activity_statistics');
    }
};
