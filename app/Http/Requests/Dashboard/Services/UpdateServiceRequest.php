<?php

namespace App\Http\Requests\Dashboard\Services;

use App\Traits\HasMultilingualValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServiceRequest extends FormRequest
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
            'service_images.*' => 'image|max:2048',
        ];

        // Add multilingual validation rules
        $rules = array_merge($rules, $this->getMultilingualRules());

        return $rules;
    }
}
