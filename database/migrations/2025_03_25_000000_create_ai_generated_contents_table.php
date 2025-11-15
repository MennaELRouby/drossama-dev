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
        Schema::create('ai_generated_contents', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->longText('content');
            $table->string('type'); // article, page, seo, title, description, keywords
            $table->text('prompt');
            $table->json('options')->nullable();
            $table->json('usage_data')->nullable();
            $table->string('model_used')->nullable();
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active');
            $table->foreignId('generated_by')->constrained('admins')->onDelete('cascade');
            $table->string('target_model')->nullable(); // النموذج المرتبط (Blog, Page, etc.)
            $table->unsignedBigInteger('target_id')->nullable(); // ID للنموذج المرتبط
            $table->text('meta_description')->nullable();
            $table->text('keywords')->nullable();
            $table->integer('word_count')->nullable();
            $table->timestamp('generation_time')->nullable();
            $table->decimal('cost', 10, 6)->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['type', 'status']);
            $table->index(['target_model', 'target_id']);
            $table->index('generated_by');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_generated_contents');
    }
}; 