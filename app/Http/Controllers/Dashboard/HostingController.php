<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Benefits\DeleteBenefitRequest;
use App\Http\Requests\Dashboard\Benefits\StoreBenefitRequest;
use App\Http\Requests\Dashboard\Hostings\StoreHostingRequest;
use App\Http\Requests\Dashboard\Hostings\UpdateHostingRequest;
use App\Models\Dashboard\Hosting;
use App\Services\Dashboard\BenefitService;
use App\Services\Dashboard\HostingService;
use Illuminate\Http\Request;

class HostingController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('hostings.view');

        $hostings = Hosting::with('parentHosting')->orderBy('id','desc')->get();

        return view('Dashboard.Hostings.index', compact('hostings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $this->authorize('hostings.create');

        $hostings = Hosting::with('parentHosting')->get();
        return view('Dashboard.Hostings.create', compact('hostings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHostingRequest $request)
    {

        $this->authorize('hostings.store');

        try {
            $dataValidated = $request->validated();

            $response = (new HostingService())->store($request, $dataValidated);

            if(!$response) {
                return redirect()->back()->with(['error' => __('dashboard.failed_to_add_item')]);
            }

            return redirect()->back()->with(['success' => __('dashboard.your_item_added_successfully')]);
        } catch (\Exception $e) {

            return redirect()->back()->with(['error' => __('dashboard.failed_to_add_item')]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hosting $hosting)
    {
        $this->authorize('hostings.edit');

        $hostings = Hosting::with('parentHosting')->get();
        return view('Dashboard.Hostings.edit', compact('hosting', 'hostings'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateHostingRequest $request, Hosting $hosting)
    {

        $this->authorize('hostings.update');

        try {
            $dataValidated = $request->validated();

            $response = (new HostingService())->update($request, $dataValidated, $hosting);
            if(!$response) {
                return redirect()->back()->with(['error' => __('dashboard.failed_to_update_item')]);
            }

            return redirect()->back()->with(['success' => __('dashboard.your_item_updated_successfully')]);
        } catch (\Exception $e) {

            return redirect()->back()->with(['error' => __('dashboard.failed_to_update_item')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteBenefitRequest $request, string $id)
    {
        $this->authorize('hostings.delete');

        $selectedIds = $request->input('selectedIds');

        $data = $request->validated();

        $deleted = (new HostingService())->deletehostings($selectedIds,$data);


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
