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

test('can search translations', function () {
    Translation::factory()->create([
        'translator_id' => $this->user->id,
        'text' => 'Hello World',
        'locale' => 'en',
        'tag' => TranslationTagEnum::WEB->value,
    ]);

    $response = $this->getJson('/api/translations/search', [
        'translator_id' => $this->user->id,
        'text' => 'Hello',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [],
        ]);
});

test('search requires translator_id', function () {
    $response = $this->getJson('/api/translations/search', [
        'text' => 'Hello',
    ]);

    $response->assertStatus(422);
});

test('search requires text', function () {
    $response = $this->getJson('/api/translations/search', [
        'translator_id' => $this->user->id,
    ]);

    $response->assertStatus(422);
});

