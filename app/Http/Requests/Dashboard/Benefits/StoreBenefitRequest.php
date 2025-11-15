<?php

namespace App\Http\Requests\Dashboard\Benefits;

use Illuminate\Foundation\Http\FormRequest;

class StoreBenefitRequest extends FormRequest
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
            'benefitable_id' => 'nullable|integer',
            'benefitable_type' => 'nullable|string',
            'title_en' => 'nullable|string|max:255',
            'title_ar' => 'nullable|string|max:255',
            'short_description_en' => 'nullable|string|max:255',
            'short_description_ar' => 'nullable|string|max:255',
            'long_description_en' => 'nullable|string',
            'long_description_ar' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'nullable|boolean',
            'order' => 'nullable|integer|min:0',
            'alt_image' => 'nullable|string|max:255',
            'alt_icon' => 'nullable|string|max:255',
        ];
    }
}
