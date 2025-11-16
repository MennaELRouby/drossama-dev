<?php

namespace App\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Validator;

class StoreContactUsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'phone' => ['required'],
            'email' => ['required', 'email'],
            'message' => ['nullable'],
            'company' => ['nullable'],
            // 'recaptcha_token' => ['required'], // نتحقق منه يدويًا
        ];
    }

    // public function withValidator($validator)
    // {
    //     $validator->after(function ($validator) {
    //         $token = $this->input('recaptcha_token');

    //         if (!$token) {
    //             $validator->errors()->add('recaptcha_token', 'التحقق من reCAPTCHA مطلوب.');
    //             return;
    //         }

    //         $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
    //             'secret' => config('services.recaptcha.secret'),
    //             'response' => $token,
    //             'remoteip' => $this->ip(),
    //         ]);

    //         if (!$response->json('success')) {
    //             $validator->errors()->add('recaptcha_token', 'فشل التحقق من أنك لست روبوت.');
    //         }
    //     });
    // }
}
