<?php

declare(strict_types=1);

use App\Enums\UserStatus;
use App\Models\User;

test('inactive users are signed out', function () {

    $this->actingAs(User::factory()->create([
        'status' => UserStatus::Inactive,
    ]))
        ->get(route('dashboard.show'))
        ->assertRedirectToRoute('login')
        ->assertSessionHas('flash.error');

    $this->assertGuest();

});
