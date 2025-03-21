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
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD
            $table->string('name');
            $table->string('description');
            $table->foreignId('university_id')->constrained('universities')->cascadeOnDelete();
=======
            $table->year('year');
            $table->string('semester', 2);
            $table->string('code', 4)->unique();
            $table->enum('type', ['marco', 'especifico']);
            $table->enum('activity', [
                'formacion',
                'investigacion',
                'extension',
                'administrativa',
                'otra'
            ]);

            $table->date('start_date');
            $table->date('end_date');
>>>>>>> 59d1c10bf4a9a1cd11dba6c43e502062676d2e99
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agreements');
    }
};
