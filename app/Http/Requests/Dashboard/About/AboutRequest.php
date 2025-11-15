<?php

namespace App\Http\Requests\Dashboard\About;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HasMultilingualValidation;

class AboutRequest extends FormRequest
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

            'image' => 'nullable|image|mimes:jpeg,png,gif,bmp,webp|max:1024', // Optional image validation
            'alt_image' => 'nullable|string',
            'banner' => 'nullable|image|max:3072', // Optional image validation
            'alt_banner' => 'nullable|string',
            'video_link' => 'nullable|string|max:500',

        ];
        // Add multilingual validation rules
        $rules = array_merge($rules, $this->getMultilingualRules());

        return $rules;
    }
}