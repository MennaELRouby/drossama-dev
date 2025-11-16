<?php

namespace App\Services\Dashboard;

use App\Models\Album;
use Illuminate\Support\Facades\DB;
use App\Helper\Media;

class AlbumService
{
    public function store($request, $data)
    {
        DB::beginTransaction();
        try {
            $album = Album::create($data);
             if ($request->hasFile('image')) {
                $path = Media::uploadAndAttachImageStorage($request->file('image'), 'albums');
                $album->update(['image' => $path]);
            }

            if ($request->hasFile('icon')) {
                $path = Media::uploadAndAttachImageStorage($request->file('icon'), 'albums');
                $album->update(['icon' => $path]);
            }
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
             if ($request->hasFile('image')) {
                $data['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'albums');
            }

            if ($request->hasFile('icon')) {
                $data['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'albums');
            }
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
