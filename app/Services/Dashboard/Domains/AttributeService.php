<?php

namespace App\Services\Dashboard\Domains;

use App\Helper\Media;
use App\Models\Dashboard\Attribute;
use Illuminate\Support\Facades\DB;

class AttributeService
{

    public function store($request, $data)
    {

        DB::beginTransaction();
        try {

            if ($request->hasFile('icon')) {
                $data['icon'] =  Media::uploadAndAttachImage($request->file('icon'),  'attributes');
            }
            Attribute::create($data);

            DB::commit();

            return true;
        } catch (\Exception $e) {

            DB::rollBack();

            return false;
        }
    }

    public function update($request, $data, $attribute)
    {

        DB::beginTransaction();
        try {
            $data['status'] = $data['status'] ?? 0;
            $data['index'] = $data['index'] ?? 0;


            if ($request->hasFile('icon')) {
                if ($attribute->icon) {
                    Media::removeFile('attributes', $attribute->icon);
                }
                $data['icon'] =   Media::uploadAndAttachImage($request->file('icon'),  'attributes');
            }

            $attribute->update($data);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function delete($selectedIds)
    {

        $attributes = Attribute::whereIn('id', $selectedIds)->get();

        DB::beginTransaction();

        try {
            foreach ($attributes as $attribute) {
                // Delete associated image if it exists
                if ($attribute->image) {
                    Media::removeFile('attributes', $attribute->image);
                }
            }
            $deleted = Attribute::whereIn('id', $selectedIds)->delete();

            DB::commit();

            return $deleted > 0;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
