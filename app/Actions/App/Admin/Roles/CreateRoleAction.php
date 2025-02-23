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
     *
     * @throws Throwable
     */
    public function execute(array $data): Role
    {
        /** @var Role $role */
        $role = DB::transaction(function () use ($data) {
            return Role::query()->create(array_merge($data, [
                'is_default' => false,
            ]));
        });

        return $role;
    }
}
