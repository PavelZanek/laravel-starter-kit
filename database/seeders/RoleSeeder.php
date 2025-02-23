<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Users\DefaultRoleEnum;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Role::query()->updateOrCreate([
            'name' => DefaultRoleEnum::SUPER_ADMIN->value,
            'is_default' => true,
            'guard_name' => 'web',
        ]);
        Role::query()->updateOrCreate([
            'name' => DefaultRoleEnum::ADMIN->value,
            'is_default' => true,
            'guard_name' => 'web',
        ]);
        Role::query()->updateOrCreate([
            'name' => DefaultRoleEnum::BASIC->value,
            'is_default' => true,
            'guard_name' => 'web',
        ]);
    }
}
