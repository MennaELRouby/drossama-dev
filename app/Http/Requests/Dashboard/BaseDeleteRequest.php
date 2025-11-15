<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'selectedIds' => ['sometimes', 'array', 'min:1'],
            'selectedIds.*' => ['required', 'integer', 'exists:' . $this->getTable() . ',id']
        ];
    }

    protected function prepareForValidation()
    {
        // Try to get the ID from common route parameter names
        $id = $this->route('id') ?? $this->route('product') ?? $this->route('service') ?? $this->route('project');
        $modelId = is_object($id) ? $id->id : $id;

        // If no selectedIds from request, use the single model ID
        if ((!$this->has('selectedIds') || empty($this->input('selectedIds'))) && $modelId) {
            $this->merge([
                'selectedIds' => [$modelId]
            ]);
        }
    }

    abstract protected function getTable(): string;
}
