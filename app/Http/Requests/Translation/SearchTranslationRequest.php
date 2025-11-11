<?php

declare(strict_types=1);

namespace App\Http\Requests\Translation;

use App\Enums\OrderByEnum;
use App\Enums\TranslationTagEnum;
use App\Policies\TranslationPolicy;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchTranslationRequest extends FormRequest
{
    public function __construct(protected TranslationPolicy $translationPolicy) {}

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (isset($this['translator_id'])) {
            return $this->translationPolicy->viewAny((int) $this['translator_id']);
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'translator_id' => 'required|integer',
            'text' => 'required|string',
            'locale' => 'nullable|string',
            'tag' => ['nullable', Rule::enum(TranslationTagEnum::class)],
            'order_by' => ['nullable', Rule::enum(OrderByEnum::class)],
        ];
    }
}
