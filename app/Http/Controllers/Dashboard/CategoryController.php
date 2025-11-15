<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\Dashboard\Categories\StoreCategoryRequest;
use App\Http\Requests\Dashboard\Categories\UpdateCategoryRequest;
use App\Http\Requests\Dashboard\Categories\DeleteCategoryRequest;
use App\Services\JsonTranslationService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $this->authorize('categories.view');
        $categories = Category::with('parent')->orderBy('id', 'desc')->paginate(20);
        return view('Dashboard.Categories.index', compact('categories'));
    }

    public function create()
    {
        $this->authorize('categories.create');
        $categories = Category::with('parent')->get();
        return view('Dashboard.Categories.create', compact('categories'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->authorize('categories.store');

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/categories'), $imageName);
            $data['image'] = $imageName;
        }

        if ($request->hasFile('icon')) {
            $iconName = time() . '_icon.' . $request->icon->extension();
            $request->icon->move(public_path('uploads/categories'), $iconName);
            $data['icon'] = $iconName;
        }

        // Get translation fields
        $translationFields = JsonTranslationService::getTranslationFields('category');

        // Create model with JSON translations
        $category = JsonTranslationService::createWithTranslations(Category::class, $data, $request, $translationFields);

        return redirect()->route('dashboard.categories.index')->with('success', 'تمت الإضافة بنجاح');
    }

    public function edit(Category $category)
    {
        $this->authorize('categories.edit');
        $categories = Category::with('parent')->get();
        return view('Dashboard.Categories.edit', compact('category', 'categories'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->authorize('categories.update');

        $data = $request->validated();
        $data['status'] = $request->has('status') ? 1 : 0;
        $data['show_in_home'] = $request->has('show_in_home') ? 1 : 0;
        $data['show_in_header'] = $request->has('show_in_header') ? 1 : 0;
        $data['show_in_footer'] = $request->has('show_in_footer') ? 1 : 0;

        if ($request->hasFile('image')) {
            // Remove old image
            if ($category->image) {
                $oldImagePath = public_path('uploads/categories/' . $category->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/categories'), $imageName);
            $data['image'] = $imageName;
        }

        if ($request->hasFile('icon')) {
            // Remove old icon
            if ($category->icon) {
                $oldIconPath = public_path('uploads/categories/' . $category->icon);
                if (file_exists($oldIconPath)) {
                    unlink($oldIconPath);
                }
            }
            $iconName = time() . '_icon.' . $request->icon->extension();
            $request->icon->move(public_path('uploads/categories'), $iconName);
            $data['icon'] = $iconName;
        }

        // Get translation fields
        $translationFields = JsonTranslationService::getTranslationFields('category');

        // Update model with JSON translations
        $category = JsonTranslationService::updateWithTranslations($category, $data, $request, $translationFields);

        return redirect()->route('dashboard.categories.edit', $category->id)
            ->with('success', 'تم التحديث بنجاح');
    }

    public function destroy(DeleteCategoryRequest $request, Category $category)
    {
        $this->authorize('categories.delete');
        $category->images()->delete();
        $category->delete();
        return redirect()->route('dashboard.categories.index')->with('success', 'تم الحذف بنجاح');
    }

    public function uploadImages(Request $request)
    {
        $this->authorize('categories.create');

        $request->validate([
            'image' => 'required|file|mimes:jpg,jpeg,png,webp,gif|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/categories'), $imageName);
            return response()->json(['success' => true, 'image' => $imageName, 'url' => asset('uploads/categories/' . $imageName)]);
        }
        return response()->json(['success' => false, 'message' => 'لم يتم رفع أي صورة'], 400);
    }

    public function removeUploadImages(Request $request)
    {
        $this->authorize('categories.create');
        $imageName = $request->input('image');
        $imagePath = public_path('uploads/categories/' . $imageName);

        if ($imageName && file_exists($imagePath)) {
            unlink($imagePath);
            return response()->json(['success' => true, 'message' => 'تم حذف الصورة بنجاح']);
        }
        return response()->json(['success' => false, 'message' => 'الصورة غير موجودة'], 404);
    }

    public function deleteImage($id)
    {
        $this->authorize('categories.delete');
        $category = Category::findOrFail($id);

        if ($category->image) {
            $imagePath = public_path('uploads/categories/' . $category->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $category->image = null;
            $category->save();
            return response()->json(['success' => true, 'message' => 'تم حذف الصورة بنجاح']);
        }
        return response()->json(['success' => false, 'message' => 'لا توجد صورة'], 404);
    }
}
