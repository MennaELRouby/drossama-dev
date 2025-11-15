<?php

namespace App\Http\Requests\Dashboard\Blogs;

use Illuminate\Foundation\Http\FormRequest;

class DeleteBlogRequest extends FormRequest
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
            'selectedIds' => ['array', 'min:1'],
            'selectedIds.*' => ['exists:blogs,id']
        ];
    }

    protected function prepareForValidation()
    {
        $blog = $this->route('blog');
        $blogId = is_object($blog) ? $blog->id : $blog;

        // If no selectedIds from request, use the single blog ID
        if (!$this->has('selectedIds') || empty($this->input('selectedIds'))) {
            $this->merge([
                'selectedIds' => [$blogId]
            ]);
        }
    }
}
