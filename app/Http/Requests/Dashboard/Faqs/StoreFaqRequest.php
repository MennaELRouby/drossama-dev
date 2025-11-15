<?php

namespace App\Http\Requests\Dashboard\Faqs;

use Illuminate\Foundation\Http\FormRequest;

class StoreFaqRequest extends FormRequest
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
                'question_en' => 'required|string|max:255',
                'question_ar' => 'required|string|max:255',
                'answer_en' => 'required|string',
                'answer_ar' => 'required|string',
                'faqable_id' => 'nullable|integer',
                'faqable_type' => 'nullable|string',
                'status' => 'nullable|boolean',
                'order' => 'nullable|integer'
        ];
    }
}
