<?php

declare(strict_types=1);

namespace App\Actions\App\Admin\Roles;

use App\Models\Role;
use Illuminate\Support\Facades\DB;

final readonly class UpdateRoleAction
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function execute(Role $role, array $data): Role
    {
        DB::transaction(function () use ($role, $data): void {
            $role->update($data);
        });

        return $role;
    }
}
