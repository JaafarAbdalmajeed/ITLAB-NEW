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
        Schema::create('home_background_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['image', 'video', 'animated'])->default('image');
            $table->string('image_path')->nullable();
            $table->string('video_path')->nullable();
            $table->string('animated_type')->nullable()->comment('gif, css-animation, etc');
            $table->boolean('is_active')->default(true);
            $table->text('overlay_color')->nullable()->comment('rgba color for overlay');
            $table->integer('overlay_opacity')->default(50)->comment('0-100');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_background_settings');
    }
};
