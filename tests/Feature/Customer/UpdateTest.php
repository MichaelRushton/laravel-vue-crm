<?php

declare(strict_types=1);

use App\Models\Customer;
use App\Models\User;

test('must be authenticated to update customer', function () {

    $this->patch(route('customers.update', Customer::factory()->create()))
        ->assertRedirectToRoute('login');

});

test('validates first name', function ($first_name) {

    $this->actingAs(User::factory()->create())
        ->patch(route('customers.update', Customer::factory()->create()), [
            'first_name' => $first_name,
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['first_name']);

})
    ->with(['', str_repeat('a', 256)]);

test('validates last name', function ($last_name) {

    $this->actingAs(User::factory()->create())
        ->patch(route('customers.update', Customer::factory()->create()), [
            'last_name' => $last_name,
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['last_name']);

})
    ->with(['', str_repeat('a', 256)]);

test('validates email address', function ($email) {

    $this->actingAs(User::factory()->create())
        ->patch(route('customers.update', Customer::factory()->create()), [
            'email' => $email,
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['email']);

})
    ->with(['', 'test', 'test@', '@example.com', str_repeat('a', 244).'@example.com']);

test('email address must be unique', function () {

    $this->actingAs(User::factory()->create())
        ->patch(route('customers.update', Customer::factory()->create()), [
            'email' => Customer::factory()->create()->email,
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['email']);

});

test('update customer', function () {

    $this->actingAs(User::factory()->create())
        ->patch(route('customers.update', $customer = Customer::factory()->create()), [
            'first_name' => $first_name = fake()->firstName(),
            'last_name' => $last_name = fake()->lastName(),
            'email' => $email = fake()->safeEmail(),
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirectToRoute('customers.index');

    $customer->refresh();

    expect([
        $customer->first_name,
        $customer->last_name,
        $customer->email,
    ])
        ->toBe([
            $first_name,
            $last_name,
            $email,
        ]);

});

test('creates revision', function () {

    $this->actingAs($user = User::factory()->create())
        ->patch(route('customers.update', $customer = Customer::factory()->create()), [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->safeEmail(),
        ]);

    $customer->refresh();

    expect($customer->revisions()->count())
        ->toBe(2);

    $revision = $customer->revisions->last();

    expect([
        $revision->customer_id,
        $revision->first_name,
        $revision->last_name,
        $revision->email,
        $revision->created_by,
        $revision->impersonated_by,
        $revision->customer->id,
    ])
        ->toBe([
            $customer->id,
            $customer->first_name,
            $customer->last_name,
            $customer->email,
            $user->id,
            null,
            $customer->id,
        ]);

});

test('does not update if nothing changed', function () {

    $this->actingAs(User::factory()->create())
        ->patch(route('customers.update', $customer = Customer::factory()->create()));

    expect($customer->revisions()->count())
        ->toBe(1);

});
