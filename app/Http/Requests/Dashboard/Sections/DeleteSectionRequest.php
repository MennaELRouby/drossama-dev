<?php

namespace App\Http\Requests\Dashboard\Sections;

use Illuminate\Foundation\Http\FormRequest;

class DeleteSectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Get the section ID from the route parameter
        $sectionId = $this->route('section');
        
        // If it's an object, get the ID
        if (is_object($sectionId)) {
            $sectionId = $sectionId->id;
        }
        
        // If selectedIds is not present or empty, and we have a section ID, use it
        if ((!$this->has('selectedIds') || empty($this->input('selectedIds'))) && $sectionId) {
            $this->merge([
                'selectedIds' => [$sectionId]
            ]);
        }
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
            'selectedIds.*' => ['exists:sections,id']
        ];
    }
}