<?php

use App\Models\Customer;
use App\Models\User;

test('must be authenticated to delete customer', function () {

    $this->patch(route('customers.restore', Customer::factory()->create()))
        ->assertRedirectToRoute('login');

});

test('can restore customer', function () {

    $customer = Customer::factory()->create();

    $customer->delete();

    expect($customer->trashed())
        ->toBeTrue();

    $this->actingAs(User::factory()->create())
        ->patch(route('customers.restore', $customer))
        ->assertSessionHasNoErrors()
        ->assertRedirectToRoute('customers.index');

    $customer->refresh();

    expect($customer->trashed())
        ->toBeFalse();

});
