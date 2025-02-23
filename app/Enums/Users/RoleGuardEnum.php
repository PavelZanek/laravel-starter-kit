<?php

declare(strict_types=1);

namespace App\Enums\Users;

use Illuminate\Support\Collection;

enum RoleGuardEnum: string
{
    case WEB = 'web';
    case API = 'api';

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(RoleGuardEnum::cases(), 'value');
    }

    /**
     * @return Collection<int, array<string, string>>
     */
    public static function all(): Collection
    {
        return collect(RoleGuardEnum::cases())->map(
            fn (RoleGuardEnum $code): array => $code->details()
        );
    }

    /**
     * @return array<string, string>
     */
    public function details(): array
    {
        return match ($this) {
            RoleGuardEnum::WEB => [
                'name' => 'web',
                'value' => 'web',
            ],
            RoleGuardEnum::API => [
                'name' => 'api',
                'value' => 'api',
            ],
        };
    }
}
