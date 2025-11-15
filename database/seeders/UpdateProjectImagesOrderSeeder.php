<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProjectImage;

class UpdateProjectImagesOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // تحديث ترتيب الصور الموجودة
        $projects = \App\Models\Project::with('images')->get();
        
        foreach ($projects as $project) {
            $order = 1;
            foreach ($project->images as $image) {
                $image->update(['order' => $order]);
                $order++;
            }
        }
        
        $this->command->info('Project images order updated successfully!');
    }
}
