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
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Unique code for each achievement (e.g., 'first_lesson', 'perfect_quiz')
            $table->string('name_ar'); // Arabic name
            $table->string('name_en')->nullable(); // English name
            $table->text('description_ar'); // Arabic description
            $table->text('description_en')->nullable(); // English description
            $table->string('icon')->nullable(); // Icon class or path
            $table->string('badge_color')->default('#3b82f6'); // Badge color
            $table->string('type'); // Type: 'lesson', 'track', 'quiz', 'streak', 'count'
            $table->json('criteria')->nullable(); // JSON criteria (e.g., {"count": 5, "score": 100})
            $table->integer('points')->default(0); // Points awarded
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0); // Display order
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
