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
            $table->string('code', 2)->unique();
            $table->foreignId('country_id')->constrained('countries')->cascadeOnDelete();
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
