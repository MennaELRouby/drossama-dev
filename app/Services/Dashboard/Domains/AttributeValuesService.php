<?php

namespace App\Services\Dashboard\Domains;

use App\Models\Dashboard\AttributeValue;

class AttributeValuesService
{
    public function store($data, $attribute)
    {
        try {
            $data['attribute_id'] = $attribute->id;

            return AttributeValue::create($data);
        } catch (\Exception $e) {

            return false;
        }
    }

    public function update($data, $attribute, $value)
    {
        try {
            $data['status'] = $data['status'] ?? 0;

            return  $value->update($data);
        } catch (\Exception $e) {

            return false;
        }
    }

    public function destory($value)
    {
        try {
            return $value->delete();

        } catch (\Exception $e) {

            return false;
        }
    }
}
