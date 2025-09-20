<?php

use App\Models\SignIn;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

test('must be signed in to view sign in index page', function () {

    $this->get(route('sign-ins.index'))
        ->assertRedirectToRoute('login');

});

test('must be an administrator to view sign in index page', function () {

    $this->actingAs(User::factory()->create())
        ->get(route('sign-ins.index'))
        ->assertForbidden();

});

test('can view sign in index page', function () {

    $user = User::factory()->administrator()->create();

    SignIn::factory(10)->recycle($user)->create();

    $this->actingAs($user)
        ->get(route('sign-ins.index'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('SignIns/Index')
            ->has('sign_ins.data', 10)
        );

});

test('can search sign ins', function () {

    $user = User::factory()->administrator()->create([
        'email' => 'user1@designamite.co.uk',
    ]);

    SignIn::factory(5)->recycle($user)->create([
        'email' => $user->email,
    ]);

    $sign_in = SignIn::factory()->recycle($user)->create([
        'email' => 'user2@designamite.co.uk',
    ])->refresh();

    $this->actingAs($user)
        ->get(route('sign-ins.index', [
            'search' => $sign_in->email,
        ]))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('SignIns/Index')
            ->has('sign_ins.data', 1, fn (AssertableInertia $page) => $page
                ->where('id', $sign_in->id)
                ->where('ip_address', $sign_in->ip_address)
                ->where('email', $sign_in->email)
                ->where('user', $sign_in->user?->name ?? '')
                ->where('correct_password', $sign_in->correct_password)
                ->where('created_at', $sign_in->created_at->format('d/m/Y H:i:s'))
            )
        );

});
