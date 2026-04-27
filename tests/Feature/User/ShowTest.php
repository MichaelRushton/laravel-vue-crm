<?php

declare(strict_types=1);

use App\Models\User;

test('must be signed in to view show user page', function () {

    $this->get(route('users.show', User::factory()->create()))
        ->assertRedirectToRoute('login');

});

test('must be an administrator to view show user page', function () {

    $this->actingAs($user = User::factory()->create())
        ->get(route('users.show', $user))
        ->assertForbidden();

});

test('must find user', function () {

    $this->actingAs(User::factory()->administrator()->create())
        ->get(route('users.show', User::factory()->create()->delete()))
        ->assertNotFound();

});

test('view show user page', function () {

    $this->actingAs($user = User::factory()->administrator()->create())
        ->get(route('users.show', $user))
        ->assertJson([
            'uuid' => $user->uuid,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'role' => $user->role->name(),
            'status' => $user->status->name(),
        ]);

});
