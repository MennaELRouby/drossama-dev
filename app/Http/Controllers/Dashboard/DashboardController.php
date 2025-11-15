<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $this->authorize('dashboard.view');

        // Get the count of each model
        $countModels = $this->dashboardService->countModels();

        return view('Dashboard.index', compact('countModels'));
    }

    public function changeStatus(Request $request)
    {
        $selectedIds = $request->input('selectedIds');

        $model = $request->input('modelName');

        $updated =  $this->dashboardService->changeStatus($model, $selectedIds);

        if ($updated) {
            // Set a flash message in the session
            session()->flash('success', __('status updated successfully'));

            return response()->json(['success' => true, 'message' => __('status updated successfully')]);
        } else {
            return response()->json(['success' => false, 'message' => __('status update failed')]);
        }
    }
}
