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
        Schema::create('financial_entities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
<<<<<<< HEAD
            $table->string('code', 2)->unique();
            $table->foreignId('country_id')->constrained('countries')->cascadeOnDelete();
=======
            $table->string('code', 4)->unique();

>>>>>>> 59d1c10bf4a9a1cd11dba6c43e502062676d2e99
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_entities');
    }
};
