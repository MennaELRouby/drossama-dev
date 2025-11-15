<?php

namespace App\Http\Requests\Dashboard\Clients;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
           'logo' => ['nullable','image','mimes:jpeg,png,jpg,gif,webp','max:2048'],
           'description_en' => ['nullable','string'],
           'description_ar' => ['nullable','string'],
           'status' => ['nullable','boolean'],
           
        ];
    }
}
