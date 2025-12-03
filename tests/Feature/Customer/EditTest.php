<?php

declare(strict_types=1);

use App\Models\Customer;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

test('must be signed in to view edit customer page', function () {

    $this->get(route('customers.edit', User::factory()->create()))
        ->assertRedirectToRoute('login');

});

test('view edit customer page', function () {

    $this->actingAs(User::factory()->create())
        ->get(route('customers.edit', $customer = Customer::factory()->create()))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Customers/Edit')
            ->has('customer', fn (AssertableInertia $page) => $page
                ->where('uuid', $customer->uuid)
                ->where('first_name', $customer->first_name)
                ->where('last_name', $customer->last_name)
                ->where('email', $customer->email)
            )
        );

});
