<?php

declare(strict_types=1);

namespace App\Actions\Translation;

use App\Models\Translation;
use Illuminate\Support\Facades\DB;

final class StoreTranslationAction
{
    public function execute(array $data): bool
    {
        return DB::transaction(function () use ($data): bool {

            return Translation::store($data);
        });
    }
}
