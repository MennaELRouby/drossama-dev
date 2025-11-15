<?php

namespace App\Services\Dashboard;

use App\Helper\Media;
use App\Models\Partener;
use Illuminate\Support\Facades\DB;

class PartenerService
{
    public function store($request)
    {

        DB::beginTransaction();
        try {

            $data = $request->validated();

            if ($request->hasFile('logo')) {
                $data['logo'] = Media::uploadAndAttachImageStorage($request->file('logo'), 'parteners');
            }

            $partener = Partener::create($data);

            // Sync products if provided
            if ($request->has('products')) {
                $partener->products()->sync($request->products);
            }

            DB::commit();

            return $partener;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $partener)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {

            $data['status'] = $data['status'] ?? 0;
            if ($request->hasFile('logo')) {
                if ($partener->logo) {
                    Media::removeFile('parteners', $partener->logo);
                }
                $data['logo'] = Media::uploadAndAttachImageStorage($request->file('logo'), 'parteners');
            }

            $partener->update($data);

            // Sync products if provided
            if ($request->has('products')) {
                $partener->products()->sync($request->products);
            }

            DB::commit();
            return $partener;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($selectedIds)
    {
        $parteners = Partener::whereIn('id', $selectedIds)->get();

        DB::beginTransaction();
        try {
            foreach ($parteners as $partener) {
                // Delete associated logo if it exists
                if ($partener->logo) {
                    Media::removeFile('parteners', $partener->logo);
                }
            }
            $deleted = Partener::whereIn('id', $selectedIds)->delete();

            DB::commit();

            return $deleted > 0;
        } catch (\Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }
}
