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
        Schema::table('about', function (Blueprint $table) {
            if (!Schema::hasColumn('about', 'video_link')) {
                $table->string('video_link', 500)->nullable()->after('alt_banner');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about', function (Blueprint $table) {
            if (Schema::hasColumn('about', 'video_link')) {
                $table->dropColumn('video_link');
            }
        });
    }
};
