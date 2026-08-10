<?php

declare(strict_types=1);

use App\Models\PasswordReset;
use Illuminate\Support\Str;
use Inertia\Testing\AssertableInertia;

Str::createRandomStringsUsing(function () {
    return 'token';
});

test('requires valid token', function () {

    $this->get(route('reset-password.edit', [
        PasswordReset::factory()->create(),
        'token' => 'bad',
    ]))
        ->assertForbidden();

});

test('must not be expired', function () {

    $password_reset = PasswordReset::factory()->create();

    $this->travel(61)->minutes();

    $this->get(route('reset-password.edit', [
        $password_reset,
        'token' => 'token',
    ]))
        ->assertStatus(419);

});

test('view reset password page', function () {

    $this->get(route('reset-password.edit', [
        $password_reset = PasswordReset::factory()->create(),
        'token' => 'token',
    ]))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('PasswordReset/Edit')
            ->where('uuid', $password_reset->id)
            ->where('token', 'token')
        );

});
