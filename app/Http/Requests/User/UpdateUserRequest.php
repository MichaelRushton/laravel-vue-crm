<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Services\PasswordService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): true
    {

        Gate::authorize('update', $this->route('user'));

        return true;

    }

    public function rules(): array
    {
        return [
            'first_name' => ['sometimes', 'required', 'string', 'max:255'],
            'last_name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'email', 'max:255', Rule::unique('users')->ignore($this->route('user'))],
            'role' => ['sometimes', 'required', Rule::enum(UserRole::class)],
            'status' => ['sometimes', 'required', Rule::enum(UserStatus::class)],
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
            'role.required' => 'Please select a role.',
            'role.enum' => 'Please select a role.',
            'status.required' => 'Please select a status.',
            'status.enum' => 'Please select a status.',
            'password.min' => 'The password must be at least :min characters.',
        ];
    }
}
