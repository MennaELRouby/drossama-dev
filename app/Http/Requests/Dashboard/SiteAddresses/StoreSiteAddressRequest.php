<?php

namespace App\Http\Requests\Dashboard\SiteAddresses;

use App\Rules\ValidPhoneByCountry;
use App\Traits\HasMultilingualValidation;
use Illuminate\Foundation\Http\FormRequest;

class StoreSiteAddressRequest extends FormRequest
{
    use HasMultilingualValidation;

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
        $rules = [
            'email' => 'nullable|email',
            'code' => 'required_with:phone',
            'phone' => [
                'nullable',
                new ValidPhoneByCountry($this->input('code')),
            ],
            'phone2' => [
                'nullable',
                new ValidPhoneByCountry($this->input('code2')),
            ],
            'code2' => 'required_with:phone2',
            'map_url' => 'nullable|string',
            'map_link' => 'nullable|string',
            'order' => 'nullable|integer',
            'status' => 'nullable|boolean'
        ];

        // Add multilingual validation rules
        $rules = array_merge($rules, $this->getMultilingualRules());

        return $rules;
    }
}
