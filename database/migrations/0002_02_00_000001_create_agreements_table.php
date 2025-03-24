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
            $table->year('year');
            $table->string('semester', 1);
            $table->string('code', 6)->unique();
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
