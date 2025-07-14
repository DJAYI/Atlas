<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Índices para asistencias
        Schema::table('assistances', function (Blueprint $table) {
            // Índice compuesto para consultas de reportes
            $table->index(['created_at', 'person_id'], 'idx_assistances_created_person');
            $table->index(['event_id', 'person_id'], 'idx_assistances_event_person');
            $table->index(['mobility_id'], 'idx_assistances_mobility');
            $table->index(['university_destiny_id'], 'idx_assistances_university_destiny');
        });

        // Índices para personas (para búsquedas)
        Schema::table('people', function (Blueprint $table) {
            $table->index(['firstname'], 'idx_people_firstname');
            $table->index(['lastname'], 'idx_people_lastname');
            $table->index(['email'], 'idx_people_email');
            $table->index(['document_number'], 'idx_people_document_number');
            $table->index(['university_id'], 'idx_people_university');
            $table->index(['country_id'], 'idx_people_country');
            $table->index(['career_id'], 'idx_people_career');
            $table->index(['type'], 'idx_people_type');
        });

        // Índices para eventos
        Schema::table('events', function (Blueprint $table) {
            $table->index(['start_date'], 'idx_events_start_date');
            $table->index(['name'], 'idx_events_name');
            $table->index(['activity_id'], 'idx_events_activity');
            $table->index(['career_id'], 'idx_events_career');
            $table->index(['modality'], 'idx_events_modality');
            $table->index(['location'], 'idx_events_location');
        });

        // Índices para universidades
        Schema::table('universities', function (Blueprint $table) {
            $table->index(['name'], 'idx_universities_name');
        });

        // Índices para carreras
        Schema::table('careers', function (Blueprint $table) {
            $table->index(['name'], 'idx_careers_name');
        });

        // Índices para países
        Schema::table('countries', function (Blueprint $table) {
            $table->index(['name'], 'idx_countries_name');
        });

        // Índices para actividades
        Schema::table('activities', function (Blueprint $table) {
            $table->index(['name'], 'idx_activities_name');
        });

        // Índices para movilidades
        Schema::table('mobilities', function (Blueprint $table) {
            $table->index(['name'], 'idx_mobilities_name');
            $table->index(['type'], 'idx_mobilities_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Eliminar índices para asistencias
        Schema::table('assistances', function (Blueprint $table) {
            $table->dropIndex('idx_assistances_created_person');
            $table->dropIndex('idx_assistances_event_person');
            $table->dropIndex('idx_assistances_mobility');
            $table->dropIndex('idx_assistances_university_destiny');
        });

        // Eliminar índices para personas
        Schema::table('people', function (Blueprint $table) {
            $table->dropIndex('idx_people_firstname');
            $table->dropIndex('idx_people_lastname');
            $table->dropIndex('idx_people_email');
            $table->dropIndex('idx_people_document_number');
            $table->dropIndex('idx_people_university');
            $table->dropIndex('idx_people_country');
            $table->dropIndex('idx_people_career');
            $table->dropIndex('idx_people_type');
        });

        // Eliminar índices para eventos
        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex('idx_events_start_date');
            $table->dropIndex('idx_events_name');
            $table->dropIndex('idx_events_activity');
            $table->dropIndex('idx_events_career');
            $table->dropIndex('idx_events_modality');
            $table->dropIndex('idx_events_location');
        });

        // Eliminar índices para universidades
        Schema::table('universities', function (Blueprint $table) {
            $table->dropIndex('idx_universities_name');
        });

        // Eliminar índices para carreras
        Schema::table('careers', function (Blueprint $table) {
            $table->dropIndex('idx_careers_name');
        });

        // Eliminar índices para países
        Schema::table('countries', function (Blueprint $table) {
            $table->dropIndex('idx_countries_name');
        });

        // Eliminar índices para actividades
        Schema::table('activities', function (Blueprint $table) {
            $table->dropIndex('idx_activities_name');
        });

        // Eliminar índices para movilidades
        Schema::table('mobilities', function (Blueprint $table) {
            $table->dropIndex('idx_mobilities_name');
            $table->dropIndex('idx_mobilities_type');
        });
    }
};
