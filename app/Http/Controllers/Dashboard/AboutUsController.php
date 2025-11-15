<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\About\AboutRequest;
use App\Models\Dashboard\AboutUs;
use App\Services\Dashboard\AboutService;
use Illuminate\Http\Request;



class AboutUsController extends Controller
{

    protected $service;

    public function __construct(AboutService $about_service)
    {
        $this->service = $about_service;
    }

    public function edit()
    {
        $this->authorize('about.edit');
        $about = AboutUs::firstOrNew();

        return view('Dashboard.AboutUs.edit', compact('about'));
    }

    public function update(AboutRequest  $request, AboutUs $about)
    {
        $this->authorize('about.update');
        try {
            $data = $request->validated();

            $response = (new AboutService())->update($request, $data, $about);
            if (!$response) {
                return redirect()->back()->with(['error' => __('dashboard.failed_to_update_item')]);
            }

            return redirect()->back()->with(['success' => __('dashboard.your_item_updated_successfully')]);
        } catch (\Exception $e) {

            return redirect()->back()->with(['error' => __('dashboard.failed_to_update_item')]);
        }
    }
}
