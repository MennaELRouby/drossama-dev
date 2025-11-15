<?php

namespace App\Services\Dashboard;

use App\Helper\Media;
use App\Models\Blog;
use App\Services\JsonTranslationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogService
{
    public function store($request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            // Handle file uploads
            if ($request->hasFile('image')) {
                $data['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'blogs');
            }
            if ($request->hasFile('icon')) {
                $data['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'blogs');
            }

            // Prepare main model data
            $mainData = [
                'category_id' => $data['category_id'] ?? null,
                'author_id' => $data['author_id'] ?? null,
                'image' => $data['image'] ?? null,
                'alt_image' => $data['alt_image'] ?? null,
                'icon' => $data['icon'] ?? null,
                'alt_icon' => $data['alt_icon'] ?? null,
                'status' => $data['status'] ?? 0,
                'show_in_home' => $data['show_in_home'] ?? 0,
                'show_in_header' => $data['show_in_header'] ?? 0,
                'show_in_footer' => $data['show_in_footer'] ?? 0,
                'index' => $data['index'] ?? 0,
                'date' => !empty($data['date']) && $data['date'] !== '' ? $data['date'] : now(),
                'order' => $data['order'] ?? 0,
            ];

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('blog');

            // Create model with JSON translations
            $blog = JsonTranslationService::createWithTranslations(Blog::class, $mainData, $request, $translationFields);

            DB::commit();
            return $blog;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $blog)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            // Handle file uploads
            if ($request->hasFile('image')) {
                if ($blog->image) {
                    Media::removeFile('blogs', $blog->image);
                }
                $data['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'blogs');
            }

            if ($request->hasFile('icon')) {
                if ($blog->icon) {
                    Media::removeFile('blogs', $blog->icon);
                }
                $data['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'blogs');
            }

            // Prepare main model data
            $mainData = [
                'category_id' => $data['category_id'] ?? $blog->category_id,
                'author_id' => $data['author_id'] ?? $blog->author_id,
                'image' => $data['image'] ?? $blog->image,
                'alt_image' => $data['alt_image'] ?? $blog->alt_image,
                'icon' => $data['icon'] ?? $blog->icon,
                'alt_icon' => $data['alt_icon'] ?? $blog->alt_icon,
                'status' => $data['status'] ?? $blog->status,
                'show_in_home' => $data['show_in_home'] ?? $blog->show_in_home,
                'show_in_header' => $data['show_in_header'] ?? $blog->show_in_header,
                'show_in_footer' => $data['show_in_footer'] ?? $blog->show_in_footer,
                'index' => $data['index'] ?? $blog->index,
                'date' => !empty($data['date']) && $data['date'] !== '' ? $data['date'] : null,
                'order' => $data['order'] ?? $blog->order,
            ];

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('blog');

            // Update model with JSON translations
            $blog = JsonTranslationService::updateWithTranslations($blog, $mainData, $request, $translationFields);

            DB::commit();
            return $blog;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public function delete($selectedIds)
    {
        $blogs = Blog::whereIn('id', $selectedIds)->get();

        DB::beginTransaction();
        try {
            foreach ($blogs as $blog) {
                // Delete associated image if it exists
                if ($blog->image) {
                    Media::removeFile('blogs', $blog->image);
                }

                // Delete associated Icon if it exists
                if ($blog->icon) {
                    Media::removeFile('blogs', $blog->icon);
                }

                // Delete the blog model (this triggers the observer)
                $blog->delete();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
