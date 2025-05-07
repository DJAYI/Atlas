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
        Schema::create('assistances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();

            $table->foreignId('person_id')->constrained('people')->cascadeOnDelete();

            $table->foreignId('university_destiny_id')->constrained('universities')->cascadeOnDelete();


            // tipo de movilidad
            $table->foreignId('mobility_id')->constrained('mobilities')->cascadeOnDelete();

            // Archivo de Documento de Identidad
            $table->string('identity_document_file')->nullable();   

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assistances');
    }
};
