<?php

declare(strict_types=1);

namespace App\Actions\Translation;

use App\Enums\OrderByEnum;
use App\Models\Translation;
use Illuminate\Pagination\LengthAwarePaginator;

final class ViewTranslationAction
{
    public function execute(array $filters): Translation|LengthAwarePaginator
    {
        if (isset($filters['id'])) {
            return Translation::getById((int) $filters['id']);
        }

        return Translation::getAll(
            translatorId: (isset($filters['translator_id'])) ? (int) $filters['translator_id'] : null,
            locale: $filters['locale'] ?? null,
            tag: $filters['tag'] ?? null,
            orderBy: $filters['order_by'] ?? OrderByEnum::DESC->value
        );
    }
}
