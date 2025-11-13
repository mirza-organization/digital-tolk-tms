<?php

declare(strict_types=1);

namespace App\Actions\Translation;

use App\Enums\HttpStatusEnum;
use App\Enums\OrderByEnum;
use App\Models\Translation;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

final class ViewTranslationAction
{
    public function execute(array $filters): Translation|LengthAwarePaginator
    {
        if (isset($filters['id'])) {
            $translation = Translation::getById((int) $filters['id']);

            // Ensure the translation belongs to the authenticated user
            if ($translation->translator_id !== Auth::id()) {
                abort(HttpStatusEnum::UNAUTHORIZED, 'Unauthorized. You can only view your own translations.');
            }

            return $translation;
        }

        return Translation::getAll(
            translatorId: (isset($filters['translator_id'])) ? (int) $filters['translator_id'] : null,
            locale: $filters['locale'] ?? null,
            tag: $filters['tag'] ?? null,
            orderBy: $filters['order_by'] ?? OrderByEnum::DESC->value
        );
    }
}
