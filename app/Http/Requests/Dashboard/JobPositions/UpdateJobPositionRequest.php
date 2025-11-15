<?php

namespace App\Http\Requests\Dashboard\JobPositions;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobPositionRequest extends FormRequest
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
            'title_ar' => ['nullable', 'string', 'max:255', 'unique:job_positions,title_ar,' . $this->route('job_position')->id],
            'title_en' => ['nullable', 'string', 'max:255', 'unique:job_positions,title_en,' . $this->route('job_position')->id],
            'description_ar' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'alt_image' => ['nullable', 'string', 'max:255'],
            'icon' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'alt_icon' => ['nullable', 'string', 'max:255'],
            'type' => ['nullable', 'in:full-time,part-time,contract'],
            'status' => ['nullable', 'boolean'],
        ];
    }
}
