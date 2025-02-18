<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Users\DefaultRoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
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

        Role::query()->where('name', DefaultRoleEnum::ADMIN)->first();
        Role::query()->where('name', DefaultRoleEnum::BASIC)->first();
        Permission::query()->get();

        //        // Admin
        //        if ($admin) {
        //            $adminPermissions = $permissions->filter(function ($permission) {
        //                return in_array($permission->name, [
        //                    'view_users',
        //                    'create_users',
        //                    'edit_users',
        //                    'delete_users',
        //                ]);
        //            });
        //            $admin->syncPermissions($adminPermissions);
        //        }
        //
        //        // Basic
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
