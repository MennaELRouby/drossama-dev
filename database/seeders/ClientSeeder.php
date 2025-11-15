<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Client::create([
            'name_en' => 'Client 1',
            'name_ar' => 'Client 1',
            'status' => true,
        ]); 
        Client::create([
            'name_en' => 'Client 2',
            'name_ar' => 'Client 2',
            'status' => true,
        ]);
        Client::create([
            'name_en' => 'Client 3',
            'name_ar' => 'Client 3',
            'status' => true,
        ]);
        Client::create([
            'name_en' => 'Client 4',
            'name_ar' => 'Client 4',
            'status' => true,
        ]);
        Client::create([
            'name_en' => 'Client 5',
            'name_ar' => 'Client 5',
            'status' => true,
        ]);
    }
}
