<?php

declare(strict_types=1);

namespace App\Actions\Translation;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Collection;

final class SearchTranslationAction
{
    public function execute(array $searchCriteria): Collection
    {
        return Translation::searchTranslations(
            text: $searchCriteria['text'],
            translatorId: $searchCriteria['translator_id'] ?? null,
            locale: $searchCriteria['locale'] ?? null,
            tag: $searchCriteria['tag'] ?? null
        );
    }
}
