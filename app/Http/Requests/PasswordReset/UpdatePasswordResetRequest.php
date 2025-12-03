<?php

declare(strict_types=1);

namespace App\Http\Requests\PasswordReset;

use App\Services\PasswordService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordResetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'password' => ['required', 'string', Password::min(PasswordService::MIN_LENGTH)],
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'Please enter your password.',
            'password.string' => 'Please enter your password.',
            'password.min' => 'Your password must be at least :min characters.',
        ];
    }
}
