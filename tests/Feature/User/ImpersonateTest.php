<?php

use App\Models\User;
use App\Models\UserImpersonation;
use App\Models\UserNotification;

test('must be authenticated to impersonate user', function () {

    $this->post(route('users.impersonate', User::factory()->create()))
        ->assertRedirectToRoute('login');

});

test('must be an administrator to impersonate user', function () {

    $this->actingAs(User::factory()->create())
        ->post(route('users.impersonate', User::factory()->create()))
        ->assertForbidden();

});

test('cannot impersonate self', function () {

    $this->actingAs($admin = User::factory()->administrator()->create())
        ->post(route('users.impersonate', $admin))
        ->assertForbidden();

});

test('can impersonate user', function () {

    $this->actingAs($admin = User::factory()->administrator()->create())
        ->post(route('users.impersonate', $user = User::factory()->create()))
        ->assertRedirectToRoute('dashboard.show')
        ->assertSessionHas('impersonated_by', $admin);

    $this->assertAuthenticatedAs($user);

    expect(UserImpersonation::count())
        ->toBe(1);

    $user_impersonation = UserImpersonation::latest('id')->first();

    expect([
        $user_impersonation->user_id,
        $user_impersonation->created_by,
    ])
        ->toBe([
            $user->id,
            $admin->id,
        ]);

});

test('logs user impersonation', function () {

    $this->actingAs($admin = User::factory()->administrator()->create())
        ->post(route('users.impersonate', $user = User::factory()->create()));

    expect(UserImpersonation::count())
        ->toBe(1);

    $user_impersonation = UserImpersonation::latest('id')->first();

    expect([
        $user_impersonation->user_id,
        $user_impersonation->created_by,
    ])
        ->toBe([
            $user->id,
            $admin->id,
        ]);

});

test('remember original user when chaining impersonations', function () {

    $this->actingAs(User::factory()->administrator()->create())
        ->withSession(['impersonated_by' => $admin = User::factory()->administrator()->create()])
        ->post(route('users.impersonate', $user = User::factory()->create()));

    $user_impersonation = UserImpersonation::latest('id')->first();

    expect([
        $user_impersonation->user_id,
        $user_impersonation->created_by,
    ])
        ->toBe([
            $user->id,
            $admin->id,
        ]);

});

test('creates user impersonation notifications', function () {

    $users = User::factory(2)->administrator()->create();

    $this->actingAs($user1 = User::factory()->administrator()->create())
        ->post(route('users.impersonate', $user2 = User::factory()->create()));

    expect(UserNotification::count())
        ->toBe(2);

    foreach ($users as $user) {

        expect($user->notifications->count())
            ->toBe(1);

        expect($user->notifications->first()->message)
            ->toBe("$user1->name impersonated $user2->name");

    }

});
