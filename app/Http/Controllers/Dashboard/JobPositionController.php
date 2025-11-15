<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\JobPositions\DeleteJobPositionRequest;
use App\Http\Requests\Dashboard\JobPositions\StoreJobPositionRequest;
use App\Http\Requests\Dashboard\JobPositions\UpdateJobPositionRequest;
use App\Models\JobPosition;
use App\Services\Dashboard\JobPositionService;
use Illuminate\Console\Application;
use Illuminate\Http\Request;

class JobPositionController extends Controller
{

    protected $service;

    public function __construct(JobPositionService $service)
    {
        $this->service = $service;
    }
    /**
     *
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('job_positions.view');

        $jobPositions = JobPosition::orderBy('created_at', 'desc')->get();

        return view('Dashboard.JobPositions.index', compact('jobPositions'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('job_positions.create');

        return view('Dashboard.JobPositions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobPositionRequest $request)
    {
       $this->authorize('job_positions.store');
        try {
            $response = $this->service->store($request);
            if (!$response) {
                return redirect()->back()->with(['error' => __('dashboard.failed_to_create_item')]);
            }
            return redirect()->route('dashboard.job_positions.index')->with(['success' => __('dashboard.your_item_created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobPosition $job_position)
    {
        $this->authorize('job_positions.edit');

        return view('Dashboard.JobPositions.edit', compact('job_position'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobPositionRequest $request, JobPosition $job_position)
    {
      
        $this->authorize('job_positions.update');
        try {
            $response = $this->service->update($request, $job_position);
            if (!$response) {
                return redirect()->back()->with(['error' => __('dashboard.failed_to_update_item')]);
            }
            return redirect()->route('dashboard.job_positions.index')->with(['success' => __('dashboard.your_item_updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteJobPositionRequest $request, string $id)
    {
        $this->authorize('job_positions.delete');

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
