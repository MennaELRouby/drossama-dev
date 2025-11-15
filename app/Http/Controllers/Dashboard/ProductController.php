<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Products\DeleteProductRequest;
use App\Http\Requests\Dashboard\Products\StoreProductRequest;
use App\Http\Requests\Dashboard\Products\UpdateProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\Service;
use App\Models\ProductImage;
use App\Services\Dashboard\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('products.view');

        try {
            $products = Product::with(['parent', 'category', 'productImages'])
                ->orderBy('id', 'desc')
                ->get();

            return view('Dashboard.Products.index', compact('products'));
        } catch (\Exception $e) {
            Log::error('Error loading products index: ' . $e->getMessage());

            return redirect()->back()->with('error', __('dashboard.an_error_occurred'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('products.create');

        try {
            $data['product'] = new Product();
            $data['products'] = Product::with('parent')->get();
            $data['categories'] = Category::with('parent')->get();
            $data['services'] = Service::with('parent')->get();

            return view('Dashboard.Products.create', $data);
        } catch (\Exception $e) {
            Log::error('Error loading product create form: ' . $e->getMessage());

            return redirect()->back()->with('error', __('dashboard.an_error_occurred'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $this->authorize('products.store');
        try {
            $response = $this->productService->store($request);
            // إضافة الصور بعد إنشاء المنتج
            if ($response && $request->hasFile('product_images')) {
                $this->handleProductImagesUpload($request->file('product_images'), $response->id);
            }
            if (!$response) {
                return redirect()->back()->with(['error' => __('dashboard.failed_to_create_item')]);
            }
            return redirect()->route('dashboard.products.index')->with(['success' => __('dashboard.your_item_created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $this->authorize('products.edit');

        try {
            $data['product'] = $product->load(['category', 'productImages']);
            $data['products'] = Product::with('parent')->get();
            $data['categories'] = Category::with('parent')->get();

            return view('Dashboard.Products.edit', $data);
        } catch (\Exception $e) {
            Log::error('Error loading product edit form: ' . $e->getMessage());

            return redirect()->back()->with('error', __('dashboard.an_error_occurred'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('products.update');
        try {
            $response = $this->productService->update($request, $product);
            // إضافة الصور الجديدة عند التحديث
            if ($request->hasFile('product_images')) {
                $this->handleProductImagesUpload($request->file('product_images'), $product->id);
            }
            if (!$response) {
                return redirect()->back()->with(['error' => __('dashboard.failed_to_update_item')]);
            }
            return redirect()->route('dashboard.products.index')->with(['success' => __('dashboard.your_item_updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteProductRequest $request, $product)
    {
        $this->authorize('products.delete');

        $selectedIds = $request->input('selectedIds', [$product]);

        // Log::info('Starting delete operation in ProductController', [
        //     'product' => $product,
        //     'selectedIds' => $selectedIds,
        //     'request_method' => $request->method(),
        //     'request_url' => $request->url()
        // ]);

        try {
            $deleted = $this->productService->delete($selectedIds);

            // Log::info('Delete operation completed in ProductController', [
            //     'success' => $deleted,
            //     'selectedIds' => $selectedIds
            // ];

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => __('dashboard.your_items_deleted_successfully')
                ]);
            }

            return redirect()->back()
                ->with('success', __('dashboard.your_items_deleted_successfully'));
        } catch (\Exception $e) {
            // Log::error('Error deleting products', [
            //     'error' => $e->getMessage(),
            //     'trace' => $e->getTraceAsString()
            // ];

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => __('dashboard.an_error_occurred')
                ], 500);
            }

            return redirect()->back()
                ->withErrors(__('dashboard.an_error_occurred'));
        }
    }

    /**
     * Change the category of a product.
     */
    public function changeCategory(Request $request, $id)
    {
        $this->authorize('products.update');

        $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);

        try {
            $product = Product::findOrFail($id);
            $oldCategoryId = $product->category_id;

            $product->category_id = $request->input('category_id');
            $product->save();

            Log::info('Product category changed successfully', [
                'product_id' => $id,
                'old_category_id' => $oldCategoryId,
                'new_category_id' => $request->input('category_id')
            ]);

            return redirect()->back()->with('success', __('dashboard.your_item_updated_successfully'));
        } catch (\Exception $e) {
            Log::error('Error changing product category: ' . $e->getMessage());

            return redirect()->back()->with('error', __('dashboard.an_error_occurred'));
        }
    }

    // رفع صور متعددة للمنتج عبر Dropzone
    public function uploadImages(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'productId' => 'required|exists:products,id',
        ]);

        try {
            if ($request->hasFile('file')) {
                $image = $request->file('file');
                $filename = \App\Helper\Media::uploadAndAttachImageStorage($image, 'products');

                // Get the maximum order for this product
                $maxOrder = ProductImage::where('product_id', $request->input('productId'))->max('order') ?? 0;

                // Create the product image record
                $productImage = ProductImage::create([
                    'product_id' => $request->input('productId'),
                    'image' => $filename,
                    'order' => $maxOrder + 1,
                ]);

                return response()->json([
                    'success' => true,
                    'filename' => $filename,
                    'image_id' => $productImage->id
                ]);
            }

            return response()->json(['success' => false, 'message' => 'No file uploaded'], 400);
        } catch (\Exception $e) {
            Log::error('Error uploading product image: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Upload failed'], 500);
        }
    }
    // حذف صورة مرفوعة مؤقتاً
    public function removeUploadImages(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        try {
            $filename = $request->input('name');

            // Find and delete the product image record
            $productImage = ProductImage::where('image', $filename)->first();

            if ($productImage) {
                // Remove the file from storage
                \App\Helper\Media::removeFile('products', $filename);

                // Delete the database record
                $productImage->delete();

                Log::info('Uploaded product image removed successfully', [
                    'filename' => $filename,
                    'image_id' => $productImage->id
                ]);

                return response()->json([
                    'success' => true,
                    'message' => __('dashboard.image_removed_successfully')
                ]);
            }

            // If no record found, just remove the file
            \App\Helper\Media::removeFile('products', $filename);

            return response()->json([
                'success' => true,
                'message' => __('dashboard.file_removed_successfully')
            ]);
        } catch (\Exception $e) {
            Log::error('Error removing uploaded product image: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => __('dashboard.an_error_occurred')
            ], 500);
        }
    }
    // حذف صورة من المنتج (زر الحذف)
    public function deleteImage(Request $request)
    {
        $request->validate([
            'image' => 'required|integer|exists:product_images,id',
        ]);

        try {
            $imageId = $request->input('image');
            $image = ProductImage::findOrFail($imageId);

            // Get the raw filename from the image
            $filename = $image->getImageFilenameAttribute();

            if ($filename) {
                // Remove the file from storage
                \App\Helper\Media::removeFile('products', $filename);

                Log::info('Product image deleted successfully', [
                    'image_id' => $imageId,
                    'product_id' => $image->product_id,
                    'filename' => $filename
                ]);
            }

            // Delete the database record
            $image->delete();

            return response()->json([
                'success' => true,
                'message' => __('dashboard.image_deleted_successfully')
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting product image: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => __('dashboard.an_error_occurred')
            ], 500);
        }
    }
    // حذف كل الصور
    public function deleteAllImages(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        try {
            $productId = $request->input('product_id');
            $product = Product::findOrFail($productId);
            $images = $product->productImages;

            if ($images->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => __('dashboard.no_images_found')
                ], 404);
            }

            $deletedCount = 0;
            foreach ($images as $image) {
                // Get the raw filename from the image
                $filename = $image->getImageFilenameAttribute();

                if ($filename) {
                    // Remove the file from storage
                    \App\Helper\Media::removeFile('products', $filename);
                    $deletedCount++;
                }

                // Delete the database record
                $image->delete();
            }

            Log::info('All product images deleted successfully', [
                'product_id' => $productId,
                'deleted_count' => $deletedCount
            ]);

            return response()->json([
                'success' => true,
                'message' => __('dashboard.all_images_deleted_successfully'),
                'deleted_count' => $deletedCount
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting all product images: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => __('dashboard.an_error_occurred')
            ], 500);
        }
    }
    // حذف صور محددة
    public function deleteSelectedImages(Request $request)
    {
        $request->validate([
            'image_ids' => 'required|array',
            'image_ids.*' => 'integer|exists:product_images,id',
        ]);

        try {
            $imageIds = $request->input('image_ids');
            $deletedCount = 0;
            $errors = [];

            foreach ($imageIds as $imageId) {
                try {
                    $image = ProductImage::findOrFail($imageId);

                    // Get the raw filename from the image
                    $filename = $image->getImageFilenameAttribute();

                    if ($filename) {
                        // Remove the file from storage
                        \App\Helper\Media::removeFile('products', $filename);
                    }

                    // Delete the database record
                    $image->delete();
                    $deletedCount++;
                } catch (\Exception $e) {
                    $errors[] = "Failed to delete image ID {$imageId}: " . $e->getMessage();
                    Log::warning('Failed to delete selected image', [
                        'image_id' => $imageId,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            Log::info('Selected product images deleted', [
                'requested_count' => count($imageIds),
                'deleted_count' => $deletedCount,
                'errors_count' => count($errors)
            ]);

            $response = [
                'success' => true,
                'message' => __('dashboard.selected_images_deleted_successfully'),
                'deleted_count' => $deletedCount,
                'total_requested' => count($imageIds)
            ];

            if (!empty($errors)) {
                $response['warnings'] = $errors;
            }

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error deleting selected product images: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => __('dashboard.an_error_occurred')
            ], 500);
        }
    }
    // ترتيب الصور
    public function reorderImages(Request $request)
    {
        $request->validate([
            'image_ids' => 'required|array',
            'image_ids.*' => 'integer|exists:product_images,id',
        ]);

        try {
            $imageIds = $request->input('image_ids');
            $updatedCount = 0;

            foreach ($imageIds as $order => $imageId) {
                $updated = ProductImage::where('id', $imageId)->update(['order' => $order]);
                if ($updated) {
                    $updatedCount++;
                }
            }

            Log::info('Product images reordered successfully', [
                'total_images' => count($imageIds),
                'updated_count' => $updatedCount
            ]);

            return response()->json([
                'success' => true,
                'message' => __('dashboard.images_reordered_successfully'),
                'updated_count' => $updatedCount
            ]);
        } catch (\Exception $e) {
            Log::error('Error reordering product images: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => __('dashboard.error_reordering_images')
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $this->authorize('products.view');

        try {
            // Load relationships for better performance
            $product->load(['category', 'productImages']);

            return redirect()->route('dashboard.products.edit', $product->id);
        } catch (\Exception $e) {
            Log::error('Error showing product: ' . $e->getMessage());

            return redirect()->back()->with('error', __('dashboard.an_error_occurred'));
        }
    }

    /**
     * Handle multiple product images upload
     */
    private function handleProductImagesUpload($images, int $productId): void
    {
        try {
            $maxOrder = ProductImage::where('product_id', $productId)->max('order') ?? 0;

            foreach ($images as $image) {
                $filename = \App\Helper\Media::uploadAndAttachImageStorage($image, 'products');

                ProductImage::create([
                    'product_id' => $productId,
                    'image' => $filename,
                    'order' => ++$maxOrder,
                ]);

                Log::info('Product image uploaded successfully', [
                    'product_id' => $productId,
                    'filename' => $filename,
                    'order' => $maxOrder
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error uploading product images: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Toggle product status (publish/unpublish)
     */
    public function toggleStatus(Product $product)
    {
        $this->authorize('products.update');

        try {
            $product->update([
                'status' => $product->status === 1 ? 0 : 1
            ]);

            $message = $product->status === 1
                ? __('dashboard.published_successfully')
                : __('dashboard.unpublished_successfully');

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return redirect()->back()->with(['success' => $message]);
        } catch (\Exception $e) {
            Log::error('Error toggling product status: ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => __('dashboard.an_error_occurred')
                ], 500);
            }
            return redirect()->back()->withErrors(__('dashboard.an_error_occurred'));
        }
    }

    /**
     * Remove multiple resources from storage.
     */
    public function bulkDestroy(Request $request)
    {
        $this->authorize('products.delete');

        $selectedIds = $request->input('selectedIds');

        if (empty($selectedIds)) {
            return response()->json(['message' => __('dashboard.no_items_selected')], 422);
        }

        try {
            $deleted = $this->service->delete($selectedIds);

            if (request()->ajax()) {
                if (!$deleted) {
                    return response()->json(['message' => __('dashboard.an_error_occurred')], 422);
                }
                return response()->json(['success' => true, 'message' => __('dashboard.your_items_deleted_successfully')]);
            }

            if (!$deleted) {
                return redirect()->back()->withErrors(__('dashboard.an_error_occurred'));
            }

            return redirect()->back()->with(['success' => __('dashboard.your_items_deleted_successfully')]);
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['message' => __('dashboard.an_error_occurred')], 500);
            }
            return redirect()->back()->withErrors(__('dashboard.an_error_occurred'));
        }
    }
}
