<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Plans\StorePlanRequest;
use App\Models\Dashboard\Attribute;
use App\Models\Dashboard\Category;
use App\Models\Dashboard\Hosting;
use App\Models\Dashboard\Plan;
use App\Services\Dashboard\Domains\PlanService;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    protected $planService;

    public function __construct(PlanService $planService)
    {
        $this->planService = $planService;
    }
    public function index()
    {
        $this->authorize('plans.view');
        $plans = Plan::with('hosting')->get();

        return view('Dashboard.Plans.index', compact('plans'));
    }

    public function create()
    {
        $this->authorize('plans.create');

        $data['hostings'] = Hosting::all();
        $data['attributes'] = Attribute::all();

        return view('Dashboard.Plans.create', $data);
    }

    public function store(StorePlanRequest $request)
    {
        $this->authorize('plans.store');

        try {
            $data = $request->validated();

            $response = (new PlanService())->store($request);

            if ($response) {
                return redirect()->back()->with(['success' => __('dashboard.your_item_added_successfully')]);
            } else {
                return redirect()->back()->with(['error' => __('dashboard.failed_to_add_item')]);
            }
        } catch (\Exception $e) {

            return redirect()->back()->with(['error' => __('dashboard.failed_to_add_item')]);
        }
    }

    public function edit(Plan $plan)
    {
        $this->authorize('plans.edit');

        $data['plan'] = $plan;
        $data['hostings'] = Hosting::all();
        $data['attributes'] = Attribute::all();
        $data['selectedPlanAttributesIDS'] = $plan->planAttributes->pluck('attribute_id')->toArray();

        return view('Dashboard.Plans.edit', $data);
    }

    public function update(Request $request, Plan $plan)
    {
        $this->authorize('plans.update');

        try {
            $data = $request->all();

            $this->planService->update($request, $data, $plan);

            return redirect()->back()->with(['success' => __('dashboard.your_item_updated_successfully')]);
        } catch (\Exception $e) {

            return redirect()->back()->with(['error' => __('dashboard.failed_to_update_item')]);
        }
    }

    public function createPlanAttributeValues(Plan $plan)
    {



        $plan->load([
            'planAttributes.attribute.values', // include values too
            'attributeValues' // for selected options
        ]);

        return view('Dashboard.Plans.create-plan-attribute-values', compact('plan'));
    }


    public function storeAttributeValues(Request $request, Plan $plan)
    {


        try {

            $this->planService->storeAttributeValues($request, $plan);

            return redirect()->back()->with(['success' => __('dashboard.your_item_updated_successfully')]);
        } catch (\Exception $e) {

            return redirect()->back()->with(['error' => __('dashboard.failed_to_update_item')]);
        }
    }


    public function destroy(Request $request)
    {
        $this->authorize('plans.delete');
        $deleted = $this->planService->deletePlan($request);

        if (request()->ajax()) {
            if (!$deleted) {
                return response()->json(['message' => $deleted ?? __('dashboard.an messages.error entering data')], 422);
            }
            return response()->json(['success' => true, 'message' => __('dashboard.your_items_deleted_successfully')]);
        }
        if (!$deleted) {
            return redirect()->back()->withErrors($delete ?? __('dashboard.an error has occurred. Please contact the developer to resolve the issue'));
        }
    }
}
