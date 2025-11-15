<?php

namespace App\Http\Requests\Dashboard\Blogs;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HasMultilingualValidation;

class StoreBlogRequest extends FormRequest
{
    use HasMultilingualValidation;

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
        $rules = [
            'category_id' => 'nullable|exists:blog_categories,id',
            'author_id' => 'nullable|exists:authors,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'alt_image' => 'nullable|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'alt_icon' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
            'show_in_home' => 'nullable|boolean',
            'show_in_header' => 'nullable|boolean',
            'show_in_footer' => 'nullable|boolean',
            'index' => 'nullable|boolean',
            'order' => 'nullable|integer',
            'date' => 'nullable|date',
        ];

        // Add multilingual validation rules
        $rules = array_merge($rules, $this->getMultilingualRules());

        return $rules;
    }
}