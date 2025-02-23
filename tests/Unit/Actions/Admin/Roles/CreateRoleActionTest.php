<?php

declare(strict_types=1);

use App\Actions\App\Admin\Roles\CreateRoleAction;
use App\Enums\Users\RoleGuardEnum;
use App\Models\Role;

it('can create a record', function (): void {
    $attributes = [
        'name' => fake()->firstName(),
        'guard_name' => fake()->randomElement(RoleGuardEnum::values()),
    ];

    $model = (new CreateRoleAction)->execute($attributes);

    expect($model)->toBeInstanceOf(Role::class)
        ->and($model->name)->toBe($attributes['name'])
        ->and($model->guard_name)->toBe($attributes['guard_name'])
        ->and($model->is_default)->toBeFalse();
});
