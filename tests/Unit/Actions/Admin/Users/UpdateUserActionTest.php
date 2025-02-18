<?php

declare(strict_types=1);

use App\Actions\App\Admin\Users\UpdateUserAction;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\seed;

it('can update a record', function (): void {
    seed(RoleSeeder::class);

    $model = User::factory()->create();

    $attributes = [
        'name' => fake()->firstName(),
        'email' => fake()->email(),
    ];

    $model = (new UpdateUserAction)->execute($model, $attributes, Role::query()->firstOrFail());

    expect($model)->toBeInstanceOf(User::class)
        ->and($model->name)->toBe($attributes['name'])
        ->and($model->email)->toBe($attributes['email']);
});
