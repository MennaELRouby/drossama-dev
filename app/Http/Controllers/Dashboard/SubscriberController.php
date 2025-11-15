<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('subscribers.view');

        $subscribers = Subscribe::orderBy('created_at', 'desc')->get();

        return view('Dashboard.Subscribers.index', compact('subscribers'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $this->authorize('subscribers.delete');
    
        // Validate the request
        $request->validate([
            'selectedIds' => 'required|array|min:1',
            'selectedIds.*' => 'integer|exists:subscribes,id',
        ]);
    
        $selectedIds = $request->input('selectedIds');
    
        DB::beginTransaction();
        try {
          
            // Delete the subscribers
            $deleted = Subscribe::whereIn('id', $selectedIds)->delete();
    
            DB::commit();
    
            // Handle AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => __('dashboard.your_items_deleted_successfully'),
                ]);
            }
    
            // Redirect for non-AJAX requests
            return redirect()->route('dashboard.subscribers.index')
                ->with('success', __('dashboard.your_items_deleted_successfully'));
    
        } catch (\Exception $e) {
            DB::rollBack();
    
            // Log the error for debugging
            Log::error('Error deleting subscribers: ' . $e->getMessage());
    
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
