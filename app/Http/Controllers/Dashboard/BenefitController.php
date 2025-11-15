<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Benefits\DeleteBenefitRequest;
use App\Http\Requests\Dashboard\Benefits\StoreBenefitRequest;
use App\Http\Requests\Dashboard\Benefits\UpdateBenefitRequest;
use App\Models\Benefit;
use App\Services\Dashboard\BenefitService;
use Illuminate\Http\Request;

class BenefitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('benefits.view');

        $Benefits = Benefit::general()->get();
        return view('Dashboard.Benefits.index',compact('Benefits'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('benefits.create');

        return view('Dashboard.Benefits.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBenefitRequest $request)
    {

        $this->authorize('benefits.store');

       try{

        $data = $request->validated();

        $response = (new BenefitService())->store($request,$data);
        if ($response) {
            return redirect()->route('dashboard.benefits.index')->with('success', 'Benefit created successfully.');
        } else {
            return redirect()->back()->with('error', 'Error occurred while creating Benefit.');
        }
       }catch (\Exception $e){
           return redirect()->back()->with('error', 'Error occurred while creating Benefit: ' . $e->getMessage());
       }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Benefit $Benefit)
    {
        $this->authorize('benefits.edit');

        return view('Dashboard.Benefits.edit', compact('Benefit'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBenefitRequest $request, Benefit $Benefit)
    {
        $this->authorize('benefits.update');
        try{
            $data = $request->validated();
            $response = (new BenefitService())->update($request, $data, $Benefit);
            if ($response) {
                return redirect()->route('dashboard.benefits.index')->with('success', 'Benefit updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Error occurred while updating Benefit.');
            }
        }catch (\Exception $e){
            return redirect()->back()->with('error', 'Error occurred while updating Benefit: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteBenefitRequest $request, string $id)
    {
        $this->authorize('benefits.delete');

        $selectedIds = $request->input('selectedIds');

        $data = $request->validated();

        $deleted = (new BenefitService())->delete($selectedIds,$data);


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
