<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Domains\DeleteDomainRequest;
use App\Http\Requests\Dashboard\Domains\StoreDomainRequest;
use App\Http\Requests\Dashboard\Domains\UpdateDomainRequest;
use App\Models\Dashboard\Domain;
use App\Services\Dashboard\DomainService;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    protected $service ;
    public function __construct(DomainService $domain_service)
    {
        $this->service = $domain_service ;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('domains.view');

        $domains = Domain::all();

        return view('Dashboard.Domains.index',compact('domains'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('domains.create');

        return view('Dashboard.Domains.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDomainRequest $request)
    {
        $this->authorize('domains.store');
        try{
            $data = $request->validated();

            $this->service->store($data);

            return redirect()->back()->with(['success' => __('dashboard.your_item_added_successfully')]);

        }catch(\Exception $e){
            return redirect()->back()->with(['error' => __('dashboard.failed_to_add_item')]);

        }

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Domain $domain)
    {
        $this->authorize('domains.edit');

        return view('Dashboard.Domains.edit',compact('domain'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDomainRequest $request, Domain $domain)
    {
        $this->authorize('domains.update');
        try {
            $data = $request->validated();

            $this->service->update($data, $domain);

            return redirect()->back()->with(['success' => __('dashboard.your_item_updated_successfully')]);
        } catch (\Exception $e) {

            return redirect()->back()->with(['error' => __('dashboard.failed_to_update_item')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteDomainRequest $request, Domain $domain)
    {
        $this->authorize('domains.delete');

        $selectedIds = $request->input('selectedIds');

        $deleted = $this->service->delete($selectedIds);

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
