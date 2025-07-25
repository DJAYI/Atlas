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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->string('second_lastname')->nullable();

            $table->enum('document_type', ['CC', 'CE', 'TI', 'PP', 'DNI', 'CA', 'Otro']);
            $table->string('document_number');

            $table->string('email')->unique();
            $table->string('institutional_email')->unique()->nullable();
            $table->string('phone')->nullable();



            // Masculino, Femenino, Otro, Prefiero No Decirlo
            $table->enum('genre', ['M', 'F', 'O', 'PND'])->default('PND');
            $table->date('birth_date');

            $table->enum('minority', ['afrodescendiente', 'indigena', 'gitano', 'LGTBISQ+', 'discapacitado', 'victima de conflicto armado', 'desplazado', 'PDET'])->nullable();

            // Pais

            $table->foreignId('country_id')->constrained('countries');

            $table->enum('type', ['estudiante', 'profesor', 'empresario', 'administrativo', 'egresado', 'otro'])->default('estudiante');

            $table->foreignId('career_id')->nullable()->constrained('careers');

            $table->foreignId('university_id')->nullable()->constrained('universities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
