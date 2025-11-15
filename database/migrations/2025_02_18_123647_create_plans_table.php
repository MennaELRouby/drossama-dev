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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hosting_id')->constrained('hostings')->onDelete('restrict');
            $table->string('name_en');
            $table->string('name_ar');
            $table->string('lable')->nullable();
            $table->decimal('monthly_price',10,2);
            $table->decimal('yearly_price',10,2);
            $table->string('image')->nullable();
            $table->string('alt_image')->nullable();
            $table->string('icon')->nullable();
            $table->string('alt_icon')->nullable();
            $table->string('slug_en')->unique();
            $table->string('slug_ar')->unique();
            $table->boolean('status')->default(true);
            $table->boolean('show_in_home')->default(false);
            $table->string('meta_title_ar',255)->nullable();
            $table->string('meta_title_en',255)->nullable();
            $table->longText('meta_desc_ar')->nullable();
            $table->longText('meta_desc_en')->nullable();
            $table->boolean('index')->nullable()->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
