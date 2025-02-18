<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        //        $permissions = [
        //            'view_users',
        //            'create_users',
        //            'edit_users',
        //            'delete_users',
        //            'view_roles',
        //            'create_roles',
        //            'edit_roles',
        //            'delete_roles',
        //            'view_permissions',
        //            'create_permissions',
        //            'edit_permissions',
        //            'delete_permissions',
        //        ];
        //
        //        foreach($permissions as $permission){
        //            Permission::query()->updateOrCreate([
        //                'name' => $permission,
        //                'is_default' => true,
        //                'guard_name' => 'web',
        //            ]);
        //        }
    }
}
