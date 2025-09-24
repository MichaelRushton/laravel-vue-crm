<?php

use App\Models\SignIn;
use App\Models\User;
use App\Services\PasswordService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

test('requires token', function () {

    $this->patch(route('password.update'))
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['token']);

});

test('validates token', function ($token) {

    $this->patch(route('password.update'), [
        'token' => $token,
    ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['token']);

})
    ->with(['']);

test('requires email address', function () {

    $this->patch(route('password.update'))
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['email']);

});

test('validates email address', function ($email) {

    $this->patch(route('password.update'), [
        'email' => $email,
    ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['email']);

})
    ->with(['', 'test', 'test@', '@example.com']);

test('requires password', function () {

    $this->patch(route('password.update'))
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['password']);

});

test('validates password', function ($password) {

    $this->patch(route('password.update'), [
        'password' => $password,
    ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['password']);

})
    ->with(['', str_repeat('a', PasswordService::MIN_LENGTH - 1)]);

test('validates password confirmation', function () {

    $this->patch(route('password.update'), [
        'password' => 'password1234',
        'password_confirmation' => 'password4321',
    ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['password_confirmation']);

});

test('requires valid token', function () {

    $user = User::factory()->create();

    DB::table('password_reset_tokens')->insert([
        'email' => $user->email,
        'token' => Hash::make(fake()->uuid()),
    ]);

    $this->patch(route('password.update', [
        'token' => fake()->uuid(),
        'email' => $user->email,
        'password' => $password = 'password4321',
        'password_confirmation' => $password,
    ]))
        ->assertRedirectBackWithErrors()
        ->assertInvalid('password');

});

test('can reset password', function () {

    $user = User::factory()->create();

    DB::table('password_reset_tokens')->insert([
        'email' => $user->email,
        'token' => Hash::make($token = fake()->uuid()),
    ]);

    $this->patch(route('password.update', [
        'token' => $token,
        'email' => $user->email,
        'password' => $password = 'password4321',
        'password_confirmation' => $password,
    ]))
        ->assertSessionHasNoErrors()
        ->assertRedirectToRoute('dashboard.show');

    $user->refresh();

    expect(Hash::check($password, $user->password))
        ->toBeTrue();

    $this->assertAuthenticatedAs($user);

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
