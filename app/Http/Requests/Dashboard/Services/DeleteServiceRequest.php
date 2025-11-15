<?php

namespace App\Http\Requests\Dashboard\Services;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class DeleteServiceRequest extends FormRequest
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
            'selectedIds.*' => ['integer', 'exists:services,id']
        ];
    }

    protected function prepareForValidation()
    {
        $service = $this->route('service');
        $serviceId = is_object($service) ? $service->id : $service;

        Log::info('DeleteServiceRequest prepareForValidation', [
            'service' => $service,
            'service_type' => gettype($service),
            'service_id' => $serviceId,
            'has_selectedIds' => $this->has('selectedIds'),
            'selectedIds_from_request' => $this->input('selectedIds', []),
            'all_request_data' => $this->all(),
            'route_name' => $this->route()->getName()
        ]);

        // If no selectedIds from request, use the single service ID (only for single delete)
        if ((!$this->has('selectedIds') || empty($this->input('selectedIds'))) && $serviceId) {
            $this->merge([
                'selectedIds' => [$serviceId]
            ]);
        }
    }
}
