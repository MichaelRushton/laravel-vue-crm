<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use App\Services\PasswordService;
use Illuminate\Support\Facades\Hash;

test('must be authenticated to create user', function () {

    $this->post(route('users.store'))
        ->assertRedirectToRoute('login');

});

test('must be an administrator to create user', function () {

    $this->actingAs(User::factory()->create())
        ->post(route('users.store'))
        ->assertForbidden();

});

test('requires first name', function () {

    $this->actingAs(User::factory()->administrator()->create())
        ->post(route('users.store'))
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['first_name']);

});

test('validates first name', function ($first_name) {

    $this->actingAs(User::factory()->administrator()->create())
        ->post(route('users.store'), [
            'first_name' => $first_name,
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['first_name']);

})
    ->with(['', str_repeat('a', 256)]);

test('requires last name', function () {

    $this->actingAs(User::factory()->administrator()->create())
        ->post(route('users.store'))
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['last_name']);

});

test('validates last name', function ($last_name) {

    $this->actingAs(User::factory()->administrator()->create())
        ->post(route('users.store'), [
            'last_name' => $last_name,
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['last_name']);

})
    ->with(['', str_repeat('a', 256)]);

test('requires email address', function () {

    $this->actingAs(User::factory()->administrator()->create())
        ->post(route('users.store'))
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['email']);

});

test('validates email address', function ($email) {

    $this->actingAs(User::factory()->administrator()->create())
        ->post(route('users.store'), [
            'email' => $email,
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['email']);

})
    ->with(['', 'test', 'test@', '@example.com', str_repeat('a', 244).'@example.com']);

test('email address must be unique', function () {

    $this->actingAs($user = User::factory()->administrator()->create())
        ->post(route('users.store'), [
            'email' => $user->email,
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['email']);

});

test('requires role', function () {

    $this->actingAs(User::factory()->administrator()->create())
        ->post(route('users.store'))
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['role']);

});

test('validates role', function ($role) {

    $this->actingAs(User::factory()->administrator()->create())
        ->post(route('users.store'), [
            'role' => $role,
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['role']);

})
    ->with(['', 'test']);

test('requires status', function () {

    $this->actingAs(User::factory()->administrator()->create())
        ->post(route('users.store'))
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['status']);

});

test('validates status', function ($status) {

    $this->actingAs(User::factory()->administrator()->create())
        ->post(route('users.store'), [
            'status' => $status,
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['status']);

})
    ->with(['', 'test']);

test('requires password', function () {

    $this->actingAs(User::factory()->administrator()->create())
        ->post(route('users.store'))
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['password']);

});

test('validates password', function ($password) {

    $this->actingAs(User::factory()->administrator()->create())
        ->post(route('users.store'), [
            'password' => $password,
        ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['password']);

})
    ->with(['', str_repeat('a', PasswordService::MIN_LENGTH - 1)]);

test('create user', function () {

    $this->actingAs(User::factory()->administrator()->create())
        ->post(route('users.store'), [
            'first_name' => $first_name = fake()->firstName(),
            'last_name' => $last_name = fake()->lastName(),
            'email' => $email = fake()->safeEmail(),
            'password' => $password = str_repeat('a', PasswordService::MIN_LENGTH),
            'role' => UserRole::User->value,
            'status' => UserStatus::Active->value,
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirectToRoute('users.index');

    $user = User::latest('id')->first();

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

    $this->actingAs($admin = User::factory()->administrator()->create())
        ->post(route('users.store'), [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->safeEmail(),
            'password' => str_repeat('a', PasswordService::MIN_LENGTH),
            'role' => UserRole::User->value,
            'status' => UserStatus::Active->value,
        ]);

    $user = User::latest('id')->first();

    expect($user->revisions()->count())
        ->toBe(1);

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
            $admin->id,
            null,
            $user->id,
        ]);

});
