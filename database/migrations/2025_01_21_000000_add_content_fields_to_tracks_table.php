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
        Schema::table('tracks', function (Blueprint $table) {
            // محتوى Tutorial
            $table->longText('tutorial_content')->nullable()->after('description');
            
            // محتوى Reference
            $table->longText('reference_content')->nullable()->after('tutorial_content');
            
            // روابط الفيديوهات (JSON)
            $table->json('videos')->nullable()->after('reference_content');
            
            // محتوى إضافي للصفحة الرئيسية
            $table->longText('hero_content')->nullable()->after('videos');
            $table->string('hero_button_text')->nullable()->after('hero_content');
            $table->string('hero_button_link')->nullable()->after('hero_button_text');
            
            // إعدادات العرض
            $table->boolean('show_tutorial')->default(true)->after('hero_button_link');
            $table->boolean('show_reference')->default(true)->after('show_tutorial');
            $table->boolean('show_videos')->default(true)->after('show_reference');
            $table->boolean('show_labs')->default(true)->after('show_videos');
            $table->boolean('show_quiz')->default(true)->after('show_labs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracks', function (Blueprint $table) {
            $table->dropColumn([
                'tutorial_content',
                'reference_content',
                'videos',
                'hero_content',
                'hero_button_text',
                'hero_button_link',
                'show_tutorial',
                'show_reference',
                'show_videos',
                'show_labs',
                'show_quiz',
            ]);
        });
    }
};

