<?php

declare(strict_types=1);

namespace App\Http\Requests\Translation;

use App\Enums\TranslationTagEnum;
use App\Models\Translation;
use App\Policies\TranslationPolicy;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateTranslationRequest extends FormRequest
{
    public function __construct(protected TranslationPolicy $translationPolicy)
    {
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (isset($this['id'])) {
            return $this->translationPolicy->update(Auth::user(), Translation::find($this['id']));
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
            'id' => 'required|exists:translations,id',
            'translation' => 'required|string',
            'locale' => 'required|string',
            'tag' => ['required', Rule::enum(TranslationTagEnum::class)],
        ];
    }
}
