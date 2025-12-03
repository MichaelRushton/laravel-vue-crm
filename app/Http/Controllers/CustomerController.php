<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Resources\Customer\CustomerIndexResource;
use App\Http\Resources\Customer\EditCustomerResource;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Response;

class CustomerController extends Controller
{
    public function index(Request $request): Response
    {

        Gate::authorize('viewAny', Customer::class);

        $customers = CustomerIndexResource::collection(
            Customer::search($request->name, ['first_name', 'last_name'])
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->orderBy('id')
                ->cursorPaginate((int) ($request->per_page ?: 100))
        );

        return inertia('Customers/Index', [
            'customers' => inertia()->scroll($customers),
            'search' => [
                'name' => $request->name,
            ],
        ]);

    }

    public function create(): Response
    {

        Gate::authorize('create', Customer::class);

        return inertia('Customers/Edit');

    }

    public function store(StoreCustomerRequest $request): RedirectResponse
    {

        Customer::create($request->validated());

        return to_route('customers.index')->withFlash([
            'success' => 'The customer has been created.',
        ]);

    }

    public function edit(Customer $customer): Response
    {

        Gate::authorize('update', $customer);

        return inertia('Customers/Edit', [
            'customer' => new EditCustomerResource($customer),
        ]);

    }

    public function update(Customer $customer, UpdateCustomerRequest $request): RedirectResponse
    {

        $customer->updateIfDirty($request->validated());

        return to_route('customers.index')->withFlash([
            'success' => 'The customer has been updated.',
        ]);

    }
}
