<?php

declare(strict_types=1);

namespace App\Http\Requests\PasswordReset;

use Illuminate\Foundation\Http\FormRequest;

class StorePasswordResetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter your email address.',
        ];
    }
}
