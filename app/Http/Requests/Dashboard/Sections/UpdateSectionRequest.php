<?php

namespace App\Http\Requests\Dashboard\Sections;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HasMultilingualValidation;
class UpdateSectionRequest extends FormRequest
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
            'key' => ['required', 'string', 'unique:sections,key,' . $this->section->id],
          
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp'],
            'alt_image' => ['nullable', 'string'],
            'icon' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp'],
            'alt_icon' => ['nullable', 'string'],
            'status' => ['nullable', 'boolean'],
         
        ];

        // Add multilingual validation rules
        $rules = array_merge($rules, $this->getMultilingualRules());

        return $rules;
    }
}