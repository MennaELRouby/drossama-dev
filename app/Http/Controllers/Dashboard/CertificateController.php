<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Certificates\DeleteCertificatesRequest;
use App\Http\Requests\Dashboard\Certificates\StoreCertificatesRequest;
use App\Http\Requests\Dashboard\Certificates\UpdateCertificatesRequest;
use App\Models\Certificate;
use App\Services\Dashboard\CertificateService;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('certificates.view');

        $certificates = Certificate::orderBy('order')->get();
        return view('Dashboard.Certificates.index', compact('certificates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('certificates.create');

        return view('Dashboard.Certificates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCertificatesRequest $request)
    {
        $this->authorize('certificates.store');

        try {
            $data = $request->validated();

            $response = (new CertificateService)->store($request);

            if ($response) {
                return redirect()->route('dashboard.certificates.index')->with('success', __('dashboard.your_item_created_successfully'));
            } else {
                return redirect()->back()->with('error', __('dashboard.failed_to_create_item'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('dashboard.failed_to_create_item') . ': ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Certificate $certificate)
    {
        $this->authorize('certificates.edit');

        return view('Dashboard.Certificates.edit', compact('certificate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCertificatesRequest $request, Certificate $certificate)
    {
        $this->authorize('certificates.update');

        try {
            $data = $request->validated();

            $response = (new CertificateService)->update($request, $certificate);

            if ($response) {
                return redirect()->route('dashboard.certificates.index')->with('success', __('dashboard.your_item_updated_successfully'));
            } else {
                return redirect()->back()->with('error', __('dashboard.failed_to_update_item'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('dashboard.failed_to_update_item') . ': ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteCertificatesRequest $request)
    {
        $this->authorize('certificates.delete');

        $selectedIds = $request->input('selectedIds');
        $data = $request->validated();

        $deleted = (new CertificateService)->delete($selectedIds, $data);

        if (request()->ajax()) {
            if (!$deleted) {
                return response()->json(['message' => __('dashboard.failed_to_delete_item')], 422);
            }
            return response()->json(['success' => true, 'message' => __('dashboard.your_items_deleted_successfully')]);
        }

        if (!$deleted) {
            return redirect()->back()->withErrors(__('dashboard.failed_to_delete_item'));
        }

        return redirect()->route('dashboard.certificates.index')->with('success', __('dashboard.your_items_deleted_successfully'));
    }
}
