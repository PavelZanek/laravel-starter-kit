<?php

declare(strict_types=1);

namespace App\Actions\App\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

final readonly class CreateUserAction
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function execute(array $data, Role $role): User
    {
        /** @var User $user */
        $user = DB::transaction(function () use ($data, $role) {
            $user = User::query()->create(array_merge($data, [
                'password' => Hash::make(Str::random(10)),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]));

            $user->assignRole($role);
            $this->createTeam($user);

            return $user;
        });

        //        Mail::to($user)->send(new NewUserCreated($user));

        return $user;
    }

    /**
     * Create a personal team for the user.
     */
    private function createTeam(User $user): void
    {
        $team = $user->ownedTeams()->create([
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]);

        $user->update([
            'current_team_id' => $team->getKey(),
        ]);
    }
}
