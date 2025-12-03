<?php

declare(strict_types=1);

use App\Models\Customer;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

test('must be signed in to view customer index page', function () {

    $this->get(route('customers.index'))
        ->assertRedirectToRoute('login');

});

test('view customer index page', function () {

    Customer::factory(10)->create();

    $this->actingAs(User::factory()->create())
        ->get(route('customers.index'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Customers/Index')
            ->has('customers.data', 10)
        );

});

test('search customers by first name', function () {

    Customer::factory(9)->create([
        'first_name' => 'test',
        'last_name' => 'test',
    ]);

    $customer = Customer::factory()->create([
        'first_name' => 'first_name',
        'last_name' => 'test',
    ]);

    $this->actingAs(User::factory()->create())
        ->get(route('customers.index', [
            'name' => 'first_name',
        ]))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->has('customers.data', 1, fn (AssertableInertia $page) => $page
                ->where('uuid', $customer->uuid)
                ->etc()
            )
        );

});

test('search customers by last name', function () {

    Customer::factory(9)->create([
        'first_name' => 'test',
        'last_name' => 'test',
    ]);

    $customer = Customer::factory()->create([
        'first_name' => 'test',
        'last_name' => 'last_name',
    ]);

    $this->actingAs(User::factory()->create())
        ->get(route('customers.index', [
            'name' => 'last_name',
        ]))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->has('customers.data', 1, fn (AssertableInertia $page) => $page
                ->where('uuid', $customer->uuid)
                ->etc()
            )
        );

});

test('search customers by full name', function () {

    Customer::factory(9)->create([
        'first_name' => 'test',
        'last_name' => 'test',
    ]);

    $customer = Customer::factory()->create([
        'first_name' => 'first_name',
        'last_name' => 'last_name',
    ]);

    $this->actingAs(User::factory()->create())
        ->get(route('customers.index', [
            'name' => 'first_name last_name',
        ]))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->has('customers.data', 1, fn (AssertableInertia $page) => $page
                ->where('uuid', $customer->uuid)
                ->etc()
            )
        );

});
