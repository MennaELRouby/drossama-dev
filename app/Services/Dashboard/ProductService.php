<?php

namespace App\Services\Dashboard;

use App\Helper\Media;
use App\Services\JsonTranslationService;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ProductService
{
    /**
     * Clean Arabic text for slug usage
     * Keep Arabic characters but remove special characters and spaces
     */
    private function cleanArabicSlug($text)
    {
        // Replace spaces and special characters with dashes, but keep Arabic characters
        $slug = str_replace([' ', '/', '\\', '?', '#', '[', ']', '@', '!', '$', '&', "'", '(', ')', '*', '+', ',', ';', '=', '%'], '-', $text);

        // Remove multiple dashes
        $slug = preg_replace('/-+/', '-', $slug);

        // Remove leading/trailing dashes
        $slug = trim($slug, '-');

        return $slug;
    }

    public function store($request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            // Prepare main model data (non-translatable fields)
            $mainData = [
                'parent_id' => $data['parent_id'] ?? null,
                'category_id' => $data['category_id'] ?? null,
                'service_id' => $data['service_id'] ?? null,
                'image' => null,
                'alt_image' => $data['alt_image'] ?? null,
                'icon' => null,
                'alt_icon' => $data['alt_icon'] ?? null,
                'status' => $data['status'] ?? 1,
                'show_in_home' => $data['show_in_home'] ?? 0,
                'show_in_header' => $data['show_in_header'] ?? 0,
                'show_in_footer' => $data['show_in_footer'] ?? 0,
                'index' => $data['index'] ?? 0,
                'order' => $data['order'] ?? 0,
                'date' => $data['date'] ?? null,
            ];

            // Handle file uploads
            if ($request->hasFile('image')) {
                $mainData['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'products');
            }
            if ($request->hasFile('icon')) {
                $mainData['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'products');
            }

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('product');

            // Create model with JSON translations
            $model = JsonTranslationService::createWithTranslations(Product::class, $mainData, $request, $translationFields);

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $model)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            // Prepare main model data (non-translatable fields)
            $mainData = [
                'parent_id' => $data['parent_id'] ?? null,
                'category_id' => $data['category_id'] ?? null,
                'service_id' => $data['service_id'] ?? null,
                'alt_image' => $data['alt_image'] ?? null,
                'alt_icon' => $data['alt_icon'] ?? null,
                'status' => $data['status'] ?? 1,
                'show_in_home' => $data['show_in_home'] ?? 0,
                'show_in_header' => $data['show_in_header'] ?? 0,
                'show_in_footer' => $data['show_in_footer'] ?? 0,
                'index' => $data['index'] ?? 0,
                'order' => $data['order'] ?? 0,
                'date' => $data['date'] ?? null,
            ];

            // Handle file uploads
            if ($request->hasFile('image')) {
                if ($model->image) {
                    Media::removeFile('products', $model->image);
                }
                $mainData['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'products');
            }

            if ($request->hasFile('icon')) {
                if ($model->icon) {
                    Media::removeFile('products', $model->icon);
                }
                $mainData['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'products');
            }

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('product');

            // Update model with JSON translations
            $model = JsonTranslationService::updateWithTranslations($model, $mainData, $request, $translationFields);

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($selectedIds)
    {
        Log::info('Starting delete in ProductService', [
            'selectedIds' => $selectedIds
        ]);

        $products = Product::whereIn('id', $selectedIds)->get();

        Log::info('Found products to delete', [
            'count' => $products->count(),
            'products' => $products->pluck('id')->toArray()
        ]);

        DB::beginTransaction();
        try {
            foreach ($products as $product) {
                Log::info('Processing product', [
                    'product_id' => $product->id,
                    'has_image' => !empty($product->image),
                    'has_icon' => !empty($product->icon)
                ]);

                // Delete associated product images
                $this->deleteProductImages($product);

                // Delete associated image if it exists
                if ($product->image) {
                    try {
                        Media::removeFile('products', $product->image);
                        Log::info('Deleted product image', [
                            'product_id' => $product->id,
                            'image' => $product->image
                        ]);
                    } catch (\Exception $e) {
                        Log::warning('Failed to delete product image', [
                            'product_id' => $product->id,
                            'image' => $product->image,
                            'error' => $e->getMessage()
                        ]);
                    }
                }

                // Delete associated Icon if it exists
                if ($product->icon) {
                    try {
                        Media::removeFile('products', $product->icon);
                        Log::info('Deleted product icon', [
                            'product_id' => $product->id,
                            'icon' => $product->icon
                        ]);
                    } catch (\Exception $e) {
                        Log::warning('Failed to delete product icon', [
                            'product_id' => $product->id,
                            'icon' => $product->icon,
                            'error' => $e->getMessage()
                        ]);
                    }
                }

                // Delete the product model (this triggers the observer)
                try {
                    $product->delete();
                    Log::info('Deleted product', [
                        'product_id' => $product->id
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to delete product', [
                        'product_id' => $product->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    throw $e;
                }
            }

            DB::commit();
            Log::info('Delete operation completed successfully');
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Delete operation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Delete all images associated with a product
     */
    private function deleteProductImages(Product $product): void
    {
        try {
            $productImages = $product->productImages;

            foreach ($productImages as $image) {
                // Get the raw filename from the image
                $filename = $image->getImageFilenameAttribute();

                if ($filename) {
                    Media::removeFile('products', $filename);
                    Log::info('Deleted product image file', [
                        'product_id' => $product->id,
                        'image_id' => $image->id,
                        'filename' => $filename
                    ]);
                }

                $image->delete();
            }

            Log::info('Deleted all product images', [
                'product_id' => $product->id,
                'count' => $productImages->count()
            ]);
        } catch (\Exception $e) {
            Log::warning('Failed to delete some product images', [
                'product_id' => $product->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}
