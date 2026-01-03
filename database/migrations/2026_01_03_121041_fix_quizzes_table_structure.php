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
        // Drop columns that shouldn't be in quizzes table
        if (Schema::hasColumn('quizzes', 'question')) {
            Schema::table('quizzes', function (Blueprint $table) {
                $table->dropColumn('question');
            });
        }
        if (Schema::hasColumn('quizzes', 'option_a')) {
            Schema::table('quizzes', function (Blueprint $table) {
                $table->dropColumn('option_a');
            });
        }
        if (Schema::hasColumn('quizzes', 'option_b')) {
            Schema::table('quizzes', function (Blueprint $table) {
                $table->dropColumn('option_b');
            });
        }
        if (Schema::hasColumn('quizzes', 'option_c')) {
            Schema::table('quizzes', function (Blueprint $table) {
                $table->dropColumn('option_c');
            });
        }
        if (Schema::hasColumn('quizzes', 'correct_answer')) {
            Schema::table('quizzes', function (Blueprint $table) {
                $table->dropColumn('correct_answer');
            });
        }

        // Ensure correct columns exist
        if (!Schema::hasColumn('quizzes', 'title')) {
            Schema::table('quizzes', function (Blueprint $table) {
                $table->string('title')->after('track_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration only removes incorrect columns, so we don't need to reverse it
    }
};
