<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Phones\StorePhoneRequest;
use App\Http\Requests\Dashboard\Phones\UpdatePhoneRequest;
use App\Models\Phone;
use App\Traits\UsesJsonTranslations;
use Illuminate\Http\Request;

class PhoneController extends Controller
{
    use UsesJsonTranslations;
    // No need for constructor - global NoCacheMiddleware handles all caching

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $phones = Phone::latest()->paginate(10);
        return view('Dashboard.Phones.index', compact('phones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Dashboard.Phones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePhoneRequest $request)
    {
        $data = $request->validated();

        // Prepare main data (non-translatable fields)
        $mainData = [
            'phone' => $data['phone'],
            'code' => $data['code'] ?? null,
            'email' => $data['email'] ?? null,
            'type' => $data['type'],
            'status' => $data['status'] ?? true,
            'order' => $data['order'] ?? null,
        ];

        // Create model with JSON translations using the trait
        $this->createWithTranslations(Phone::class, $mainData, $request, 'phone');

        return redirect()->route('dashboard.phones.index')->with('success', 'تم إضافة الهاتف بنجاح');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $phone = Phone::findOrFail($id);
        return view('Dashboard.Phones.show', compact('phone'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $phone = Phone::findOrFail($id);
        return view('Dashboard.Phones.edit', compact('phone'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePhoneRequest $request, string $id)
    {
        $phone = Phone::findOrFail($id);
        $data = $request->validated();

        // Prepare main data (non-translatable fields)
        $mainData = [
            'phone' => $data['phone'],
            'code' => $data['code'] ?? $phone->code,
            'email' => $data['email'] ?? $phone->email,
            'type' => $data['type'],
            'status' => $data['status'] ?? $phone->status,
            'order' => $data['order'] ?? $phone->order,
        ];

        // Update model with JSON translations using the trait
        $this->updateWithTranslations($phone, $mainData, $request, 'phone');

        return redirect()->route('dashboard.phones.index')->with('success', 'تم تحديث الهاتف بنجاح');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $phone = Phone::findOrFail($id);
        $phone->delete();

        // No cache clearing needed - cache is disabled

        return redirect()->route('dashboard.phones.index')->with('success', 'تم حذف الهاتف بنجاح');
    }

    /**
     * Remove multiple resources from storage.
     */
    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['error' => 'لم يتم تحديد أي عناصر للحذف'], 400);
        }

        $deletedCount = Phone::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true,
            'message' => "تم حذف {$deletedCount} هاتف بنجاح"
        ]);
    }

    // clearAllCaches method removed - cache is completely disabled
}
