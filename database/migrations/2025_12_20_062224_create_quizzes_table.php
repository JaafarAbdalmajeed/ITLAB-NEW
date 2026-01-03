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
   Schema::create('quizzes', function (Blueprint $table) {
    $table->id();
    $table->foreignId('track_id')->constrained()->cascadeOnDelete();
    $table->string('question'); // أضف هذا السطر
    $table->string('option_a'); // أضف هذا السطر
    $table->string('option_b'); // أضف هذا السطر
    $table->string('option_c'); // أضف هذا السطر
    $table->string('correct_answer'); // أضف هذا السطر
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
