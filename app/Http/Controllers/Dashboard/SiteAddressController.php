<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SiteAddresses\DeleteSiteAddressRequest;
use App\Http\Requests\Dashboard\SiteAddresses\StoreSiteAddressRequest;
use App\Http\Requests\Dashboard\SiteAddresses\UpdateSiteAddressRequest;
use App\Models\SiteAddress;
use App\Services\Dashboard\SiteAddressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SiteAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('site_addresses.view');

        $site_addresses =  SiteAddress::all();
        return view('Dashboard.SiteAddress.index', compact('site_addresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('site_addresses.create');

        return view('Dashboard.SiteAddress.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSiteAddressRequest $request)
    {
        $this->authorize('site_addresses.store');

        try {
            $data = $request->validated();

            $response = (new SiteAddressService())->store($data);

            if (!$response) {
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
    public function edit(SiteAddress $site_address)
    {
        $this->authorize('site_addresses.edit');


        $codes = ['+20', '+966', '+971', '+1'];

        // Helper function to split phone
        $splitPhone = function ($phone) use ($codes) {
            foreach ($codes as $code) {
                if (Str::startsWith($phone, $code)) {
                    return ['code' => $code, 'number' => Str::replaceFirst($code, '', $phone)];
                }
            }
            return ['code' => null, 'number' => $phone];
        };

        $phoneData = $splitPhone($site_address->phone);
        $phone2Data = $splitPhone($site_address->phone2);

        // Add values to $site_address
        $site_address['code'] = $phoneData['code'] ?? '+20'; // Default to Egypt if no code found
        $site_address['phone'] = $phoneData['number'];
        $site_address['code2'] = $phone2Data['code'] ?? '+20'; // Default to Egypt if no code found
        $site_address['phone2'] = $phone2Data['number'];

        return view('Dashboard.SiteAddress.edit', compact('site_address'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSiteAddressRequest $request, SiteAddress $site_address)
    {
        $this->authorize('site_addresses.update');

        try {
            $data = $request->validated();

            $response = (new SiteAddressService())->update($data, $site_address);
            if (!$response) {
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
    public function destroy(DeleteSiteAddressRequest $request, string $id)
    {
        $this->authorize('site_addresses.delete');

        $data = $request->validated();
        $selectedIds = $data['selectedIds'] ?? [];

        $deleted = (new SiteAddressService())->delete($selectedIds);

        if (request()->ajax()) {
            if (!$deleted) {
                return response()->json(['message' => __('dashboard.an messages.error entering data')], 422);
            }
            return response()->json(['success' => true, 'message' => __('dashboard.your_items_deleted_successfully')]);
        }

        if (!$deleted) {
            return redirect()->back()->withErrors(__('dashboard.an error has occurred. Please contact the developer to resolve the issue'));
        }

        return redirect()->route('dashboard.site-addresses.index')->with('success', __('dashboard.your_items_deleted_successfully'));
    }

    /**
     * Bulk delete site addresses
     */
    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return response()->json(['error' => 'لم يتم تحديد أي عناصر للحذف'], 400);
        }
        $deletedCount = SiteAddress::whereIn('id', $ids)->delete();
        return response()->json([
            'success' => true,
            'message' => "تم حذف {$deletedCount} عنوان بنجاح"
        ]);
    }

    public function toggleStatus(Request $request, $id)
    {
        try {
            $model = \App\Models\SiteAddress::findOrFail($id);
            $model->status = !$model->status;
            $model->save();

            $statusText = $model->status ? __('dashboard.published') : __('dashboard.unpublished');

            Log::info('Model status toggled', [
                'model_id' => $id,
                'new_status' => $model->status,
                'status_text' => $statusText
            ]);

            return response()->json([
                'success' => true,
                'status' => $model->status,
                'message' => __('dashboard.status_updated_successfully'),
                'status_text' => $statusText
            ]);
        } catch (\Exception $e) {
            Log::error('Error toggling model status: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => __('dashboard.an error has occurred')], 500);
        }
    }
}
