<?php

declare(strict_types=1);

namespace App\Actions\Translation;

use App\Enums\OrderByEnum;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Collection;

final class SearchTranslationAction
{
    public function execute(array $searchCriteria): Collection
    {
        return Translation::searchTranslations(
            text: $searchCriteria['text'],
            translatorId: (int) $searchCriteria['translator_id'],
            locale: $searchCriteria['locale'] ?? null,
            tag: $searchCriteria['tag'] ?? null,
            orderBy: $searchCriteria['order_by'] ?? OrderByEnum::DESC->value
        );
    }
}
