<?php

use App\Models\Customer;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

test('must be signed in to view customer index page', function () {

    $this->get(route('customers.index'))
        ->assertRedirectToRoute('login');

});

test('can view user index page', function () {

    Customer::factory(10)->create();

    $this->actingAs(User::factory()->create())
        ->get(route('customers.index'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Customers/Index')
            ->has('customers.data', 10)
        );

});

test('can search customers', function () {

    Customer::factory(9)->create([
        'first_name' => 'test',
        'last_name' => 'test',
    ]);

    $customer = Customer::factory()->create(['first_name' => 'customer']);

    $this->actingAs(User::factory()->create())
        ->get(route('customers.index', [
            'search' => 'customer',
        ]))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Customers/Index')
            ->has('customers.data', 1, fn (AssertableInertia $page) => $page
                ->where('id', $customer->id)
                ->where('first_name', $customer->first_name)
                ->where('last_name', $customer->last_name)
            )
        );

});
