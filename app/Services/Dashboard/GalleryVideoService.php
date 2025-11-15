<?php

namespace App\Services\Dashboard;

use App\Helper\Media;
use App\Models\GalleryVideo;
use Illuminate\Support\Facades\DB;

class GalleryVideoService
{
      public function store($request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {

            if ($request->hasFile('image')) {
                $data['image'] = Media::uploadAndAttachImage($request->file('image'), 'gallery_videos');
            }
            if ($request->hasFile('icon')) {
                $data['icon'] = Media::uploadAndAttachImage($request->file('icon'), 'gallery_videos');
            }
            $galleryVideo = GalleryVideo::create($data);


            DB::commit();
            return $galleryVideo;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

      public function update($request, $gallery_video)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $data['status'] = $data['status'] ?? 0;


            if ($request->hasFile('image')) {
                if ($gallery_video->image) {
                    Media::removeFile('gallery_videos', $gallery_video->image);
                }
                $data['image'] = Media::uploadAndAttachImage($request->file('image'), 'gallery_videos');
            }

            if ($request->hasFile('icon')) {
                if ($gallery_video->icon) {
                    Media::removeFile('gallery_videos', $gallery_video->icon);
                }
                $data['icon'] = Media::uploadAndAttachImage($request->file('icon'), 'gallery_videos');
            }

            $gallery_video->update($data);

            DB::commit();
            return $gallery_video;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function delete($selectedIds)
    {
        $gallery_videos = GalleryVideo::whereIn('id', $selectedIds)->get();

        DB::beginTransaction();
        try {
            foreach ($gallery_videos as $gallery_video) {
                // Delete associated image if it exists
                if ($gallery_video->image) {
                    Media::removeFile('gallery_videos', $gallery_video->image);
                }
                // Delete associated Icon if it exists
                if ($gallery_video->icon) {
                    Media::removeFile('gallery_videos', $gallery_video->icon);
                }
            }
            $deleted = GalleryVideo::whereIn('id', $selectedIds)->delete();

            DB::commit();

            return $deleted > 0;
        } catch (\Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }
}
