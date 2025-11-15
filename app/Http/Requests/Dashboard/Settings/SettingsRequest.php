<?php

namespace App\Http\Requests\Dashboard\Settings;

use App\Rules\ValidPhoneByCountry;
use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
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
            'site_email' => 'nullable|email|max:255',
            'notification_emails' => ['nullable', 'string', function ($attribute, $value, $fail) {
                if (empty($value)) {
                    return;
                }

                // Split by comma or newline
                $emails = preg_split('/[\n,]+/', $value);

                foreach ($emails as $email) {
                    $email = trim($email);
                    if (empty($email)) {
                        continue;
                    }

                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $fail(app()->getLocale() === 'ar'
                            ? "البريد الإلكتروني '{$email}' غير صحيح"
                            : "The email '{$email}' is not valid");
                        return;
                    }
                }
            }],

            'site_facebook' => 'nullable|string|max:255',
            'site_twitter' => 'nullable|string|max:255',
            'site_instagram' => 'nullable|string|max:255',
            'site_linkedin' => 'nullable|string|max:255',
            'site_youtube' => 'nullable|string|max:255',
            'site_snapchat' => 'nullable|string|max:255',
            'site_tiktok' => 'nullable|string|max:255',
            'site_pinterest' => 'nullable|string|max:255',
            'site_telegram' => 'nullable|string|max:255',
            'site_map' => 'nullable|string',
            'google_analytics_id' => 'nullable|string|max:255|regex:/^G-[A-Z0-9]{10}$/',
            'google_tag_manager_id' => 'nullable|string|max:255|regex:/^GTM-[A-Z0-9]{7,10}$/',
            'country_code' => ['required', 'string'],

            'site_whatsapp' => [
                'nullable',
                'string',
                new ValidPhoneByCountry($this->input('country_code'))
            ],

            'phone' => [
                'nullable',
                'string',
                new ValidPhoneByCountry($this->input('country_code'))
            ],

            // PWA Manifest Settings - Arabic
            'site_short_name_ar' => 'nullable|string|max:500',
            'site_description_ar' => 'nullable|string|max:500',

            // PWA Manifest Settings - English
            'site_short_name_en' => 'nullable|string|max:500',
            'site_description_en' => 'nullable|string|max:500',

            // PWA Manifest Settings - Common
            'theme_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'background_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'google_analytics_id.regex' => app()->getLocale() === 'ar'
                ? 'معرف جوجل أناليتكس يجب أن يكون بالتنسيق G-XXXXXXXXXX (10 أحرف بعد G-)'
                : 'Google Analytics ID must be in the format G-XXXXXXXXXX (10 characters after G-)',
            'google_tag_manager_id.regex' => app()->getLocale() === 'ar'
                ? 'معرف جوجل تاج مانجر يجب أن يكون بالتنسيق GTM-XXXXXXX إلى GTM-XXXXXXXXXX (7-10 أحرف بعد GTM-)'
                : 'Google Tag Manager ID must be in the format GTM-XXXXXXX to GTM-XXXXXXXXXX (7-10 characters after GTM-)',
        ];
    }
}
