<?php

namespace App\Services\Dashboard;

use App\Helper\Media;
use App\Models\Author;
use Illuminate\Support\Facades\DB;

class AuthorService
{
    public function store($request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
           

            if ($request->hasFile('image')) {
                $data['image'] = Media::uploadAndAttachImage($request->file('image'), 'authors');
            }
           
            $author = Author::create($data);


            DB::commit();
            return $author;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($request, $author)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $data['status'] = $data['status'] ?? 0;
            

            if ($request->hasFile('image')) {
                if ($author->image) {
                    Media::removeFile('authors', $author->image);
                }
                $data['image'] = Media::uploadAndAttachImage($request->file('image'), 'authors');
            }

           

            $author->update($data);

            DB::commit();
            return $author;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function delete($selectedIds)
    {
        $authors = Author::whereIn('id', $selectedIds)->get();

        DB::beginTransaction();
        try {
            foreach ($authors as $author) {
                // Delete associated image if it exists
                if ($author->image) {
                    Media::removeFile('authors', $author->image);
                }
                // Delete associated Icon if it exists
                if ($author->icon) {
                    Media::removeFile('authors', $author->icon);
                }
            }
            $deleted = author::whereIn('id', $selectedIds)->delete();

            DB::commit();

            return $deleted > 0;
        } catch (\Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }
}
