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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
<<<<<<< HEAD
            $table->string('code', 5)->unique();
            $table->string('phone_code', 5)->nullable();
=======
            $table->string('iso_code_alpha-3', 3)->unique();
            $table->string('iso_code', 3)->unique();
>>>>>>> 59d1c10bf4a9a1cd11dba6c43e502062676d2e99
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
