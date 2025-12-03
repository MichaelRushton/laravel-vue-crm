<?php

declare(strict_types=1);

namespace App\Http\Requests\Customer;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreCustomerRequest extends FormRequest
{
    public function authorize(): true
    {

        Gate::authorize('create', Customer::class);

        return true;

    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:customers', 'max:255'],
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
        ];
    }
}
