<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add new JSON columns
        Schema::table('site_addresses', function (Blueprint $table) {
            $table->json('title')->nullable()->after('id');
            $table->json('address')->nullable()->after('title');
            $table->string('code')->nullable()->after('phone');
            $table->string('code2')->nullable()->after('phone2');
        });

        // Convert existing data to JSON format
        $siteAddresses = DB::table('site_addresses')->get();

        foreach ($siteAddresses as $siteAddress) {
            $title = [];
            $address = [];

            if ($siteAddress->title_ar) {
                $title['ar'] = $siteAddress->title_ar;
            }
            if ($siteAddress->title_en) {
                $title['en'] = $siteAddress->title_en;
            }

            if ($siteAddress->address_ar) {
                $address['ar'] = $siteAddress->address_ar;
            }
            if ($siteAddress->address_en) {
                $address['en'] = $siteAddress->address_en;
            }

            DB::table('site_addresses')
                ->where('id', $siteAddress->id)
                ->update([
                    'title' => json_encode($title, JSON_UNESCAPED_UNICODE),
                    'address' => json_encode($address, JSON_UNESCAPED_UNICODE),
                ]);
        }

        // Drop old columns
        Schema::table('site_addresses', function (Blueprint $table) {
            $table->dropColumn(['title_ar', 'title_en', 'address_ar', 'address_en']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back old columns
        Schema::table('site_addresses', function (Blueprint $table) {
            $table->string('title_ar')->nullable()->after('id');
            $table->string('title_en')->nullable()->after('title_ar');
            $table->text('address_ar')->nullable()->after('title_en');
            $table->text('address_en')->nullable()->after('address_ar');
        });

        // Convert JSON data back to old format
        $siteAddresses = DB::table('site_addresses')->get();

        foreach ($siteAddresses as $siteAddress) {
            $title = json_decode($siteAddress->title, true) ?? [];
            $address = json_decode($siteAddress->address, true) ?? [];

            DB::table('site_addresses')
                ->where('id', $siteAddress->id)
                ->update([
                    'title_ar' => $title['ar'] ?? null,
                    'title_en' => $title['en'] ?? null,
                    'address_ar' => $address['ar'] ?? null,
                    'address_en' => $address['en'] ?? null,
                ]);
        }

        // Drop new columns
        Schema::table('site_addresses', function (Blueprint $table) {
            $table->dropColumn(['title', 'address', 'code', 'code2']);
        });
    }
};
