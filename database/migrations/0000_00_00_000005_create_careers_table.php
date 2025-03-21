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
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->foreignId('faculty_id')->constrained('faculties')->cascadeOnDelete();
<<<<<<< HEAD
=======
            $table->foreignId('university_id')->constrained('universities')->cascadeOnDelete();
>>>>>>> 59d1c10bf4a9a1cd11dba6c43e502062676d2e99
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('careers');
    }
};
