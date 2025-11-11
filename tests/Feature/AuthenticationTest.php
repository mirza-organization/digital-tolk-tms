<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('user can login with valid credentials', function () {
    $password = 'password123';
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make($password),
    ]);

    $response = $this->getJson('/api/login?' . http_build_query([
        'email' => $user->email,
        'password' => $password,
    ]));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'user',
                'token',
            ],
        ]);

    expect($response->json('data.user.id'))->toBe($user->id);
});

test('user cannot login with invalid credentials', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('correct_password'),
    ]);

    $response = $this->getJson('/api/login?' . http_build_query([
        'email' => $user->email,
        'password' => 'wrong_password',
    ]));

    $response->assertStatus(422);
});

test('login requires valid email format', function () {
    $response = $this->getJson('/api/login?' . http_build_query([
        'email' => 'invalid-email',
        'password' => 'password123',
    ]));

    $response->assertStatus(422);
});

