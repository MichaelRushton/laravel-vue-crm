<?php

declare(strict_types=1);

use App\Models\Customer;
use App\Models\User;

test('must be signed in to view customer', function () {

    $this->get(route('customers.show', User::factory()->create()))
        ->assertRedirectToRoute('login');

});

test('must find customer', function () {

    $this->actingAs(User::factory()->create())
        ->get(route('customers.show', Customer::factory()->create()->delete()))
        ->assertNotFound();

});

test('view customer', function () {

    $this->actingAs(User::factory()->create())
        ->get(route('customers.show', $customer = Customer::factory()->create()))
        ->assertJson([
            'customer' => [
                'uuid' => $customer->uuid,
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'email' => $customer->email,
            ],
        ]);

});
