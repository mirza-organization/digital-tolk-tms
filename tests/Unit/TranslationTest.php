<?php

declare(strict_types=1);

use App\Models\Translation;
use App\Models\User;
use App\Enums\TranslationTagEnum;
use Illuminate\Pagination\LengthAwarePaginator;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('can get all translations with filters', function () {
    Translation::factory()->count(5)->create(['translator_id' => $this->user->id]);
    Translation::factory()->count(3)->create(['translator_id' => $this->user->id, 'locale' => 'en']);
    Translation::factory()->count(2)->create(['translator_id' => $this->user->id, 'tag' => TranslationTagEnum::MOBILE->value]);

    $result = Translation::getAll(
        translatorId: $this->user->id,
        locale: null,
        tag: null,
        orderBy: 'desc'
    );

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class)
        ->and($result->total())->toBe(10);
});

test('can get translation by id', function () {
    $translation = Translation::factory()->create(['translator_id' => $this->user->id]);

    $found = Translation::getById($translation->id);

    expect($found)->toBeInstanceOf(Translation::class)
        ->and($found->id)->toBe($translation->id);
});

test('can store translation', function () {
    $data = [
        'translator_id' => $this->user->id,
        'text' => 'Hello',
        'translation' => 'Hola',
        'locale' => 'es',
        'tag' => TranslationTagEnum::WEB->value,
    ];

    $result = Translation::store($data);

    expect($result)->toBeTrue()
        ->and(Translation::where('text', 'Hello')->exists())->toBeTrue();
});

test('can update translation by id', function () {
    $translation = Translation::factory()->create(['translator_id' => $this->user->id]);

    $updated = Translation::updateById($translation->id, [
        'text' => 'Updated text',
        'translation' => 'Updated translation',
    ]);

    expect($updated->text)->toBe('Updated text')
        ->and($updated->translation)->toBe('Updated translation');
});

