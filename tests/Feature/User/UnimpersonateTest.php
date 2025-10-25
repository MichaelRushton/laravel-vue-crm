<?php

declare(strict_types=1);

use App\Models\User;

test('must be authenticated to unimpersonate user', function () {

    $this->delete(route('users.unimpersonate'))
        ->assertRedirectToRoute('login');

});

test('must be impersonating a user to unimpersonate', function () {

    $this->actingAs(User::factory()->create())
        ->delete(route('users.unimpersonate'))
        ->assertBadRequest();

});

test('unimpersonate user', function () {

    $this->actingAs(User::factory()->create())
        ->withSession(['impersonated_by' => $admin = User::factory()->administrator()->create()])
        ->delete(route('users.unimpersonate'))
        ->assertRedirectToRoute('dashboard.show')
        ->assertSessionMissing('impersonated_by');

    $this->assertAuthenticatedAs($admin);

});

test('unimpersonate user by impersonating self', function () {

    $this->actingAs(User::factory()->administrator()->create())
        ->withSession(['impersonated_by' => $admin = User::factory()->administrator()->create()])
        ->post(route('users.impersonate', $admin))
        ->assertRedirectToRoute('dashboard.show')
        ->assertSessionMissing('impersonated_by');

    $this->assertAuthenticatedAs($admin);

});
