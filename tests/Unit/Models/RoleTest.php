<?php

declare(strict_types=1);

use App\Models\Role;

test('to array', function (): void {
    $role = Role::factory()->create()->fresh();

    expect(array_keys($role->toArray()))->toEqual([
        'id',
        'name',
        'guard_name',
        'is_default',
        'created_at',
        'updated_at',
    ]);
});
