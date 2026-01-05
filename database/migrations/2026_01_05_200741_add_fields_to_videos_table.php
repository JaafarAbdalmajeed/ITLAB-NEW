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
        Schema::table('videos', function (Blueprint $table) {
            $table->text('description')->nullable()->after('title');
            $table->string('video_id')->nullable()->after('url'); // YouTube video ID or playlist ID
            $table->string('color')->default('#00ffaa')->after('video_id'); // Border color
            $table->integer('order')->default(0)->after('color'); // Display order
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn(['description', 'video_id', 'color', 'order']);
        });
    }
};
