<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Clients\DeleteClientRequest;
use App\Http\Requests\Dashboard\Clients\StoreClientRequest;
use App\Http\Requests\Dashboard\Clients\UpdateClientRequest;
use App\Models\Client;
use App\Services\Dashboard\ClientService;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    protected $service;

    public function __construct(ClientService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('clients.view');
        $clients = Client::all();
        return view('Dashboard.Clients.index',compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('clients.create');
        return view('Dashboard.Clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        try{
            $this->authorize('clients.store');
            $client = $this->service->store($request);
            return redirect()->route('dashboard.clients.index')->with('success', __('messages.created_successfully'));
        }catch (\Exception $e){
            return redirect()->back()->with('error',__('messages.error'));
        }
    }

   

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        $this->authorize('clients.edit');
        return view('Dashboard.Clients.edit',compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        try{
            $this->authorize('clients.edit');
            $this->service->update($request, $client);
            return redirect()->route('dashboard.clients.index')->with('success', __('dashboard.your_items_updated_successfully'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteClientRequest $request, string $id)
    {
        $this->authorize('clients.delete');

        $selectedIds = $request->input('selectedIds');

        $request->validated();

        $deleted = $this->service->delete($selectedIds);


        if (request()->ajax()) {
            if (!$deleted) {
                return response()->json(['message' => __('dashboard.an messages.error entering data')], 422);
            }
            return response()->json(['success' => true, 'message' => __('dashboard.your_items_deleted_successfully')]);
        }
        if (!$deleted) {
            return redirect()->back()->withErrors(__('dashboard.an error has occurred. Please contact the developer to resolve the issue'));
        }
    }
}
