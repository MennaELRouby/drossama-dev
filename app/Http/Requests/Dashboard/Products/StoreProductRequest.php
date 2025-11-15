<?php

namespace App\Http\Requests\Dashboard\Products;

use App\Models\Product;
use App\Rules\UniqueJsonSlug;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'parent_id' => ['nullable', 'exists:products,id'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'service_id' => ['nullable', 'exists:services,id'],
            'name_en' => ['required', 'string'],
            'name_ar' => ['required', 'string'],
            'short_desc_en' => ['nullable', 'string'],
            'short_desc_ar' => ['nullable', 'string'],
            'long_desc_en' => ['nullable', 'string'],
            'long_desc_ar' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp'],
            'alt_image' => ['nullable', 'string'],
            'icon' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp'],
            'alt_icon' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'boolean'],
            'show_in_home' => ['nullable', 'boolean'],
            'show_in_header' => ['nullable', 'boolean'],
            'show_in_footer' => ['nullable', 'boolean'],
            'meta_title_ar' => ['nullable', 'string', 'max:255'],
            'meta_title_en' => ['nullable', 'string', 'max:255'],
            'meta_desc_ar' => ['nullable', 'string'],
            'meta_desc_en' => ['nullable', 'string'],
            'clients_ar' => ['nullable', 'string'],
            'clients_en' => ['nullable', 'string'],
            'location_ar' => ['nullable', 'string'],
            'location_en' => ['nullable', 'string'],
            'index' => ['nullable', 'boolean'],
            'slug_ar' => ['nullable', 'string', new UniqueJsonSlug('App\Models\Product', 'slug', 'ar')],
            'slug_en' => ['nullable', 'string', new UniqueJsonSlug('App\Models\Product', 'slug', 'en')],
            'date' => ['nullable', 'date'],
            'product_images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
        ];
    }
}
