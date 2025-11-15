<?php

namespace App\Http\Requests\Dashboard\Hostings;

use App\Models\Dashboard\Hosting;
use App\Rules\UniqueSlug;
use Illuminate\Foundation\Http\FormRequest;

class StoreHostingRequest extends FormRequest
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
            'name_en' => ['required', 'string', new UniqueSlug(Hosting::class, 'slug_en')],
            'name_ar' => ['required', 'string', new UniqueSlug(Hosting::class, 'slug_ar')],
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
            'meta_title_en' => ['nullable','string','max:255'],
            'meta_title_ar' => ['nullable','string','max:255'],
            'meta_desc_ar' => ['nullable','string'],
            'meta_desc_en' => ['nullable','string'],
            'index' => ['nullable','boolean'],
        ];
    }
}