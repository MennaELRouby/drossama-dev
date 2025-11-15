<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServiceImage;

class UpdateServiceImagesOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // تحديث ترتيب الصور الموجودة
        $services = \App\Models\Service::with('images')->get();
        
        foreach ($services as $service) {
            $order = 1;
            foreach ($service->images as $image) {
                $image->update(['order' => $order]);
                $order++;
            }
        }
        
        $this->command->info('Service images order updated successfully!');
    }
}
