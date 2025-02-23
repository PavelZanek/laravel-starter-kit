<?php

declare(strict_types=1);

use App\Actions\App\Admin\Roles\UpdateRoleAction;
use App\Enums\Users\RoleGuardEnum;
use App\Models\Role;

it('can update a record', function (): void {
    $model = Role::factory()->create([
        'is_default' => false,
    ]);

    $attributes = [
        'name' => fake()->firstName(),
        'guard_name' => fake()->randomElement(RoleGuardEnum::values()),
    ];

    $model = (new UpdateRoleAction)->execute($model, $attributes);

    expect($model)->toBeInstanceOf(Role::class)
        ->and($model->name)->toBe($attributes['name'])
        ->and($model->guard_name)->toBe($attributes['guard_name'])
        ->and($model->is_default)->toBeFalse();
});
