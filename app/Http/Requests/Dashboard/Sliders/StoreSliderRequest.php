<?php

namespace App\Http\Requests\Dashboard\Sliders;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HasMultilingualValidation;

class StoreSliderRequest extends FormRequest
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
            'image' => ['nullable', 'image', 'mimes:jpeg,png,gif,bmp,webp', 'max:2048'],
            'mobile_image' => ['nullable', 'image', 'mimes:jpeg,png,gif,bmp,webp', 'max:1024'],
            'alt_image' => ['nullable', 'string', 'max:255'],
            'alt_mobile_image' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer'],
            'type' => ['nullable', 'string', 'in:top_header,middle,bottom'],
            'language' => ['nullable', 'string', 'in:all,en,ar']
        ];

        // Add multilingual validation rules for slider fields
        $rules = array_merge($rules, $this->getMultilingualRules(['title', 'title2', 'text']));

        // Make title required for English and Arabic
        $rules['title_en'] = ['required', 'string', 'max:255'];
        $rules['title_ar'] = ['required', 'string', 'max:255'];

        return $rules;
    }
}
