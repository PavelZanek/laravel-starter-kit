<?php

declare(strict_types=1);

use App\Actions\App\Admin\Users\CreateUserAction;
use App\Enums\Users\PreferredLocaleEnum;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\seed;

it('can create a record', function (): void {
    seed(RoleSeeder::class);

    $attributes = [
        'name' => fake()->firstName(),
        'email' => fake()->email(),
        'preferred_locale' => fake()->randomElement([
            PreferredLocaleEnum::CS->value,
            PreferredLocaleEnum::EN->value,
        ]),
    ];

    $model = (new CreateUserAction)->execute($attributes, Role::query()->firstOrFail());

    expect($model)->toBeInstanceOf(User::class)
        ->and($model->name)->toBe($attributes['name'])
        ->and($model->email)->toBe($attributes['email'])
        ->and($model->preferred_locale->value)->toBe($attributes['preferred_locale']);
});
