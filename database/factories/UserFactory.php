<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Users\DefaultRoleEnum;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
final class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    private static ?string $password; // @phpstan-ignore-line

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => self::$password ??= Hash::make('password'),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
            'preferred_locale' => fake()->randomElement(config('project.available_locales')),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes): array => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user should have a personal team.
     */
    public function withPersonalTeam(?callable $callback = null): static
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(fn (array $attributes, User $user): array => [ // @phpstan-ignore-line
                    'name' => $user->name.'\'s Team',
                    'user_id' => $user->id,
                    'personal_team' => true,
                ])
                ->when(is_callable($callback), $callback),
            'ownedTeams'
        );
    }

    /**
     * Attach role to the user.
     */
    public function withRole(string $roleName = DefaultRoleEnum::BASIC->value, string $guardName = 'web'): static
    {
        return $this->afterCreating(function (User $user) use ($roleName, $guardName): void {
            $role = Role::query()
                ->where('name', $roleName)
                ->where('guard_name', $guardName)
                ->first();

            if (! $role) {
                $role = Role::create([
                    'name' => $roleName,
                    'guard_name' => $guardName,
                    'is_default' => false,
                ]);
            }

            $user->roles()->sync([$role]);
        });
    }
}
