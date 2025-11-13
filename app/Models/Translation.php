<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\TranslationFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Searchable;

class Translation extends Model
{
    /** @use HasFactory<TranslationFactory> */
    use HasFactory;
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'translator_id',
        'text',
        'translation',
        'locale',
        'tag',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'translator_id' => $this->translator_id,
            'text' => $this->text,
            'locale' => $this->locale,
            'tag' => $this->tag,
        ];
    }

    /**
     * Relations
     */

    /**
     * Custom methods
     */
    public static function getAll(
        ?int $translatorId,
        ?string $locale,
        ?string $tag,
        string $orderBy,
        array $columns = ['*']
    ): LengthAwarePaginator {
        return self::select($columns)
            ->when($translatorId, fn ($query) => $query->where('translator_id', '=', $translatorId))
            ->when($locale, fn ($query) => $query->where('locale', '=', $locale))
            ->when($tag, fn ($query) => $query->where('tag', '=', $tag))
            ->orderBy('id', $orderBy)
            ->paginate(10);
    }

    public static function getById(int $id, array $columns = ['*']): self
    {
        return self::select($columns)->find($id);
    }

    public static function store(array $translationData): bool
    {
        return self::insert($translationData);
    }

    public static function updateById(int $id, array $updatedData): self
    {
        $translation = self::find($id);

        $translation->update($updatedData);

        return $translation->fresh();
    }

    public static function searchTranslations(
        int $translatorId,
        string $text,
        ?string $locale,
        ?string $tag,
        string $orderBy,
    ): Collection {
        return self::search($text)
            ->where('translator_id', $translatorId)
            ->when($locale, fn ($q) => $q->where('locale', $locale))
            ->when($tag, fn ($q) => $q->where('tag', $tag))
            ->orderBy('id', $orderBy)
            ->get();
    }
}
