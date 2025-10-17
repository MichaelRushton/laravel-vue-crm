<?php

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
            'first_name' => ['sometimes', 'required', 'string'],
            'last_name' => ['sometimes', 'required', 'string'],
            'email' => ['sometimes', 'required', 'email', Rule::unique('users')->ignore($this->user())],
            'password' => ['sometimes', 'nullable', 'exclude_if:password,null', 'string', Password::min(PasswordService::MIN_LENGTH)],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Please enter a first name.',
            'first_name.string' => 'Please enter a first name.',
            'last_name.required' => 'Please enter a last name.',
            'last_name.string' => 'Please enter a last name.',
            'email.required' => 'Please enter an email address.',
            'email.email' => 'Please enter an email address.',
            'email.unique' => 'This email address has been taken.',
            'password.min' => 'The password must be at least :min characters.',
        ];
    }
}
