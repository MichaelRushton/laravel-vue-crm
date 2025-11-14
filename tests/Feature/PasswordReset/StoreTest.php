<?php

declare(strict_types=1);

use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\PasswordResetNotification;
use Illuminate\Support\Facades\Notification;

test('requires email address', function () {

    $this->post(route('reset-password.store'))
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['email']);

});

test('validates email address', function ($email) {

    $this->post(route('reset-password.store'), [
        'email' => $email,
    ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['email']);

})
    ->with(['', 'test', 'test@', '@example.com']);

test('pretends to reset password if unknown email address', function () {

    $this->post(route('reset-password.store', [
        'email' => fake()->safeEmail(),
    ]))
        ->assertSessionHasNoErrors()
        ->assertRedirectToRoute('login');

    expect(PasswordReset::count())
        ->toBe(0);

});

test('creates password reset', function () {

    $user = User::factory()->create();

    $this->post(route('reset-password.store', [
        'email' => $user->email,
    ]))
        ->assertSessionHasNoErrors()
        ->assertRedirectToRoute('login');

    expect(PasswordReset::count())
        ->toBe(1);

    $password_reset = PasswordReset::latest('id')->first();

    expect($password_reset->user_id)
        ->toBe($user->id);

});

test('sends notification', function () {

    Notification::fake();

    $user = User::factory()->create();

    $this->post(route('reset-password.store', [
        'email' => $user->email,
    ]));

    Notification::assertSentTo(
        [$user], PasswordResetNotification::class
    );

});

test("won't create new password reset until previous expired", function () {

    $user = User::factory()->create();

    $this->post(route('reset-password.store', [
        'email' => $user->email,
    ]));

    $this->post(route('reset-password.store', [
        'email' => $user->email,
    ]));

    expect(PasswordReset::count())
        ->toBe(1);

    $this->travel(16)->minutes();

    $this->post(route('reset-password.store', [
        'email' => $user->email,
    ]));

    expect(PasswordReset::count())
        ->toBe(2);

});
