<?php

namespace App\Services\Dashboard;

use App\Models\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PageService
{
    /**
     * Clean Arabic text for slug usage
     * Keep Arabic characters but remove special characters and spaces
     */
    private function cleanArabicSlug($text)
    {
        // Replace spaces and special characters with dashes, but keep Arabic characters
        $slug = str_replace([' ', '/', '\\', '?', '#', '[', ']', '@', '!', '$', '&', "'", '(', ')', '*', '+', ',', ';', '=', '%'], '-', $text);

        // Remove multiple dashes
        $slug = preg_replace('/-+/', '-', $slug);

        // Remove leading/trailing dashes
        $slug = trim($slug, '-');

        return $slug;
    }

    public function store($request)
    {
        $data = $request->validated();
       
        DB::beginTransaction();
        try {
            // Handle file uploads
            if ($request->hasFile('image')) {
                $data['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'pages');
            }
            if ($request->hasFile('icon')) {
                $data['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'pages');
            }

            // Prepare main model data
            $mainData = $data;

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('page');

            // Create model with JSON translations
            $model = JsonTranslationService::createWithTranslations(Page::class, $mainData, $request, $translationFields);

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

            DB::commit();
            return $page;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    } catch (\Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    public function update($request, $model)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            // Handle file uploads
            if ($request->hasFile('image')) {
                if ($model->image) {
                    Media::removeFile('pages', $model->image);
                }
                $data['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'pages');
            }

            if ($request->hasFile('icon')) {
                if ($model->icon) {
                    Media::removeFile('pages', $model->icon);
                }
                $data['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'pages');
            }

            // Prepare main model data
            $mainData = $data;

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('page');

            // Update model with JSON translations
            $model = JsonTranslationService::updateWithTranslations($model, $mainData, $request, $translationFields);

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

            DB::commit();
            return $page;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($selectedIds)
    {

        DB::beginTransaction();

        try {

            $deleted = Page::whereIn('id', $selectedIds)->delete();

            DB::commit();

            return $deleted > 0;
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
