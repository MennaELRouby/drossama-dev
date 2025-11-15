<?php

namespace App\Http\Requests\Dashboard\SiteAddresses;

use Illuminate\Foundation\Http\FormRequest;

class DeleteSiteAddressRequest extends FormRequest
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
            'selectedIds.*' => ['exists:site_addresses,id']
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Get the site_address ID from the route parameter
        $siteAddress = $this->route('site_address');
        $siteAddressId = is_object($siteAddress) ? $siteAddress->id : $siteAddress;

        // If no selectedIds from request, use the single site_address ID
        if ((!$this->has('selectedIds') || empty($this->input('selectedIds'))) && $siteAddressId) {
            $this->merge([
                'selectedIds' => [$siteAddressId]
            ]);
        }
    }
}
