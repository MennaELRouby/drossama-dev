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
        // Migrate existing clients and location data to JSON format
        $products = DB::table('products')->get();

        foreach ($products as $product) {
            $clientsData = [];
            $locationData = [];

            // Collect existing data
            if ($product->clients_en) {
                $clientsData['en'] = $product->clients_en;
            }
            if ($product->clients_ar) {
                $clientsData['ar'] = $product->clients_ar;
            }

            if ($product->location_en) {
                $locationData['en'] = $product->location_en;
            }
            if ($product->location_ar) {
                $locationData['ar'] = $product->location_ar;
            }

            // Update the product with JSON data
            DB::table('products')
                ->where('id', $product->id)
                ->update([
                    'clients' => !empty($clientsData) ? json_encode($clientsData) : null,
                    'location' => !empty($locationData) ? json_encode($locationData) : null,
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration doesn't need to be reversed as it's a data migration
    }
};