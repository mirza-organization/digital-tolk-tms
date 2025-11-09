<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\TranslationTagEnum;
use App\Models\Translation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Translation>
 */
class TranslationFactory extends Factory
{
    protected $model = Translation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $locales = ['en', 'es', 'fr', 'zh', 'ja', 'ar'];
        $tags = array_column(TranslationTagEnum::cases(), 'value');

        return [
            'translator_id' => User::inRandomOrder()->first()->id,
            'text' => fake()->sentence(),
            'translation' => fake()->sentence(),
            'locale' => fake()->randomElement($locales),
            'tag' => fake()->randomElement($tags),
        ];
    }
}
