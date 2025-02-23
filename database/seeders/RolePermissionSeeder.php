<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Users\DefaultRoleEnum;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Super Admin is defined in the AppServiceProvider.php

        $admin = Role::query()->where('name', DefaultRoleEnum::ADMIN)->first();
        //        $basic = Role::query()->where('name', DefaultRoleEnum::BASIC)->first();
        $permissions = Permission::query()->get();

        // Admin
        if ($admin) {
            $adminPermissions = $permissions->filter(function ($permission): bool {
                return in_array($permission->name, [
                    'roles.view',
                    'roles.create',
                    'roles.update',
                    'roles.delete',
                ]);
            });
            $admin->syncPermissions($adminPermissions);
        }

        // Basic
        //        if ($basic) {
        //            $basicPermissions = $permissions->filter(function ($permission) {
        //                return in_array($permission->name, [
        //                    'view_users',
        //                    'create_users',
        //                    'edit_users',
        //                ]);
        //            });
        //            $basic->syncPermissions($basicPermissions);
        //        }
    }
}
