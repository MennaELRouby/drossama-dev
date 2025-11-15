<?php

namespace App\Http\Requests\Dashboard\Services;

use App\Models\Service;
use App\Rules\UniqueSlug;
use App\Traits\HasMultilingualValidation;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
            'order' => ['nullable', 'integer', 'min:0'],
            'parent_id' => ['nullable'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,gif,bmp,webp', 'max:2048'],
            'icon' => ['nullable', 'mimes:jpeg,png,gif,bmp,webp', 'max:2048'],
            'alt_image' => ['nullable', 'string', 'max:255'],
            'alt_icon' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'boolean'],
            'show_in_home' => ['nullable', 'boolean'],
            'show_in_header' => ['nullable', 'boolean'],
            'show_in_footer' => ['nullable', 'boolean'],
            'index' => ['nullable', 'boolean'],
            'service_images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
        ];

        // Add multilingual validation rules
        $rules = array_merge($rules, $this->getMultilingualRules());

        return $rules;
    }
}
