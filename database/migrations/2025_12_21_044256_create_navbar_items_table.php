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
        Schema::create('navbar_items', function (Blueprint $table) {
            $table->id();
            $table->string('label'); // النص المعروض في النافبار
            $table->string('url'); // الرابط
            $table->string('route')->nullable(); // اسم Route (اختياري)
            $table->string('icon')->nullable(); // أيقونة (اختياري)
            $table->integer('order')->default(0); // ترتيب العنصر
            $table->boolean('is_active')->default(true); // تفعيل/تعطيل
            $table->string('target')->default('_self'); // _self أو _blank
            $table->string('css_class')->nullable(); // كلاسات CSS إضافية
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navbar_items');
    }
};
