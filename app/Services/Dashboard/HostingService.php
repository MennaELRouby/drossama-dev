<?php

namespace App\Services\Dashboard;

use App\Helper\Media;
use App\Models\Dashboard\Hosting;
use Illuminate\Support\Facades\DB;

class HostingService
{

    public function store($request,$dataValidated)
    {
        DB::beginTransaction();

        try {
            // Generate slugs
            $dataValidated['slug_ar'] = preg_replace('/[\/\\\ ]/', '-', $dataValidated['name_ar']);
            $dataValidated['slug_en'] = preg_replace('/[\/\\\ ]/', '-', $dataValidated['name_en']);

            if ($request->hasFile('image')) {
                $dataValidated['image'] = Media::uploadAndAttachImage($request->file('image'), 'hostings');
            }

            if($request->hasFile('icon')) {
                $dataValidated['icon'] = Media::uploadAndAttachImage($request->file('icon'), 'hostings');
            }

            // Create the hosting
            Hosting::create($dataValidated);

            DB::commit();

            return true;
        } catch (\Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    public function update($request, $dataValidated, $hosting)
    {
        DB::beginTransaction();

        try{
            $dataValidated['status'] = $dataValidated['status'] ?? 0;
            $dataValidated['index'] = $dataValidated['index'] ?? 0;



            if ($request->hasFile('icon')) {
                if ($hosting->icon) {
                    Media::removeFile('hostings', $hosting->icon);
                }
                $dataValidated['icon'] = Media::uploadAndAttachImage($request->file('icon'), 'hostings');
            }
            if ($request->hasFile('image')) {
                if ($hosting->image) {
                    Media::removeFile('hostings', $hosting->image);
                }
                $dataValidated['image'] = Media::uploadAndAttachImage($request->file('image'), 'hostings');
            }

            $hosting->Update($dataValidated);

            DB::commit();
            return true;

        }catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

    }

    public function deletehostings($selectedIds)
    {
        $hostings = Hosting::whereIn('id', $selectedIds)->get();

        DB::beginTransaction();
        try {
            foreach ($hostings as $hosting) {
                // Delete associated image if it exists
                if ($hosting->image) {
                    Media::removeFile('hostings', $hosting->image);
                }
                // Delete associated Icon if it exists
                if ($hosting->icon) {
                    Media::removeFile('hostings', $hosting->icon);
                }
            }
            $deleted = Hosting::whereIn('id', $selectedIds)->delete();

            DB::commit();

            return $deleted > 0;

        } catch (\Exception $e) {

            DB::rollBack();

            return false;
        }
    }
}
