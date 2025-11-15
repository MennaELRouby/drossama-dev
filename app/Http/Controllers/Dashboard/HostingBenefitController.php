<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\Media;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Benefits\DeleteBenefitRequest;
use App\Http\Requests\Dashboard\Benefits\StoreBenefitRequest;
use App\Http\Requests\Dashboard\Benefits\UpdateBenefitRequest;
use App\Models\Benefit;
use App\Models\Dashboard\Hosting;
use App\Services\Dashboard\BenefitService;
use Illuminate\Http\Request;

class HostingBenefitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Hosting $hosting)
    {
        return view('Dashboard.Hostings.Benefite.index', compact('hosting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Hosting $hosting)
    {
        return view('Dashboard.Hostings.Benefite.create', compact('hosting'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBenefitRequest $request, Hosting $hosting)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $data['image'] =   Media::uploadAndAttachImage($request->file('image'),  'benefits');
            }
            if ($request->hasFile('icon')) {
                $data['icon'] =  Media::uploadAndAttachImage($request->file('icon'),  'benefits');
            }

            $hosting->benefits()->create($data);

            return redirect()->route('dashboard.hostings.benefits.index', $hosting->id)
                ->with('success', 'Benefit created successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Error occurred while creating Benefit: ' . $e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hosting $hosting, Benefit $benefit)
    {
        return view('Dashboard.Hostings.Benefite.edit', compact(['hosting', 'benefit']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBenefitRequest $request, Hosting $hosting, Benefit $Benefit)
    {

        try {
            $data = $request->validated();
            $response = (new BenefitService())->update($request, $data, $Benefit);
            if ($response) {
                return redirect()->route('dashboard.hostings.benefits.index', $hosting->id)->with('success', 'Benefit updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Error occurred while updating Benefit.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error occurred while updating Benefit: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteBenefitRequest $request, Hosting $hosting, Benefit $benefit)
    {

        try {
            if ($benefit->image) {

                Media::removeFile('benefits', $benefit->image);
            }
            // Delete associated Icon if it exists
            if ($benefit->icon) {
                Media::removeFile('benefits', $benefit->icon);
            }

            $deleted =  $benefit->delete();

            if($deleted){
                return redirect()->back()->with('success', 'Benefit deleted successfully.');
            }
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Error occurred while updating Benefit: ' . $e->getMessage());
        }
    }
}
