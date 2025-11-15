<?php

namespace App\Http\Requests\Dashboard\Testimonials;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HasMultilingualValidation;

class UpdateTestimonialsRequest extends FormRequest
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

            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'alt_image' => 'nullable|string|max:255',
            'video_link' => 'nullable|string|max:500',
            'status' => 'nullable|boolean',

        ];

        // Add multilingual validation rules
        $rules = array_merge($rules, $this->getMultilingualRules());

        return $rules;
    }
}
