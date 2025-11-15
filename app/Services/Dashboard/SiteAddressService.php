<?php

namespace App\Services\Dashboard;

use App\Models\SiteAddress;
use Illuminate\Support\Facades\DB;

class SiteAddressService
{
    /**
     * Create a new class instance.
     */
    public function store($data)
    {
        DB::beginTransaction();

        try {
            // Handle multilingual fields - convert from separate fields to JSON
            $multilingualFields = ['title', 'address'];
            foreach ($multilingualFields as $field) {
                if (isset($data[$field . '_en']) || isset($data[$field . '_ar'])) {
                    $fieldData = [];
                    if (isset($data[$field . '_en'])) {
                        $fieldData['en'] = $data[$field . '_en'];
                        unset($data[$field . '_en']);
                    }
                    if (isset($data[$field . '_ar'])) {
                        $fieldData['ar'] = $data[$field . '_ar'];
                        unset($data[$field . '_ar']);
                    }
                    $data[$field] = json_encode($fieldData, JSON_UNESCAPED_UNICODE);
                }
            }

            $data['phone'] = $data['code'] . $data['phone'];
            $data['phone2'] = $data['code2'] . $data['phone2'];

            // Create the SiteAddress
            SiteAddress::create($data);

            DB::commit();

            return true;
        } catch (\Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    public function update($data, $site_address)
    {
        DB::beginTransaction();

        try {
            // Handle multilingual fields - convert from separate fields to JSON
            $multilingualFields = ['title', 'address'];
            foreach ($multilingualFields as $field) {
                if (isset($data[$field . '_en']) || isset($data[$field . '_ar'])) {
                    $fieldData = [];
                    if (isset($data[$field . '_en'])) {
                        $fieldData['en'] = $data[$field . '_en'];
                        unset($data[$field . '_en']);
                    }
                    if (isset($data[$field . '_ar'])) {
                        $fieldData['ar'] = $data[$field . '_ar'];
                        unset($data[$field . '_ar']);
                    }
                    $data[$field] = json_encode($fieldData, JSON_UNESCAPED_UNICODE);
                }
            }

            $data['status'] = $data['status'] ?? 0;
            $data['phone'] = $data['code'] . $data['phone'];
            $data['phone2'] = $data['code2'] . $data['phone2'];


            $site_address->update($data);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($selectedIds)
    {
        // Validate selectedIds is not empty
        if (empty($selectedIds) || !is_array($selectedIds)) {
            return false;
        }

        DB::beginTransaction();
        try {
            $deleted = SiteAddress::whereIn('id', $selectedIds)->delete();

            DB::commit();

            return $deleted > 0;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
