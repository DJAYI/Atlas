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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('responsable');
            $table->foreignId('activity_id')->constrained('activities')->cascadeOnDelete();
            $table->string('event_code')->unique();

            $table->enum('has_agreement', ['si', 'no'])->default('no');
            $table->foreignId('agreement_id')->nullable()->constrained('agreements')->cascadeOnDelete();

            $table->enum('modality', ['presencial', 'virtual', 'en casa']);
            $table->enum('location', ['nacional', 'internacional', 'local']);
            $table->enum('internationalization_at_home', ['si', 'no'])->default('no');
            $table->date('start_date');
            $table->date('end_date');

            $table->time('start_time');
            $table->time('end_time');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
