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
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('short_desc_en')->nullable();
            $table->string('short_desc_ar')->nullable();
            $table->longText('long_desc_en')->nullable();
            $table->longText('long_desc_ar')->nullable();
            $table->string('image')->nullable();
            $table->string('alt_image')->nullable();
            $table->string('icon')->nullable();
            $table->string('alt_icon')->nullable();
            $table->string('meta_title_en')->nullable();
            $table->string('meta_title_ar')->nullable();
            $table->text('meta_desc_en')->nullable();
            $table->text('meta_desc_ar')->nullable();
            $table->string('slug_en')->nullable();
            $table->string('slug_ar')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('show_in_home')->default(false);
            $table->boolean('show_in_header')->default(false);
            $table->boolean('show_in_footer')->default(false);
            $table->boolean('index')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_categories');
    }
};
