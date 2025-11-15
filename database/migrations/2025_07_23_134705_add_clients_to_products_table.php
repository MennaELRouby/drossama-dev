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
            //
            $table->string('clients')->nullable();
            $table->string('location')->nullable();
            $table->date('date')->nullable();
            $table->string('category')->nullable();
            $table->string('service')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
            $table->dropColumn('clients');
            $table->dropColumn('location');
            $table->dropColumn('date');
            $table->dropColumn('category');
            $table->dropColumn('service');
        });
    }
};
