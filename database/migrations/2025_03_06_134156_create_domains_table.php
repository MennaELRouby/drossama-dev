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
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_ar');
            $table->decimal('yearly_price')->default(0,00);
            $table->decimal('transfer_price')->default(0,00);
            $table->decimal('renewal_price')->default(0,00);
            $table->text('short_desc_en')->nullable();
            $table->text('short_desc_ar')->nullable();
            $table->string('slug_en')->unique();
            $table->string('slug_ar')->unique();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('domains');
    }
};
