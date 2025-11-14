<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Enums\UserStatus;
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

test('validates first name', function ($first_name) {

    $this->actingAs($user = User::factory()->administrator()->create())
        ->patch(route('users.update', $user), [
            'first_name' => $first_name,
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['first_name']);

})
    ->with(['', str_repeat('a', 256)]);

test('validates last name', function ($last_name) {

    $this->actingAs($user = User::factory()->administrator()->create())
        ->patch(route('users.update', $user), [
            'last_name' => $last_name,
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['last_name']);

})
    ->with(['', str_repeat('a', 256)]);

test('validates email address', function ($email) {

    $this->actingAs($user = User::factory()->administrator()->create())
        ->patch(route('users.update', $user), [
            'email' => $email,
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['email']);

})
    ->with(['', 'test', 'test@', '@example.com', str_repeat('a', 244).'@example.com']);

test('email address must be unique', function () {

    $this->actingAs($user = User::factory()->administrator()->create())
        ->patch(route('users.update', $user), [
            'email' => User::factory()->create()->email,
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['email']);

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

test('validates status', function ($status) {

    $this->actingAs($user = User::factory()->administrator()->create())
        ->patch(route('users.update', $user), [
            'status' => $status,
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['status']);

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

test('update user', function () {

    $this->actingAs($user = User::factory()->administrator()->create())
        ->patch(route('users.update', $user), [
            'first_name' => $first_name = fake()->firstName(),
            'last_name' => $last_name = fake()->lastName(),
            'email' => $email = fake()->safeEmail(),
            'password' => $password = str_repeat('a', PasswordService::MIN_LENGTH),
            'role' => UserRole::User->value,
            'status' => UserStatus::Active->value,
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirectToRoute('users.index');

    $user->refresh();

    expect([
        $user->first_name,
        $user->last_name,
        $user->email,
        $user->role,
        $user->status,
        Hash::check($password, $user->password),
    ])
        ->toBe([
            $first_name,
            $last_name,
            $email,
            UserRole::User,
            UserStatus::Active,
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
            'status' => UserStatus::Active->value,
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
        $revision->status,
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
            $user->status,
            $user->id,
            null,
            $user->id,
        ]);

});

test('does not update if nothing changed', function () {

    $this->actingAs($user = User::factory()->administrator()->create())
        ->patch(route('users.update', $user));

    expect($user->revisions()->count())
        ->toBe(1);

});
