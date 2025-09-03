<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;

test('validates email address', function ($email) {

    $this->post(route('password.store'), [
        'email' => $email,
    ])
        ->assertRedirectBackWithErrors()
        ->assertInvalid(['email']);

})
    ->with(['', 'test', 'test@', '@example.com']);

test('queues password reset', function () {

    Queue::fake();

    $this->post(route('password.store'), [
        'email' => fake()->safeEmail(),
    ])
        ->assertRedirectToRoute('login')
        ->assertSessionHas('flash.success');

    Queue::assertCount(1);

});

test('sends password reset', function () {

    Notification::fake();

    $user = User::factory()->create();

    $this->post(route('password.store'), [
        'email' => $user->email,
    ])
        ->assertRedirectToRoute('login')
        ->assertSessionHas('flash.success');

    Notification::assertCount(1);

    Notification::assertSentTo($user, ResetPassword::class);

});
