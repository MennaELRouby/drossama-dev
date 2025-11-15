<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Faqs\StoreFaqRequest;
use App\Http\Requests\Dashboard\Faqs\UpdateFaqRequest;
use App\Models\Dashboard\Hosting;
use App\Models\Faq;
use App\Services\Dashboard\FaqService;
use Illuminate\Http\Request;

class HostingFaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Hosting $hosting)
    {
        return view('Dashboard.Hostings.Faqs.index', compact('hosting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Hosting $hosting)
    {
        return view('Dashboard.Hostings.Faqs.create', compact('hosting'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFaqRequest $request, Hosting $hosting)
    {
        try {
            $data = $request->validated();

            $hosting->faqs()->create($data);

            return redirect()->route('dashboard.hostings.faqs.index', $hosting->id)
                ->with('success', 'Faq created successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Error occurred while creating Faq: ' . $e->getMessage());
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hosting $hosting, Faq $faq)
    {
        return view('Dashboard.Hostings.Faqs.edit', compact(['hosting', 'faq']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFaqRequest $request, Hosting $hosting, Faq $faq)
    {

        try {
            $data = $request->validated();
            $response = (new FaqService())->update($request, $faq);
            if ($response) {
                return redirect()->route('dashboard.hostings.faqs.index', $hosting->id)->with('success', 'Faq updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Error occurred while updating Faq.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error occurred while updating Faq: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Hosting $hosting, Faq $faq)
    {

        try {

            $deleted =  $faq->delete();

            if ($deleted) {
                return redirect()->back()->with('success', 'Faq deleted successfully.');
            }
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Error occurred while updating Faq: ' . $e->getMessage());
        }
    }
}
