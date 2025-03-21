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
            $table->string('event_code');

            $table->enum('has_agreement', ['si', 'no']);
<<<<<<< HEAD
            $table->foreignId('agreement_id')->constrained('agreements')->cascadeOnDelete()->nullable();
=======
            $table->foreignId('agreement_id')->nullable()->constrained('agreements')->cascadeOnDelete();
>>>>>>> 59d1c10bf4a9a1cd11dba6c43e502062676d2e99

            $table->enum('modality', ['presencial', 'virtual', 'en casa']);
            $table->enum('location', ['nacional', 'internacional', 'local']);
            $table->enum('internationalization_at_home', ['si', 'no']);

            $table->date('start_date');
            $table->date('end_date');

            $table->time('start_time');
            $table->time('end_time');

<<<<<<< HEAD
            $table->foreignId('financial_country_id')->constrained(
=======
            $table->foreignId('financial_country_id')->nullable()->constrained(
>>>>>>> 59d1c10bf4a9a1cd11dba6c43e502062676d2e99
                table: 'countries',
                indexName: 'financial_country_id'
            )->cascadeOnDelete();

            $table->foreignId('university_id')->constrained('universities')->cascadeOnDelete();
            $table->float('financial_value', 8, 2);
            $table->float('financial_international_value', 8, 2)->nullable();
            $table->foreignId('financial_entity_id')->constrained('financial_entities')->cascadeOnDelete();

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
