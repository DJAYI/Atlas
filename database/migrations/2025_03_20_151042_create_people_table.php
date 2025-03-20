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

            $table->string('email')->unique();
            $table->string('phone')->nullable();

            $table->foreignId('country_id')->constrained('countries');
            $table->foreignId('state_id')->constrained('states');
            $table->foreignId('city_id')->constrained('cities');
            $table->string('address')->nullable();

            $table->enum('genre', ['M', 'F', 'O'])->nullable();
            $table->date('birth_date');

            $table->enum('minority', ['afrodescendiente', 'indigena', 'gitano', 'LGTBISQ+', 'discapacitado', 'victima de conflicto armado', 'desplazado'])->nullable();
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
