<?php

namespace App\Http\Requests\Dashboard\Projects;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\UniqueJsonSlug;

class UpdateProjectRequest extends FormRequest
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
            'name_en' => ['nullable', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],
            'order' => ['nullable', 'integer', 'min:0'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'parent_id' => ['nullable', 'exists:projects,id'],
            'slug_ar' => ['nullable', 'string', new UniqueJsonSlug('App\Models\Project', 'slug', 'ar', $this->project->id)],
            'slug_en' => ['nullable', 'string', new UniqueJsonSlug('App\Models\Project', 'slug', 'en', $this->project->id)],
            'short_desc_en' => ['nullable', 'string'],
            'short_desc_ar' => ['nullable', 'string'],
            'long_desc_en' => ['nullable', 'string'],
            'long_desc_ar' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:1024'],
            'alt_image' => ['nullable', 'string'],
            'icon' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:1024'],
            'alt_icon' => ['nullable', 'string'],
            'status' => ['nullable', 'boolean'],
            'show_in_home' => ['nullable', 'boolean'],
            'show_in_header' => ['nullable', 'boolean'],
            'show_in_footer' => ['nullable', 'boolean'],
            'meta_title_ar' => ['nullable', 'string', 'max:255'],
            'meta_title_en' => ['nullable', 'string', 'max:255'],
            'meta_desc_ar' => ['nullable', 'string'],
            'meta_desc_en' => ['nullable', 'string'],
            'index' => ['nullable', 'boolean'],
            'clients_en' => ['nullable', 'string'],
            'location_en' => ['nullable', 'string'],
            'date' => ['nullable', 'date'],
            'category_en' => ['nullable', 'string'],
            'service_en' => ['nullable', 'string'],
            'clients_ar' => ['nullable', 'string'],
            'location_ar' => ['nullable', 'string'],
            'category_ar' => ['nullable', 'string'],
            'service_ar' => ['nullable', 'string'],
            'project_images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:1024'],

        ];
    }
}
