<?php

declare(strict_types=1);

namespace App\Actions\App\Admin\Roles;

use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class UpdateRoleAction
{
    /**
     * @param  array<string, mixed>  $data
     * @param  list<int|string>  $permissionIds
     *
     * @throws Throwable
     */
    public function execute(Role $role, array $data, array $permissionIds = []): Role
    {
        DB::transaction(function () use ($role, $data, $permissionIds): void {
            $role->update($data);

            $role->syncPermissions($permissionIds);
        });

        return $role;
    }
}
