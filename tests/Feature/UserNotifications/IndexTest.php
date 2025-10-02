<?php

use App\Models\User;
use App\Models\UserNotification;
use Inertia\Testing\AssertableInertia;

test('must be signed in to view user notifications page', function () {

    $this->get(route('users.notifications'))
        ->assertRedirectToRoute('login');

});

test('can view user notifications page', function () {

    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    UserNotification::factory(1)->recycle($user1)->create();
    UserNotification::factory(2)->recycle($user2)->create();

    $this->actingAs($user1)
        ->get(route('users.notifications'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('UserNotifications/Index')
            ->has('notifications.data', 1)
        );

});

test('can search user notifications', function () {

    $user = User::factory()->create();

    UserNotification::factory(1)->recycle($user)->create([
        'message' => 'Test 1',
    ]);

    $notification = UserNotification::factory()->recycle($user)->create([
        'message' => 'Test 2',
    ])->refresh();

    $this->actingAs($user)
        ->get(route('users.notifications', [
            'search' => 'Test 2',
        ]))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('UserNotifications/Index')
            ->has('notifications.data', 1, fn (AssertableInertia $page) => $page
                ->where('id', $notification->id)
                ->where('message', $notification->message)
                ->where('created_at', $notification->created_at->format('d/m/Y H:i'))
            )
        );

});
