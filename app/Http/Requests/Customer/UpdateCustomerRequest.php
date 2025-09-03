<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize(): true
    {

        Gate::authorize('update', $this->route('customer'));

        return true;

    }

    public function rules(): array
    {
        return [
            'first_name' => ['sometimes', 'required', 'string'],
            'last_name' => ['sometimes', 'required', 'string'],
            'email' => ['sometimes', 'required', 'email', Rule::unique('customers')->ignore($this->route('customer'))],
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
        ];
    }
}
