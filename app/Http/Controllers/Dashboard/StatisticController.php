<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Statistics\DeleteStatisticRequest;
use App\Http\Requests\Dashboard\Statistics\StoreStatisticRequest;
use App\Http\Requests\Dashboard\Statistics\UpdateStatisticRequest;
use App\Models\Statistic;
use App\Services\Dashboard\StatisticService;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    protected $service;

    public function __construct(StatisticService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $this->authorize('statistics.view');

        $statistics = Statistic::get();

        return view('Dashboard.Statistics.index', compact('statistics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('statistics.create');

        return view('Dashboard.Statistics.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStatisticRequest $request)
    {
        try {
            $this->authorize('statistics.create');
            $this->service->store($request);
            return redirect()->route('dashboard.statistics.index')->with('success', __('dashboard.your_items_added_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Statistic $statistic)
    {
        $this->authorize('statistics.edit');

        return view('Dashboard.Statistics.edit', compact('statistic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStatisticRequest $request, Statistic $statistic)
    {
        try {

            $this->authorize('statistics.edit');

            $this->service->update($request, $statistic);

            return redirect()->route('dashboard.statistics.index')->with('success', __('dashboard.your_items_updated_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteStatisticRequest $request, string $id)
    {
        $this->authorize('statistics.delete');

        $selectedIds = $request->input('selectedIds');

        $data = $request->validated();

        $deleted = $this->service->delete($selectedIds, $data);


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
