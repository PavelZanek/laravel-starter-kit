<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Users\DefaultRoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

final class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->withRole(DefaultRoleEnum::SUPER_ADMIN->value)
            ->withPersonalTeam()
            ->create([
                'name' => 'Pavel',
                'email' => 'zanek.pavel@gmail.com',
                'preferred_locale' => 'cs',
            ]);
    }
}
