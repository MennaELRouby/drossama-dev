<?php

namespace App\Services\Dashboard;

use App\Helper\Media;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogCategoryService
{
    public function store($request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            $data['slug_ar'] = preg_replace('/\s+/u', '-', trim($data['name_ar']));
            $data['slug_ar'] = preg_replace('/[^\p{L}\p{N}_-]+/u', '', $data['slug_ar']);
            $data['slug_en'] = Str::slug($data['name_en']);
       

            if ($request->hasFile('image')) {
                $data['image'] = Media::uploadAndAttachImage($request->file('image'), 'blog_categories');
            }
            if ($request->hasFile('icon')) {
                $data['icon'] = Media::uploadAndAttachImage($request->file('icon'), 'blog_categories');
            }
            $blog_category = BlogCategory::create($data);


            DB::commit();
            return $blog_category;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($request, $blog_category)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $data['status'] = $data['status'] ?? 0;
            $data['show_in_home'] = $data['show_in_home'] ?? 0;
            $data['show_in_header'] = $data['show_in_header'] ?? 0;
            $data['show_in_footer'] = $data['show_in_footer'] ?? 0;
            $data['index'] = $data['index'] ?? 0;
            $data['slug_ar'] = preg_replace('/\s+/u', '-', trim($data['slug_ar']));
            $data['slug_ar'] = preg_replace('/[^\p{L}\p{N}_-]+/u', '', $data['slug_ar']);
            $data['slug_en'] = Str::slug($data['slug_en']);

            if ($request->hasFile('image')) {
                if ($blog_category->image) {
                    Media::removeFile('blog_categories', $blog_category->image);
                }
                $data['image'] = Media::uploadAndAttachImage($request->file('image'), 'blog_categories');
            }

            if ($request->hasFile('icon')) {
                if ($blog_category->icon) {
                    Media::removeFile('blog_categories', $blog_category->icon);
                }
                $data['icon'] = Media::uploadAndAttachImage($request->file('icon'), 'blog_categories');
            }

            $blog_category->update($data);

            DB::commit();
            return $blog_category;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    public function delete($selectedIds) 
    {
     $blog_categories = BlogCategory::whereIn('id', $selectedIds)->get();
 
         DB::beginTransaction();
         try {
             foreach ($blog_categories as $blog_category) {
                 // Delete associated image if it exists
                 if ($blog_category->image) {
                     Media::removeFile('blog_categories', $blog_category->image);
                 }
                 // Delete associated Icon if it exists
                 if ($blog_category->icon) {
                     Media::removeFile('blog_categories', $blog_category->icon);
                 }
             }
             $deleted = BlogCategory::whereIn('id', $selectedIds)->delete();
 
             DB::commit();
 
             return $deleted > 0;
 
         } catch (\Exception $e) {
           
             DB::rollBack();
 
             throw $e;
         }
     
    }
 

}
