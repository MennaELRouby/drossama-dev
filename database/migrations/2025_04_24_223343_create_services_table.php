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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('services');
            $table->json('name');
            $table->json('short_desc')->nullable();
            $table->json('long_desc')->nullable();
            $table->string('image')->nullable();
            $table->string('alt_image')->nullable();
            $table->string('icon')->nullable();
            $table->string('alt_icon')->nullable();
            $table->json('slug');
            $table->boolean('status')->default(true);
            $table->boolean('show_in_home')->default(false);
            $table->boolean('show_in_header')->default(false);
            $table->boolean('show_in_footer')->default(false);
            $table->json('meta_title')->nullable();
            $table->json('meta_desc')->nullable();
            $table->boolean('index')->nullable()->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
