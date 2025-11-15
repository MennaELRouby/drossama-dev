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
        Schema::create('about', function (Blueprint $table) {
            $table->id();
            $table->json('title')->nullable();
            $table->json('short_desc')->nullable();
            $table->json('title2')->nullable();
            $table->json('long_desc')->nullable();
            $table->json('text')->nullable();
            $table->string('image', 50)->nullable();
            $table->string('alt_image', 50)->nullable();
            $table->string('banner', 50)->nullable();
            $table->string('alt_banner', 50)->nullable();
            $table->string('video_link', 500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about');
    }
};
