<?php

declare(strict_types=1);

use App\Models\Translation;
use App\Models\User;
use App\Enums\TranslationTagEnum;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->user = User::factory()->create();
    Sanctum::actingAs($this->user);
});

test('can view all translations', function () {
    Translation::factory()->count(5)->create(['translator_id' => $this->user->id]);

    $response = $this->getJson('/api/translations/view');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'data' => [],
                'current_page',
            ],
        ]);

    expect($response->json('data.data'))->toHaveCount(5);
});

test('can view single translation by id', function () {
    $translation = Translation::factory()->create(['translator_id' => $this->user->id]);

    $response = $this->getJson('/api/translations/view?id=' . $translation->id);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'id',
                'text',
                'translation',
            ],
        ]);

    expect($response->json('data.id'))->toBe($translation->id);
});

test('can filter translations by translator_id', function () {
    $otherUser = User::factory()->create();
    Translation::factory()->count(3)->create(['translator_id' => $this->user->id]);
    Translation::factory()->count(2)->create(['translator_id' => $otherUser->id]);

    $response = $this->getJson('/api/translations/view?translator_id=' . $this->user->id);

    $response->assertStatus(200);
    expect($response->json('data.data'))->toHaveCount(3);
});

test('cannot view translations of other users', function () {
    $otherUser = User::factory()->create();
    Translation::factory()->create(['translator_id' => $otherUser->id]);

    $response = $this->getJson('/api/translations/view?translator_id=' . $otherUser->id);

    $response->assertStatus(403);
});

test('can create translation', function () {
    $data = [
        'translator_id' => $this->user->id,
        'text' => 'Hello World',
        'translation' => 'Hola Mundo',
        'locale' => 'es',
        'tag' => TranslationTagEnum::WEB->value,
    ];

    $response = $this->postJson('/api/translations/create', $data);

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Translation created successfully',
        ]);

    $this->assertDatabaseHas('translations', [
        'text' => 'Hello World',
        'translation' => 'Hola Mundo',
    ]);
});

test('can update translation', function () {
    $translation = Translation::factory()->create(['translator_id' => $this->user->id]);

    $data = [
        'id' => $translation->id,
        'translation' => 'Updated translation',
        'locale' => 'en',
        'tag' => TranslationTagEnum::MOBILE->value,
    ];

    $response = $this->patchJson('/api/translations/update', $data);

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Translation updated successfully',
        ]);

    $this->assertDatabaseHas('translations', [
        'id' => $translation->id,
        'translation' => 'Updated translation',
    ]);
});

test('requires authentication to access translations', function () {
    // Override the global beforeEach authentication
    auth()->logout();
    Sanctum::actingAs(null);
    
    $response = $this->getJson('/api/translations/view');

    $response->assertStatus(401);
});

