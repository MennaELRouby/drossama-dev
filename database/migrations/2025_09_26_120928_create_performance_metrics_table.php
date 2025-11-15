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
        Schema::create('performance_metrics', function (Blueprint $table) {
            $table->id();
            $table->string('metric'); // CLS, FID, LCP, FCP, TTFB
            $table->decimal('value', 10, 4); // القيمة الفعلية
            $table->string('rating'); // good, needs_improvement, poor
            $table->string('page'); // الصفحة
            $table->string('user_agent')->nullable(); // متصفح المستخدم
            $table->string('ip_address')->nullable(); // عنوان IP
            $table->timestamps();

            // فهارس للبحث السريع
            $table->index(['metric', 'rating']);
            $table->index(['page', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_metrics');
    }
};
