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
            $translation = Translation::getById((int) $filters['id']);
            
            // Ensure the translation belongs to the authenticated user
            if ($translation->translator_id !== auth()->id()) {
                abort(403, 'Unauthorized. You can only view your own translations.');
            }
            
            return $translation;
        }

        // If translator_id is not provided, automatically filter by authenticated user's id
        $translatorId = $filters['translator_id'] ?? auth()->id();

        return Translation::getAll(
            translatorId: (int) $translatorId,
            locale: $filters['locale'] ?? null,
            tag: $filters['tag'] ?? null,
            orderBy: $filters['order_by'] ?? OrderByEnum::DESC->value
        );
    }
}
