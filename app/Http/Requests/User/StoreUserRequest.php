<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use App\Services\PasswordService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize(): true
    {

        Gate::authorize('create', User::class);

        return true;

    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'role' => ['required', Rule::enum(UserRole::class)],
            'status' => ['required', Rule::enum(UserStatus::class)],
            'password' => ['required', 'string', Password::min(PasswordService::MIN_LENGTH)],
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
            'password.required' => 'Please enter a password.',
            'password.string' => 'Please enter a password.',
            'password.min' => 'The password must be at least :min characters.',
        ];
    }
}
