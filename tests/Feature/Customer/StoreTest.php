<?php

declare(strict_types=1);

use App\Models\Customer;
use App\Models\User;

test('must be authenticated to create customer', function () {

    $this->post(route('customers.store'))
        ->assertRedirectToRoute('login');

});

test('requires first name', function () {

    $this->actingAs(User::factory()->create())
        ->post(route('customers.store'))
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['first_name']);

});

test('validates first name', function ($first_name) {

    $this->actingAs(User::factory()->create())
        ->post(route('customers.store'), [
            'first_name' => $first_name,
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['first_name']);

})
    ->with(['', str_repeat('a', 256)]);

test('requires last name', function () {

    $this->actingAs(User::factory()->create())
        ->post(route('customers.store'))
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['last_name']);

});

test('validates last name', function ($last_name) {

    $this->actingAs(User::factory()->create())
        ->post(route('customers.store'), [
            'last_name' => $last_name,
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['last_name']);

})
    ->with(['', str_repeat('a', 256)]);

test('requires email address', function () {

    $this->actingAs(User::factory()->create())
        ->post(route('customers.store'))
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['email']);

});

test('validates email address', function ($email) {

    $this->actingAs(User::factory()->create())
        ->post(route('customers.store'), [
            'email' => $email,
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['email']);

})
    ->with(['', 'test', 'test@', '@example.com', str_repeat('a', 244).'@example.com']);

test('email address must be unique', function () {

    $this->actingAs(User::factory()->create())
        ->post(route('customers.store'), [
            'email' => Customer::factory()->create()->email,
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['email']);

});

test('create customer', function () {

    $this->actingAs(User::factory()->create())
        ->post(route('customers.store'), [
            'first_name' => $first_name = fake()->firstName(),
            'last_name' => $last_name = fake()->lastName(),
            'email' => $email = fake()->safeEmail(),
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirectToRoute('customers.index');

    $customer = Customer::latest('id')->first();

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
        ->post(route('customers.store'), [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->safeEmail(),
        ]);

    $customer = Customer::latest('id')->first();

    expect($customer->revisions()->count())
        ->toBe(1);

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
