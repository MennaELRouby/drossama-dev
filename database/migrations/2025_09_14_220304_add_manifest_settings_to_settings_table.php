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
        // Add manifest-related settings
        $settings = [
            'site_short_name' => 'Tulip',
            'site_description' => 'Professional web development, SEO, and digital marketing services in Egypt',
            'theme_color' => '#007bff',
            'background_color' => '#ffffff',
            'site_logo' => null, // Will be set via dashboard
        ];

        foreach ($settings as $key => $value) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $key, 'lang' => 'all'],
                ['value' => $value]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $keys = [
            'site_short_name',
            'site_description',
            'theme_color',
            'background_color',
            'site_logo'
        ];

        \App\Models\Setting::whereIn('key', $keys)->delete();
    }
};
