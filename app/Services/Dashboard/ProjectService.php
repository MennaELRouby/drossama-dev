<?php

namespace App\Services\Dashboard;

use App\Helper\Media;
use App\Services\JsonTranslationService;
use App\Models\Project as ModelsProject;
use App\Models\ProjectImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ProjectService extends BaseDashboardService
{
    protected function getModel(): string
    {
        return ModelsProject::class;
    }

    protected function getImagePath(): string
    {
        return 'projects';
    }

    public function store($request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            // Prepare main data (non-translatable fields)
            $mainData = [
                'category_id' => $data['category_id'] ?? null,
                'parent_id' => $data['parent_id'] ?? null,
                'image' => null,
                'alt_image' => $data['alt_image'] ?? null,
                'icon' => null,
                'alt_icon' => $data['alt_icon'] ?? null,
                'status' => $data['status'] ?? 1,
                'show_in_home' => $data['show_in_home'] ?? 0,
                'show_in_header' => $data['show_in_header'] ?? 0,
                'show_in_footer' => $data['show_in_footer'] ?? 0,
                'index' => $data['index'] ?? 0,
                'order' => $data['order'] ?? 0,
                'clients' => $data['clients'] ?? null,
                'location' => $data['location'] ?? null,
                'category' => $data['category'] ?? null,
                'service' => $data['service'] ?? null,
                'date' => $data['date'] ?? null,
            ];

            // Handle file uploads
            if ($request->hasFile('image')) {
                $mainData['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'projects');
            }
            if ($request->hasFile('icon')) {
                $mainData['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'projects');
            }

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('project');

            // Create model with JSON translations
            $model = JsonTranslationService::createWithTranslations(ModelsProject::class, $mainData, $request, $translationFields);

            // Handle project images upload if any
            if ($request->hasFile('project_images')) {
                $this->handleProjectImagesUpload($request->file('project_images'), $model->id);
            }

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $project)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            // Prepare main data (non-translatable fields)
            $mainData = [
                'category_id' => $data['category_id'] ?? $project->category_id,
                'parent_id' => $data['parent_id'] ?? $project->parent_id,
                'alt_image' => $data['alt_image'] ?? $project->alt_image,
                'alt_icon' => $data['alt_icon'] ?? $project->alt_icon,
                'status' => $data['status'] ?? $project->status,
                'show_in_home' => $data['show_in_home'] ?? $project->show_in_home,
                'show_in_header' => $data['show_in_header'] ?? $project->show_in_header,
                'show_in_footer' => $data['show_in_footer'] ?? $project->show_in_footer,
                'index' => $data['index'] ?? $project->index,
                'order' => $data['order'] ?? $project->order,
                'clients' => $data['clients'] ?? $project->clients,
                'location' => $data['location'] ?? $project->location,
                'category' => $data['category'] ?? $project->category,
                'service' => $data['service'] ?? $project->service,
                'date' => $data['date'] ?? $project->date,
            ];

            // Handle file uploads
            if ($request->hasFile('image')) {
                if ($project->image) {
                    Media::removeFile('projects', $project->image);
                }
                $mainData['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'projects');
            }
            if ($request->hasFile('icon')) {
                if ($project->icon) {
                    Media::removeFile('projects', $project->icon);
                }
                $mainData['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'projects');
            }

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('project');

            // Update model with JSON translations
            JsonTranslationService::updateWithTranslations($project, $mainData, $request, $translationFields);

            // Handle project images upload if any
            if ($request->hasFile('project_images')) {
                $this->handleProjectImagesUpload($request->file('project_images'), $project->id);
            }

            DB::commit();
            return $project;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function handleProjectImagesUpload($files, $projectId)
    {
        foreach ($files as $file) {
            $imagePath = Media::uploadAndAttachImageStorage($file, 'projects');
            ProjectImage::create([
                'project_id' => $projectId,
                'image' => $imagePath,
                'order' => 0
            ]);
        }
    }
}
