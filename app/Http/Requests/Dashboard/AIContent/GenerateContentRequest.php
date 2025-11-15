<?php

namespace App\Http\Requests\Dashboard\AIContent;

use Illuminate\Foundation\Http\FormRequest;

class GenerateContentRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'type' => 'required|string|in:article,page,seo,title,description,keywords,text',
            'prompt' => 'required|string|max:2000',
            'options' => 'array',
            'options.max_tokens' => 'nullable|integer|min:100|max:4000',
            'options.temperature' => 'nullable|numeric|min:0|max:2',
            'options.word_count' => 'nullable|integer|min:50|max:5000',
            'options.count' => 'nullable|integer|min:1|max:20',
            'options.max_words' => 'nullable|integer|min:10|max:200',
            'options.page_type' => 'nullable|string|in:about,services,contact,privacy,terms',
            'options.content_type' => 'nullable|string',
            'options.system_prompt' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'type.required' => 'نوع المحتوى مطلوب',
            'type.in' => 'نوع المحتوى غير صحيح',
            'prompt.required' => 'النص المطلوب مطلوب',
            'prompt.max' => 'النص المطلوب يجب أن يكون أقل من 2000 حرف',
            'options.max_tokens.min' => 'الحد الأقصى للكلمات يجب أن يكون 100 على الأقل',
            'options.max_tokens.max' => 'الحد الأقصى للكلمات يجب أن يكون 4000 على الأكثر',
            'options.temperature.min' => 'درجة الحرارة يجب أن تكون 0 على الأقل',
            'options.temperature.max' => 'درجة الحرارة يجب أن تكون 2 على الأكثر',
            'options.word_count.min' => 'عدد الكلمات يجب أن يكون 50 على الأقل',
            'options.word_count.max' => 'عدد الكلمات يجب أن يكون 5000 على الأكثر',
            'options.count.min' => 'العدد يجب أن يكون 1 على الأقل',
            'options.count.max' => 'العدد يجب أن يكون 20 على الأكثر',
            'options.max_words.min' => 'الحد الأقصى للكلمات يجب أن يكون 10 على الأقل',
            'options.max_words.max' => 'الحد الأقصى للكلمات يجب أن يكون 200 على الأكثر',
            'options.page_type.in' => 'نوع الصفحة غير صحيح',
        ];
    }
} 