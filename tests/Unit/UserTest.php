<?php

declare(strict_types=1);

use App\Models\User;

test('can get user by email', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
    ]);

    $foundUser = User::getByEmail('test@example.com');

    expect($foundUser)->toBeInstanceOf(User::class)
        ->and($foundUser->id)->toBe($user->id)
        ->and($foundUser->email)->toBe('test@example.com');
});

