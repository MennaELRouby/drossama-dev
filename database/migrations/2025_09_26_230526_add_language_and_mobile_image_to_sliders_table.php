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
        Schema::table('sliders', function (Blueprint $table) {
            $table->string('language', 5)->default('all')->after('type')->comment('Language code or "all" for all languages');
            $table->string('mobile_image')->nullable()->after('image')->comment('Mobile-specific image');
            $table->string('alt_mobile_image')->nullable()->after('alt_image')->comment('Alt text for mobile image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn(['language', 'mobile_image', 'alt_mobile_image']);
        });
    }
};
