<?php

namespace App\Http\Requests\Dashboard\Menus;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuRequest extends FormRequest
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
            'name_en' => ['nullable','string'],
            'name_ar' => ['nullable','string'],
            'parent_id' => ['nullable'],
            'segment' => ['nullable','string'],
            'status' => ['nullable','boolean'],
            'type' => ['nullable','string'],
            'order' => ['nullable','integer']
            
        ];
    }
}
