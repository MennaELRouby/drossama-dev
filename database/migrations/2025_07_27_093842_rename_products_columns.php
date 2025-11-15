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
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('clients', 'clients_ar');
            $table->renameColumn('location', 'location_ar');
            $table->renameColumn('category', 'category_ar');
            $table->renameColumn('service', 'service_ar');
    
            // لو عايز تضيف الأعمدة الإنجليزية
            $table->string('clients_en')->nullable();
            $table->string('location_en')->nullable();
            $table->string('category_en')->nullable();
            $table->string('service_en')->nullable();
        });
    }
    
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('clients_ar', 'clients');
            $table->renameColumn('location_ar', 'location');
            $table->renameColumn('category_ar', 'category');
            $table->renameColumn('service_ar', 'service');
    
            $table->dropColumn(['clients_en', 'location_en', 'category_en', 'service_en']);
        });
    }
    
};
