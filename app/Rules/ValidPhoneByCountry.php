<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;

class ValidPhoneByCountry implements Rule
{
    protected $countryCode;
    protected $message;

    public function __construct($countryCode)
    {
        $this->countryCode = $countryCode;
    }

    public function passes($attribute, $value)
    {
        // Allow empty values
        if (empty($value)) {
            return true;
        }

        $patterns = [
            '+1'    => '/^\d{10}$/',
            '+44'   => '/^\d{10}$/',
            '+971'  => '/^[5]\d{8}$/', // UAE mobile numbers start with 5
            '+20'   => '/^[0-9]{9,10}$/', // Egypt numbers (9-10 digits)
            '+91'   => '/^[6-9]\d{9}$/', // India mobile numbers start with 6-9
            '+966'  => '/^5\d{8}$/', // Saudi mobile numbers start with 5
            '+33'   => '/^\d{9}$/',
            '+49'   => '/^\d{10}$/',
            '+81'   => '/^\d{10}$/',
            '+86'   => '/^1[3-9]\d{9}$/', // China mobile numbers start with 1
            '+55'   => '/^\d{10,11}$/',
            '+7'    => '/^\d{10}$/',
            '+61'   => '/^4\d{8}$/', // Australia mobile numbers start with 4
            '+34'   => '/^[6-7]\d{8}$/', // Spain mobile numbers start with 6 or 7
            '+39'   => '/^3\d{8,9}$/', // Italy mobile numbers start with 3
            '+62'   => '/^8\d{8,12}$/', // Indonesia mobile numbers start with 8
            '+234'  => '/^[789]\d{9}$/', // Nigeria mobile numbers start with 7, 8, or 9
            '+92'   => '/^3\d{9}$/', // Pakistan mobile numbers start with 3
            '+27'   => '/^[6-8]\d{8}$/', // South Africa mobile numbers start with 6, 7, or 8
        ];

        if (!isset($patterns[$this->countryCode])) {
            $this->message = __('Invalid country code.');
            return false;
        }

        if (!preg_match($patterns[$this->countryCode], $value)) {
            $this->message = __('Invalid phone number format for ') . $this->countryCode;
            return false;
        }

        return true;
    }

    public function message()
    {
        return $this->message;
    }
}