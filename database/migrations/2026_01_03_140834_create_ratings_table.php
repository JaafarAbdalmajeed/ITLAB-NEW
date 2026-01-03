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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('track_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('lesson_id')->nullable()->constrained()->cascadeOnDelete();
            $table->integer('rating')->comment('Rating from 1 to 5');
            $table->timestamps();

            // Ensure user can only rate each track once
            $table->unique(['user_id', 'track_id'], 'unique_user_track_rating');
            
            // Ensure user can only rate each lesson once  
            $table->unique(['user_id', 'lesson_id'], 'unique_user_lesson_rating');
            
            $table->index('track_id');
            $table->index('lesson_id');
            $table->index('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
