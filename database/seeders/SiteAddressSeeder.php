<?php

namespace Database\Seeders;

use App\Models\SiteAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteAddress::factory()->count(2)->create();
    }
}
