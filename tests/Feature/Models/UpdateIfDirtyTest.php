<?php

declare(strict_types=1);

use App\Models\User;

test('does not update if does not exist', function () {

    $user = new User;

    expect($user->updateIfDirty([
        'first_name' => 'test1',
    ]))
        ->toBeFalse();

});

test('does not update if not dirty', function () {

    $user = User::factory()->create([
        'first_name' => 'test1',
    ]);

    expect($user->updateIfDirty([
        'first_name' => 'test1',
    ]))
        ->toBeFalse();

});

test('update if dirty', function () {

    $user = User::factory()->create([
        'first_name' => 'test1',
    ]);

    expect($user->updateIfDirty([
        'first_name' => 'test2',
    ]))
        ->toBeTrue();

});
