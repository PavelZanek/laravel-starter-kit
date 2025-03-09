<?php

declare(strict_types=1);

namespace App\Actions\Fortify;

use App\Enums\Users\DefaultRoleEnum;
use App\Enums\Users\PreferredLocaleEnum;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

final readonly class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return DB::transaction(function () use ($input) {
            $preferredLocale = match (app()->getLocale()) {
                'cs' => PreferredLocaleEnum::CS->value,
                default => PreferredLocaleEnum::EN->value,
            };

            return tap(User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'preferred_locale' => $preferredLocale,
                'notification_channels' => ['database' => true, 'mail' => false],
            ]), function (User $user): void {
                $user->assignRole(DefaultRoleEnum::BASIC);

                app()->setLocale($user->preferredLocale());

                $this->createTeam($user);
            });
        });
    }

    /**
     * Create a personal team for the user.
     */
    private function createTeam(User $user): void
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
    }
}
