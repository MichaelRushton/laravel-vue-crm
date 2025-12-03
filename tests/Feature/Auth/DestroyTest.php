<?php

declare(strict_types=1);

use App\Models\User;

test('sign out', function () {

    $this->actingAs(User::factory()->create())
        ->delete(route('auth.destroy'))
        ->assertRedirectToRoute('login');

    $this->assertGuest();

});
