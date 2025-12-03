<?php

declare(strict_types=1);

use App\Models\User;
use Inertia\Testing\AssertableInertia;

test('must be signed in to view user index page', function () {

    $this->get(route('users.index'))
        ->assertRedirectToRoute('login');

});

test('must be an administrator to view user index page', function () {

    $this->actingAs(User::factory()->create())
        ->get(route('users.index'))
        ->assertForbidden();

});

test('view user index page', function () {

    User::factory(9)->create();

    $this->actingAs(User::factory()->administrator()->create())
        ->get(route('users.index'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Users/Index')
            ->has('users.data', 10)
        );

});

test('search users by first name', function () {

    User::factory(9)->create([
        'first_name' => 'test',
        'last_name' => 'test',
    ]);

    $this->actingAs($user = User::factory()->administrator()->create([
        'first_name' => 'first_name',
        'last_name' => 'test',
    ]))
        ->get(route('users.index', [
            'name' => 'first_name',
        ]))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->has('users.data', 1, fn (AssertableInertia $page) => $page
                ->where('uuid', $user->uuid)
                ->etc()
            )
        );

});

test('search users by last name', function () {

    User::factory(9)->create([
        'first_name' => 'test',
        'last_name' => 'test',
    ]);

    $this->actingAs($user = User::factory()->administrator()->create([
        'first_name' => 'test',
        'last_name' => 'last_name',
    ]))
        ->get(route('users.index', [
            'name' => 'last_name',
        ]))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->has('users.data', 1, fn (AssertableInertia $page) => $page
                ->where('uuid', $user->uuid)
                ->etc()
            )
        );

});

test('search users by full name', function () {

    User::factory(9)->create([
        'first_name' => 'test',
        'last_name' => 'test',
    ]);

    $this->actingAs($user = User::factory()->administrator()->create([
        'first_name' => 'first_name',
        'last_name' => 'last_name',
    ]))
        ->get(route('users.index', [
            'name' => 'first_name last_name',
        ]))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->has('users.data', 1, fn (AssertableInertia $page) => $page
                ->where('uuid', $user->uuid)
                ->etc()
            )
        );

});
