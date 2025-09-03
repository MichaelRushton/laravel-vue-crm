<?php

use App\Models\Customer;
use App\Models\User;

test('must be authenticated to delete customer', function () {

    $this->delete(route('customers.destroy', Customer::factory()->create()))
        ->assertRedirectToRoute('login');

});

test('can delete customer', function () {

    $customer = Customer::factory()->create();

    expect($customer->trashed())
        ->toBeFalse();

    $this->actingAs(User::factory()->create())
        ->delete(route('customers.destroy', $customer))
        ->assertSessionHasNoErrors()
        ->assertRedirectToRoute('customers.index');

    $customer->refresh();

    expect($customer->trashed())
        ->toBeTrue();

});
