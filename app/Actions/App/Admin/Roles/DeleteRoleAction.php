<?php

declare(strict_types=1);

namespace App\Actions\App\Admin\Roles;

use App\Models\Role;
use Illuminate\Support\Facades\DB;

final readonly class DeleteRoleAction
{
    public function execute(Role $role): void
    {
        DB::transaction(function () use ($role): void {
            $role->delete();
        });
    }
}
