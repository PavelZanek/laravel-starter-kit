<?php

declare(strict_types=1);

namespace App\Actions\App\Admin\Users;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final readonly class UpdateUserAction
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function execute(User $user, array $data, ?Role $role = null): User
    {
        DB::transaction(function () use ($user, $data, $role): void {
            $user->update($data);
            if ($role instanceof Role) {
                $user->roles()->sync([$role]);
            }
        });

        return $user;
    }
}
