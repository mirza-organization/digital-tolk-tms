<?php

declare(strict_types=1);

namespace App\Http\Requests\Translation;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Enums\TranslationTagEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTranslationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'id' => 'required|exists:translations,id',
            'translation' => 'required|string',
            'locale' => 'required|string',
            'tag' => ['required', Rule::enum(TranslationTagEnum::class)],
        ];
    }
}
