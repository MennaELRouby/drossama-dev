<?php

namespace Database\Seeders;

use App\Models\Partener;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartenerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Partener::create([
            'name_en' => 'Partener 1',
            'name_ar' => 'Partener 1',
            'alt_logo' => 'partener1',
            'status' => true,
        ]);
        Partener::create([
            'name_en' => 'Partener 2',
            'name_ar' => 'Partener 2',
            'alt_logo' => 'partener2',
            'status' => true,
        ]);
        Partener::create([
            'name_en' => 'Partener 3',
            'name_ar' => 'Partener 3',
            'alt_logo' => 'partener3',
            'status' => true,
        ]);
        Partener::create([
            'name_en' => 'Partener 4',
            'name_ar' => 'Partener 4',
            'alt_logo' => 'partener4',
            'status' => true,
        ]);
        Partener::create([
            'name_en' => 'Partener 5',
            'name_ar' => 'Partener 5',
            'alt_logo' => 'partener5',
            'status' => true,
        ]);
    }
}
