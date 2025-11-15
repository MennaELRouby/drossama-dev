<?php

namespace App\Http\Requests\Dashboard\Pages;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePageRequest extends FormRequest
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
            'title_en' => ['required','string','max:255','unique:pages,title_en,' . $this->route('page')->id],
            'title_ar' => ['required', 'string', 'max:255' , 'unique:pages,title_ar,' . $this->route('page')->id],
            'content_en' => ['nullable','string'],
            'content_ar' => ['nullable','string'],
            'slug_en' => ['required','string','max:255','unique:pages,slug_en,' . $this->route('page')->id],
            'slug_ar' => ['required','string','max:255','unique:pages,slug_ar,' . $this->route('page')->id],
            'status' => ['nullable','boolean']
        ];
    }
}
