<?php

namespace App\Http\Requests\Dashboard\Domains;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDomainRequest extends FormRequest
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
            'title_en' => ['required','string'],
            'title_ar' => ['required','string'],
            'yearly_price' => ['nullable'],
            'transfer_price' => ['nullable'],
            'renewal_price' => ['nullable'],
            'short_desc_en' => ['nullable'],
            'short_desc_ar' => ['nullable'],
            'status' => ['nullable','boolean'],
            'slug_ar' => ['nullable'],
            'slug_en' => ['nullable'],
            'meta_title_en' => ['nullable','string','max:255'],
            'meta_title_ar' => ['nullable','string','max:255'],
            'meta_desc_ar' => ['nullable','string'],
            'meta_desc_en' => ['nullable','string'],
            'index' => ['nullable','boolean'],
        ];
    }
}
