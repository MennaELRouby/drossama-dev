<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Attributes\StoreAttributeValues;
use App\Models\Dashboard\Attribute;
use App\Models\Dashboard\AttributeValue;
use App\Services\Dashboard\Domains\AttributeValuesService;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    protected $attributeValueService;
    public function __construct(AttributeValuesService $attributeValuesService)
    {
        $this->attributeValueService =  $attributeValuesService;
    }
    public function create(Attribute $attribute)
    {
        
        return view('Dashboard.Attribute-values.create', compact('attribute'));
    }
    public function store(StoreAttributeValues $request, Attribute $attribute)
    {
        try {
            $data = $request->validated();

            $result = $this->attributeValueService->store($data, $attribute);

            if ($result) {
                return redirect()->route('dashboard.attributes.edit', [$attribute->id])
                    ->with(['success' => __('dashboard.values_added_successfully')]);
            }

            return redirect()->route('dashboard.attributes.edit', [$attribute->id])->with(['error' => __('dashboard.failed_to_add_values')]);
        } catch (\Exception $e) {

            return redirect()->back()->with(['error' => __('dashboard.failed_to_add_values_for_this_attribute')]);
        }
    }


    public function update(StoreAttributeValues $request, Attribute $attribute, AttributeValue $value)
    {


        try {

            $data = $request->all();

            $this->attributeValueService->update($data, $attribute, $value);

            return redirect()->back()->with(['success' => __('dashboard.your_item_updated_successfully')]);
        } catch (\Exception $e) {

            return redirect()->back()->with(['error' => __('dashboard.failed_to_update_item')]);
        }
    }

    public function destroy(Attribute $attribute, AttributeValue $value)
    {
        try {
            $this->attributeValueService->destory($value);

            return redirect()->back()->with(['success' => __('dashboard.your_items_deleted_successfully')]);

        } catch (\Exception $e) {

            return redirect()->back()->with(['error' => __('dashboard.failed_to_deleted_item')]);

        }
    }
}
