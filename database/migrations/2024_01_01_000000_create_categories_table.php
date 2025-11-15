<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->integer('order')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('image', 191)->nullable();
            $table->string('icon', 191)->nullable();
            $table->string('alt_image', 255)->nullable();
            $table->string('alt_icon', 255)->nullable();
            $table->json('short_desc')->nullable();
            $table->json('long_desc')->nullable();
            $table->boolean('status')->nullable();
            $table->boolean('show_in_home')->nullable();
            $table->boolean('show_in_header')->nullable();
            $table->boolean('show_in_footer')->nullable();
            $table->json('meta_title')->nullable();
            $table->json('meta_desc')->nullable();
            $table->boolean('index')->nullable();
            $table->json('slug');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
