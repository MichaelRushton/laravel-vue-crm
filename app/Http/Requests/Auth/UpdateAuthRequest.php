<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Services\PasswordService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateAuthRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['sometimes', 'required', 'string', 'max:255'],
            'last_name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'email', 'max:255', Rule::unique('users')->ignore($this->user())],
            'password' => ['sometimes', 'nullable', 'exclude_if:password,null', 'string', Password::min(PasswordService::MIN_LENGTH)],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Please enter your first name.',
            'first_name.string' => 'Please enter your first name.',
            'last_name.required' => 'Please enter your last name.',
            'last_name.string' => 'Please enter your last name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter your email address.',
            'email.unique' => 'This email address has been taken.',
            'password.min' => 'Your password must be at least :min characters.',
        ];
    }
}
