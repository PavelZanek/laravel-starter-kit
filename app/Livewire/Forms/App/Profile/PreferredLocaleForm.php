<?php

declare(strict_types=1);

namespace App\Livewire\Forms\App\Profile;

use App\Enums\Users\PreferredLocaleEnum;
use Illuminate\Validation\Rules\Enum;
use Livewire\Form;

final class PreferredLocaleForm extends Form
{
    /**
     * @var array<string, mixed>
     */
    public array $modelData = [];

    public function setFormData(): void
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        /** @var PreferredLocaleEnum $preferredLocale */
        $preferredLocale = $user->preferred_locale;

        $this->modelData = [
            'preferred_locale' => $preferredLocale->value,
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'modelData.preferred_locale.required' => __('profile.preferred_locale_form.request.update.preferred_locale.required'),
            'modelData.preferred_locale.string' => __('profile.preferred_locale_form.request.update.preferred_locale.string'),
            'modelData.preferred_locale.max' => __('profile.preferred_locale_form.request.update.preferred_locale.max'),
            'modelData.preferred_locale.enum' => __('profile.preferred_locale_form.request.update.preferred_locale.enum'),
        ];
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function save(): void
    {
        /** @var array<string, array<string, string>> $validated */
        $validated = $this->validate([
            'modelData.preferred_locale' => ['required', 'string', 'max:5', new Enum(PreferredLocaleEnum::class)],
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();
        $user->update([
            'preferred_locale' => $validated['modelData']['preferred_locale'],
        ]);
    }
}
