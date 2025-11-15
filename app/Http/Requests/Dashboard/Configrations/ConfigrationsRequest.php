<?php

namespace App\Http\Requests\Dashboard\Configrations;

use Illuminate\Foundation\Http\FormRequest;

class ConfigrationsRequest extends FormRequest
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
                'site_name' => 'required|string|max:255',
                'site_description' => 'nullable|string|',
                'site_footer_text' => 'nullable|string',
                'site_copyright' => 'nullable|string',
                'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'site_footer_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'site_favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                
        ];
    }
}