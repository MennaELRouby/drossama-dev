<?php

namespace App\Services\Dashboard;

use App\Models\Album;
use Illuminate\Support\Facades\DB;

class AlbumService
{
    public function store($request, $data)
    {
        DB::beginTransaction();
        try {
            $album = Album::create($data);
            DB::commit();
            return $album;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $data, $album)
    {
        DB::beginTransaction();
        try {
            $album->update($data);
            DB::commit();
            return $album;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($selectedIds, $data = null)
    {
        // Handle if selectedIds is null or empty
        if (empty($selectedIds)) {
            return false;
        }

        // Ensure selectedIds is an array
        if (!is_array($selectedIds)) {
            $selectedIds = [$selectedIds];
        }

        $albums = Album::whereIn('id', $selectedIds)->get();

        if ($albums->isEmpty()) {
            return false;
        }

        DB::beginTransaction();
        try {
            foreach ($albums as $album) {
                // Delete associated images
                $images = \App\Models\AlbumImage::where('album_id', $album->id)->get();
                foreach ($images as $image) {
                    if ($image->image && file_exists(public_path('storage/albums/' . $image->image))) {
                        unlink(public_path('storage/albums/' . $image->image));
                    }
                }
                \App\Models\AlbumImage::where('album_id', $album->id)->delete();

                // Delete the album
                $album->delete();
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
