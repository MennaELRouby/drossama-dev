<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Attributes\StoreAttribute;
use App\Models\Dashboard\Attribute;
use App\Services\Dashboard\Domains\AttributeService;

use Illuminate\Http\Request;

class AttributeController extends Controller
{

    protected $attributeService;
    public function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
    }
    public function index()
    {
        $this->authorize('attributes.view');
       $attributes =  Attribute::all();
        return view('Dashboard.Attributes.index',compact('attributes'));
    }

    public function create()
    {

        $this->authorize('attributes.create');
        return view('Dashboard.Attributes.create');
    }

    public function store(StoreAttribute $request)
    {

        $this->authorize('attributes.store');
        try {
            $data  = $request->validated();
            $response = (new AttributeService())->store($request,$data);
            if ($response) {
                return redirect()->back()->with(['success' => __('dashboard.your_item_added_successfully')]);
            } else {
                return redirect()->back()->with(['error' => __('dashboard.failed_to_add_item')]);
            }

        } catch (\Exception $e) {

            return redirect()->back()->with(['error' => __('dashboard.failed_to_add_item')]);

        }
    }

    public function edit(Attribute $attribute)
    {

        $this->authorize('attributes.edit');
        return view('Dashboard.Attributes.edit',compact('attribute'));
    }

    public function update(StoreAttribute $request ,Attribute $attribute)
    {

        $this->authorize('attributes.update');
        try {
            $data  = $request->validated();

            $this->attributeService->update( $request,$data,$attribute);

            return redirect()->back()->with(['success' => __('dashboard.your_item_updated_successfully')]);

        } catch (\Exception $e) {

            return redirect()->back()->with(['error' => __('dashboard.failed_to_updated_item')]);

        }
    }

    public function destroy(Request $request , Attribute $attribute)
    {

        $this->authorize('attributes.delete');
        $selectedIds = $request->input('selectedIds');

        $request->validate([
            'selectedIds' => ['array', 'min:1'],
            'selectedIds.*' => ['exists:attributes,id']
        ]);

        try {
            $this->attributeService->delete($selectedIds);

            return redirect()->back()->with(['success' => __('dashboard.your_items_deleted_successfully')]);

        } catch (\Exception $e) {

            return redirect()->back()->with(['error' => __('dashboard.failed_to_deleted_item')]);

        }


    }
}
