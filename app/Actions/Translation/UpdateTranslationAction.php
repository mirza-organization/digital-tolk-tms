<?php

declare(strict_types=1);

namespace App\Actions\Translation;

use App\Models\Translation;
use Illuminate\Support\Facades\DB;

final class UpdateTranslationAction
{
    public function execute(array $updatedData): Translation
    {
        return DB::transaction(function () use ($updatedData): Translation {
            $id = (int) $updatedData['id'];

            unset($updatedData['id']);

            return Translation::updateById($id, $updatedData);
        });
    }
}
