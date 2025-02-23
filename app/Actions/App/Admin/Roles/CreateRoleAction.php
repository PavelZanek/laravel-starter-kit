<?php

declare(strict_types=1);

namespace App\Actions\App\Admin\Roles;

use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class CreateRoleAction
{
    /**
     * @param  array<string, mixed>  $data
     * @param  list<int|string>  $permissionIds
     *
     * @throws Throwable
     */
    public function execute(array $data, array $permissionIds = []): Role
    {
        /** @var Role $role */
        $role = DB::transaction(function () use ($data, $permissionIds): Role {
            $role = Role::query()->create(array_merge($data, [
                'is_default' => false,
            ]));

            $role->syncPermissions($permissionIds);

            return $role;
        });

        return $role;
    }
}
