<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\Media;
use App\Http\Controllers\Controller;
use App\Models\CareerApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CareerApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('career_applications.view');

        $applications = CareerApplication::with('jobPosition')->orderBy('created_at', 'desc')->get();

        return view('Dashboard.CareerApplications.index', compact('applications'));
    }


    /**
     * Display the specified resource.
     */
    public function show(CareerApplication  $application)
    {
        $this->authorize('career_applications.show');
        $application->load('jobPosition');
        $application->update(['seen' => true]);

        return view('Dashboard.CareerApplications.show', compact('application'));
    }

    public function downloadCV(CareerApplication $application)
    {
        $this->authorize('career_applications.download.cv');

        if ($application->cv) {
            if (Storage::disk('public')->exists($application->cv_path)) {
                return Storage::disk('public')->download($application->cv_path);
            }
            // Debugging Information
            // \Log::error('CV not found at path: ' . $application->cv_path);
            return redirect()->back()->with('error', __('dashboard.cv_not_found') . ' — Path: ' . $application->cv_path);
        }

        return redirect()->back()->with('error', __('dashboard.cv_not_found'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $this->authorize('career_applications.delete');
    
        // Validate the request
        $request->validate([
            'selectedIds' => 'required|array|min:1',
            'selectedIds.*' => 'integer|exists:career_applications,id',
        ]);
    
        $selectedIds = $request->input('selectedIds');
    
        DB::beginTransaction();
        try {
            // Retrieve the applications to delete
            $applications = CareerApplication::whereIn('id', $selectedIds)->get();

            foreach ($applications as $application) {
                // Delete associated CV file if it exists
                if ($application->cv) {
                    Media::removeFile('career-applications',$application->cv);
                }
            }
    
            // Delete the applications
            $deleted = CareerApplication::whereIn('id', $selectedIds)->delete();
    
            DB::commit();
    
            // Handle AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => __('dashboard.your_items_deleted_successfully'),
                ]);
            }
    
            // Redirect for non-AJAX requests
            return redirect()->route('dashboard.career_applications.index')
                ->with('success', __('dashboard.your_items_deleted_successfully'));
    
        } catch (\Exception $e) {
            DB::rollBack();
    
            // Log the error for debugging
            Log::error('Error deleting career applications: ' . $e->getMessage());
    
            // Handle AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => __('dashboard.an_error_occurred'),
                ], 500);
            }
    
            // Redirect for non-AJAX requests
            return redirect()->back()
                ->withErrors(__('dashboard.an_error_occurred'));
        }
    }

 
}
