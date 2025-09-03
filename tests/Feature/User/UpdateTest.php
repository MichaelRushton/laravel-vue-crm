<?php

use App\Enums\UserRole;
use App\Models\User;
use App\Services\PasswordService;
use Illuminate\Support\Facades\Hash;

test('must be authenticated to update user', function () {

    $this->patch(route('users.update', User::factory()->create()))
        ->assertRedirectToRoute('login');

});

test('must be an administrator to update user', function () {

    $this->actingAs($user = User::factory()->create())
        ->patch(route('users.update', $user))
        ->assertForbidden();

});

test('validates first name', function () {

    $this->actingAs($user = User::factory()->administrator()->create())
        ->patch(route('users.update', $user), [
            'first_name' => '',
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['first_name']);

});

test('validates last name', function () {

    $this->actingAs($user = User::factory()->administrator()->create())
        ->patch(route('users.update', $user), [
            'last_name' => '',
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['last_name']);

});

test('validates email address', function ($email) {

    $this->actingAs($user = User::factory()->administrator()->create())
        ->patch(route('users.update', $user), [
            'email' => $email,
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['email']);

})
    ->with(['', 'test', 'test@', '@example.com']);

test('email address must be unique', function () {

    $this->actingAs($user = User::factory()->administrator()->create())
        ->patch(route('users.update', $user), [
            'email' => User::factory()->create()->email,
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['email']);

    $this->patch(route('users.update', $user), [
        'email' => $user->email,
    ])
        ->assertSessionHasNoErrors();

});

test('validates role', function ($role) {

    $this->actingAs($user = User::factory()->administrator()->create())
        ->patch(route('users.update', $user), [
            'role' => $role,
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['role']);

})
    ->with(['', 'test']);

test('validates password', function ($password) {

    $this->actingAs($user = User::factory()->administrator()->create())
        ->patch(route('users.update', $user), [
            'password' => $password,
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['password']);

})
    ->with([str_repeat('a', PasswordService::MIN_LENGTH - 1)]);

test('can update user', function () {

    $this->actingAs($user = User::factory()->administrator()->create())
        ->patch(route('users.update', $user), [
            'first_name' => $first_name = fake()->firstName(),
            'last_name' => $last_name = fake()->lastName(),
            'email' => $email = fake()->safeEmail(),
            'password' => $password = str_repeat('a', PasswordService::MIN_LENGTH),
            'role' => UserRole::User->value,
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirectToRoute('users.index');

    $user->refresh();

    expect([
        $user->first_name,
        $user->last_name,
        $user->email,
        $user->role,
        Hash::check($password, $user->password),
    ])
        ->toBe([
            $first_name,
            $last_name,
            $email,
            UserRole::User,
            true,
        ]);

});

test('creates revision', function () {

    $this->actingAs($user = User::factory()->administrator()->create())
        ->patch(route('users.update', $user), [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->safeEmail(),
            'password' => str_repeat('a', PasswordService::MIN_LENGTH),
            'role' => UserRole::User->value,
        ]);

    $user->refresh();

    expect($user->revisions()->count())
        ->toBe(2);

    $revision = $user->revisions->last();

    expect([
        $revision->user_id,
        $revision->first_name,
        $revision->last_name,
        $revision->email,
        $revision->role,
        $revision->created_by,
        $revision->impersonated_by,
        $revision->user->id,
    ])
        ->toBe([
            $user->id,
            $user->first_name,
            $user->last_name,
            $user->email,
            $user->role,
            $user->id,
            null,
            $user->id,
        ]);

});
