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
        Schema::table('lessons', function (Blueprint $table) {
            $table->json('youtube_videos')->nullable()->after('content');
            $table->json('sections')->nullable()->after('youtube_videos');
            $table->boolean('enable_code_editor')->default(false)->after('sections');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn(['youtube_videos', 'sections', 'enable_code_editor']);
        });
    }
};
