<?php

namespace App\Http\Requests\Dashboard\Hostings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateHostingRequest extends FormRequest
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
            'name_en' => ['nullable','string','max:255'],
            'name_ar' => ['nullable','string','max:255'],
            'parent_id' => ['nullable'],
            'image' => ['nullable','image','mimes:jpeg,png,gif,bmp,webp','max:1024'],
            'icon' => ['nullable','mimes:jpeg,png,gif,bmp,webp','max:1024'],
            'alt_image' => ['nullable','string','max:255'],
            'alt_icon' => ['nullable','string','max:255'],
            'short_desc_en' => ['nullable','string'],
            'short_desc_ar' => ['nullable','string'],
            'long_desc_en' => ['nullable','string'],
            'long_desc_ar' => ['nullable','string'],
            'status' => ['nullable','boolean'],
            'show_in_home' => ['nullable','boolean'],
            'show_in_header' => ['nullable','boolean'],
            'slug_ar' => [Rule::unique('hostings', 'slug_ar')->ignore($this->hosting->id)],
            'slug_en' => [Rule::unique('hostings', 'slug_en')->ignore($this->hosting->id)],
            'meta_title_en' => ['nullable','string','max:255'],
            'meta_title_ar' => ['nullable','string','max:255'],
            'meta_desc_ar' => ['nullable','string'],
            'meta_desc_en' => ['nullable','string'],
            'index' => ['nullable','boolean'],
        ];
    }
}
