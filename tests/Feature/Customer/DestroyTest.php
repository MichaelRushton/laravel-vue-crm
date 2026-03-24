<?php

declare(strict_types=1);

use App\Models\Customer;
use App\Models\User;

test('must be authenticated to trash customer', function () {

    $this->delete(route('customers.destroy', Customer::factory()->create()))
        ->assertRedirectToRoute('login');

});

test('must find customer', function () {

    $this->actingAs(User::factory()->create())
        ->delete(route('customers.destroy', Customer::factory()->create()->delete()))
        ->assertNotFound();

});

test('trash customer', function () {

    $this->actingAs(User::factory()->create())
        ->delete(route('customers.destroy', $customer = Customer::factory()->create()))
        ->assertRedirectToRoute('customers.index');

    $customer->refresh();

    expect($customer->trashed())
        ->toBeTrue();

});

test('creates revision', function () {

    $this->actingAs($user = User::factory()->create())
        ->delete(route('customers.destroy', $customer = Customer::factory()->create()));

    $customer->refresh();

    expect($customer->revisions()->count())
        ->toBe(2);

    $revision = $customer->revisions->last();

    expect([
        $revision->customer_id,
        $revision->uuid,
        $revision->first_name,
        $revision->last_name,
        $revision->email,
        $revision->trashed,
        $revision->created_by,
        $revision->impersonated_by,
    ])
        ->toBe([
            $customer->id,
            $customer->uuid,
            $customer->first_name,
            $customer->last_name,
            $customer->email,
            true,
            $user->id,
            null,
        ]);

});
