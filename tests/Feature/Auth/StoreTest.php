<?php

declare(strict_types=1);

use App\Models\SignIn;
use App\Models\User;

test('requires email address', function () {

    $this->post(route('auth.store'))
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['email']);

});

test('validates email address', function ($email) {

    $this->post(route('auth.store'), [
        'email' => $email,
    ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['email']);

})
    ->with(['', 'test', 'test@', '@example.com']);

test('requires password', function () {

    $this->post(route('auth.store'))
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['password']);

});

test('validates password', function ($password) {

    $this->post(route('auth.store'), [
        'password' => $password,
    ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['password']);

})
    ->with(['']);

test('requires known email address', function () {

    $this->post(route('auth.store', [
        'email' => fake()->safeEmail(),
        'password' => 'password1234',
    ]))
        ->assertRedirectBackWithErrors()
        ->assertInvalid('email');

});

test('records unknown email address attempt', function () {

    $this->post(route('auth.store', [
        'email' => $email = fake()->safeEmail(),
        'password' => 'password1234',
    ]));

    expect(SignIn::count())
        ->toBe(1);

    $sign_in = SignIn::latest('id')->first();

    expect($sign_in->email)
        ->toBe($email);

    expect($sign_in->user_id)
        ->toBeNull();

    expect($sign_in->correct_password)
        ->toBeNull();

});

test('requires correct password', function () {

    $this->post(route('auth.store', [
        'email' => User::factory()->create()->email,
        'password' => 'password',
    ]))
        ->assertRedirectBackWithErrors()
        ->assertInvalid('email');

});

test('records incorrect password attempt', function () {

    $user = User::factory()->create();

    $this->post(route('auth.store', [
        'email' => $user->email,
        'password' => 'password',
    ]));

    expect(SignIn::count())
        ->toBe(1);

    $sign_in = SignIn::latest('id')->first();

    expect($sign_in->email)
        ->toBe($user->email);

    expect($sign_in->user_id)
        ->toBe($user->id);

    expect($sign_in->correct_password)
        ->toBeFalse();

});

test('sign in', function () {

    $user = User::factory()->create();

    $this->post(route('auth.store', [
        'email' => $user->email,
        'password' => 'password1234',
    ]))
        ->assertSessionHasNoErrors()
        ->assertRedirectToRoute('dashboard.show');

    $this->assertAuthenticatedAs($user);

});

test('records successful sign in', function () {

    $user = User::factory()->create();

    $this->post(route('auth.store', [
        'email' => $user->email,
        'password' => 'password1234',
    ]));

    expect(SignIn::count())
        ->toBe(1);

    $sign_in = SignIn::latest('id')->first();

    expect($sign_in->email)
        ->toBe($user->email);

    expect($sign_in->user_id)
        ->toBe($user->id);

    expect($sign_in->correct_password)
        ->toBeTrue();

});
