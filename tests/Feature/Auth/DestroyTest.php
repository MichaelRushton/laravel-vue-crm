<?php

use App\Models\User;

test('sign out', function () {

    $this->actingAs(User::factory()->create())
        ->delete(route('auth.destroy'))
        ->assertRedirectToRoute('login');

    $this->assertGuest();

});
