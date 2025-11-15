<?php

namespace App\Http\Requests\Dashboard\GalleryVideos;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'title_ar' => ['required','string','max:255'],
            'title_en' => ['required','string','max:255'],
            'video_url' => ['required','string','max:255'],
            'description_ar' => ['nullable','string'],
            'description_en' => ['nullable','string'],
            'image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
            'icon' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
            'status' => ['nullable','boolean'],
        ];
    }
}
