<?php

declare(strict_types=1);

namespace App\Enums\Users;

use Illuminate\Support\Collection;

enum PreferredLocaleEnum: string
{
    case EN = 'en';
    case CS = 'cs';

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(PreferredLocaleEnum::cases(), 'value');
    }

    /**
     * @return Collection<int, array<string, string>>
     */
    public static function all(): Collection
    {
        return collect(PreferredLocaleEnum::cases())->map(
            fn (PreferredLocaleEnum $code): array => $code->details()
        );
    }

    /**
     * @return Collection<string, string>
     */
    public static function allForFilter(): Collection
    {
        return collect(PreferredLocaleEnum::cases())->mapWithKeys(
            fn (PreferredLocaleEnum $code) => [$code->details()['value'] => $code->details()['name']]
        );
    }

    /**
     * @return array<string, string>
     */
    public function details(): array
    {
        return match ($this) {
            PreferredLocaleEnum::EN => [
                'name' => __('common.en'),
                'value' => 'en',
            ],
            PreferredLocaleEnum::CS => [
                'name' => __('common.cs'),
                'value' => 'cs',
            ],
        };
    }
}
