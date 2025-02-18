<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Users\DefaultRoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

final class FakeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(100)
            ->withPersonalTeam()
            ->create()
            ->each(function (User $user): void {
                $user->assignRole(
                    fake()->boolean(10) ? DefaultRoleEnum::ADMIN->value : DefaultRoleEnum::BASIC->value
                );
            });
    }
}
