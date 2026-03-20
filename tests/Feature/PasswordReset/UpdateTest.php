<?php

declare(strict_types=1);

use App\Models\PasswordReset;
use App\Services\PasswordService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

Str::createRandomStringsUsing(function () {
    return 'token';
});

test('requires valid token', function () {

    $this->patch(route('reset-password.update', [
        PasswordReset::factory()->create(),
        'token' => 'bad',
        'password' => 'password1234',
    ]))
        ->assertForbidden();

});

test('must not be expired', function () {

    $password_reset = PasswordReset::factory()->create();

    $this->travel(16)->minutes();

    $this->patch(route('reset-password.update', [
        $password_reset,
        'token' => 'token',
        'password' => 'password1234',
    ]))
        ->assertStatus(419);

});

test('requires password', function () {

    $this->patch(route('reset-password.update', [
        PasswordReset::factory()->create(),
        'token' => 'token',
    ]))
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['password']);

});

test('validates password', function ($password) {

    $this->patch(route('reset-password.update', [
        PasswordReset::factory()->create(),
        'token' => 'token',
        'password' => $password,
    ]))
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['password']);

})
    ->with(['', str_repeat('a', PasswordService::MIN_LENGTH - 1)]);

test('resets password', function () {

    $this->patch(route('reset-password.update', [
        $password_reset = PasswordReset::factory()->create(),
        'token' => 'token',
        'password' => $password = 'password4321',
    ]))
        ->assertSessionHasNoErrors();

    expect(Hash::check($password, $password_reset->user->password))
        ->toBeTrue();

    expect($password_reset->refresh()->trashed())
        ->toBeTrue();

});

test('signs in after password reset', function () {

    $this->patch(route('reset-password.update', [
        $password_reset = PasswordReset::factory()->create(),
        'token' => 'token',
        'password' => 'password1234',
    ]))
        ->assertRedirectToRoute('dashboard.show');

    $this->assertAuthenticatedAs($password_reset->user);

});
