<?php

namespace App\Http\Requests\Dashboard\Admins;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
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


    public function rules()
    {
        // Assuming you are passing the admin ID via route model binding
        $adminId = $this->route('admin')->id;  // Get the admin ID from the route

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins,email,' . $adminId, // Exclude the current admin from unique validation
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string'],
            'password' => 'nullable|string|min:8|confirmed',  // Make password nullable if not changing
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Remove empty string from permissions array if it exists
        if ($this->has('permissions') && is_array($this->permissions)) {
            $permissions = array_filter($this->permissions, function ($value) {
                return !empty($value);
            });
            $this->merge(['permissions' => $permissions]);
        }
    }
}
