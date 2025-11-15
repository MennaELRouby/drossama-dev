<?php

namespace App\Http\Requests\Dashboard\Album;

use App\Models\Album;
use App\Rules\UniqueSlug;
use Illuminate\Foundation\Http\FormRequest;

class StoreAlbumRequest extends FormRequest
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
            'name_en' => ['required', 'string', new UniqueSlug(Album::class, 'slug_en')],
            'name_ar' => ['required', 'string', new UniqueSlug(Album::class, 'slug_ar')],
            'description_en' => ['nullable', 'string'],
            'description_ar' => ['nullable', 'string'],
            'order' => ['nullable'],
            'status' => ['nullable','boolean'],
            'show_in_home' => ['nullable','boolean'],
            'show_in_header' => ['nullable','boolean'],
            'show_in_footer' => ['nullable','boolean'],
            'slug_en' => ['nullable','string','max:255'],
            'slug_ar' => ['nullable','string','max:255'],
            'meta_title_en' => ['nullable','string','max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,gif,bmp,webp', 'max:2048'],
            'icon' => ['nullable','image', 'mimes:jpeg,png,gif,bmp,webp','max:1024'],
            'album_images.*' => 'image|max:1024',
        ];
    }
}
