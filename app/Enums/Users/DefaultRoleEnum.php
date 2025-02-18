<?php

declare(strict_types=1);

namespace App\Enums\Users;

use Illuminate\Support\Collection;

enum DefaultRoleEnum: string
{
    case SUPER_ADMIN = 'super_admin';
    case ADMIN = 'admin';
    case BASIC = 'basic';

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(DefaultRoleEnum::cases(), 'value');
    }

    /**
     * @return Collection<int, array<string, string>>
     */
    public static function all(): Collection
    {
        return collect(DefaultRoleEnum::cases())->map(
            fn (DefaultRoleEnum $code): array => $code->details()
        );
    }

    /**
     * @return array<string, string>
     */
    public function details(): array
    {
        return match ($this) {
            DefaultRoleEnum::SUPER_ADMIN => [
                'name' => __('common.roles.super_admin'),
                'value' => 'super_admin',
            ],
            DefaultRoleEnum::ADMIN => [
                'name' => __('common.roles.admin'),
                'value' => 'admin',
            ],
            DefaultRoleEnum::BASIC => [
                'name' => __('common.roles.basic'),
                'value' => 'basic',
            ],
        };
    }
}
