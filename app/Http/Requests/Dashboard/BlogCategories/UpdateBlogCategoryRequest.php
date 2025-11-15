<?php

namespace App\Http\Requests\Dashboard\BlogCategories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBlogCategoryRequest extends FormRequest
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
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
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
            'slug_ar' => [Rule::unique('blog_categories', 'slug_ar')->ignore($this->blog_category->id)],
            'slug_en' => [Rule::unique('blog_categories', 'slug_en')->ignore($this->blog_category->id)],
            'status' => 'nullable|boolean',
            'show_in_home' => 'nullable|boolean',
            'show_in_header' => 'nullable|boolean',
            'show_in_footer' => 'nullable|boolean',
            'index' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ];
    }
}
