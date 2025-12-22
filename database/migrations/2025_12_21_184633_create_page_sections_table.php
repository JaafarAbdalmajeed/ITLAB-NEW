<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('subtitle')->nullable();
            $table->longText('content')->nullable();
            $table->string('section_type')->default('content'); // content, hero, features, testimonials, etc.
            $table->json('metadata')->nullable(); // For additional data like images, links, etc.
            $table->integer('order')->default(0);
            $table->boolean('published')->default(true);
            $table->timestamps();
            
            $table->index(['page_id', 'order']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('page_sections');
    }
};
