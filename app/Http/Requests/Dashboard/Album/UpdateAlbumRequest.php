<?php

namespace App\Http\Requests\Dashboard\Album;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAlbumRequest extends FormRequest
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
            'order' => ['nullable'],
            'status' => ['nullable','boolean'],
            'show_in_home' => ['nullable','boolean'],
            'show_in_header' => ['nullable','boolean'],
            'show_in_footer' => ['nullable','boolean'],
            'slug_en' => ['nullable','string','max:255'],
            'slug_ar' => ['nullable','string','max:255'],
            'meta_title_en' => ['nullable','string','max:255'],
            'meta_title_ar' => ['nullable','string','max:255'],
            'meta_desc_en' => ['nullable','string','max:255'],
            'meta_desc_ar' => ['nullable','string','max:255'],
            'short_desc_en' => ['nullable','string','max:255'],
            'short_desc_ar' => ['nullable','string','max:255'],
            'long_desc_en' => ['nullable','string','max:255'],
            'album_images.*' => 'image|max:1024',
        ];
    }
}