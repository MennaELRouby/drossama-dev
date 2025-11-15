<?php

namespace App\Http\Requests\Dashboard\BlogCategories;

use App\Models\BlogCategory;
use App\Rules\UniqueSlug;
use Illuminate\Foundation\Http\FormRequest;

class StoreBlogCategoryRequest extends FormRequest
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
           'name_en' => ['required', 'string', new UniqueSlug(BlogCategory::class, 'slug_en')],
           'name_ar' => ['required', 'string', new UniqueSlug(BlogCategory::class, 'slug_ar')],
           'short_desc_en' => 'nullable|string',
           'short_desc_ar' => 'nullable|string',
           'long_desc_en' => 'nullable|string',
           'long_desc_ar' => 'nullable|string',
           'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
           'alt_image' => 'nullable|string|max:255',
           'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
           'alt_icon' => 'nullable|string|max:255',
           'meta_title_en' => 'nullable|string|max:255',
           'meta_title_ar' => 'nullable|string|max:255',
           'meta_desc_en' => 'nullable|string',
           'meta_desc_ar' => 'nullable|string',
           'slug_en' => 'nullable|string',
           'slug_ar' => 'nullable|string',
           'status' => 'nullable|boolean',
           'show_in_home' => 'nullable|boolean',
           'show_in_header' => 'nullable|boolean',
           'show_in_footer' => 'nullable|boolean',
           'index' => 'nullable|boolean',
           'order' => 'nullable|integer',
          
        ];
    }
}
