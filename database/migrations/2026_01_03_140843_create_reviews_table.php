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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('track_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('lesson_id')->nullable()->constrained()->cascadeOnDelete();
            $table->text('review');
            $table->boolean('is_approved')->default(true);
            $table->timestamps();

            // Ensure user can only review each track once
            $table->unique(['user_id', 'track_id'], 'unique_user_track_review');
            
            // Ensure user can only review each lesson once
            $table->unique(['user_id', 'lesson_id'], 'unique_user_lesson_review');
            
            $table->index('track_id');
            $table->index('lesson_id');
            $table->index('is_approved');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
