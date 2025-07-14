<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Esta migración agrega índices para mejorar el rendimiento de las consultas más comunes
     */
    public function up(): void
    {
        // Eventos: índices para búsqueda por fecha y filtros comunes
        Schema::table('events', function (Blueprint $table) {
            $table->index('start_date');
            $table->index('end_date');
            $table->index(['location', 'modality']);
            $table->index('internationalization_at_home');
        });

        // Asistencias: índices para relaciones y búsquedas comunes
        Schema::table('assistances', function (Blueprint $table) {
            $table->index(['event_id', 'person_id']); 
            $table->index('mobility_id');
        });

        // Personas: índices para búsquedas comunes
        Schema::table('people', function (Blueprint $table) {
            $table->index(['document_type', 'document_number']); 
            $table->index(['university_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eventos: eliminar índices
        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex(['start_date']);
            $table->dropIndex(['end_date']);
            $table->dropIndex(['location', 'modality']);
            $table->dropIndex(['internationalization_at_home']);
        });

        // Asistencias: eliminar índices
        Schema::table('assistances', function (Blueprint $table) {
            $table->dropIndex(['event_id', 'person_id']);
            $table->dropIndex(['mobility_id']);
        });

        // Personas: eliminar índices
        Schema::table('people', function (Blueprint $table) {
            $table->dropIndex(['document_type', 'document_number']);
            $table->dropIndex(['university_id', 'type']);
        });
    }
};
