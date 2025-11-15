<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContactMessageController extends Controller
{
    public function index()
    {
        $this->authorize('contact_messages.view');

        $messages = ContactUs::orderBy('created_at', 'desc')->get();

        return view('Dashboard.ContactMessages.index', compact('messages'));
    }
    public function show(ContactUs $message)
    {
        $this->authorize('contact_messages.show');
        $message->update(['seen' => true]);

        return view('Dashboard.ContactMessages.show', compact('message'));
    }

    public function destroy(Request $request)
    {
        $this->authorize('contact_messages.delete');
    
        // Validate the request
        $request->validate([
            'selectedIds' => 'required|array|min:1',
            'selectedIds.*' => 'integer|exists:contact_us,id',
        ]);
    
        $selectedIds = $request->input('selectedIds');
    
        DB::beginTransaction();
        try {
           
            // Delete the messages
            $deleted = ContactUs::whereIn('id', $selectedIds)->delete();
    
            DB::commit();
    
            // Handle AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => __('dashboard.your_items_deleted_successfully'),
                ]);
            }
    
            // Redirect for non-AJAX requests
            return redirect()->route('dashboard.contact_messages.index')
                ->with('success', __('dashboard.your_items_deleted_successfully'));
    
        } catch (\Exception $e) {
            DB::rollBack();
    
            // Log the error for debugging
            Log::error('Error deleting contact messages: ' . $e->getMessage());
    
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
