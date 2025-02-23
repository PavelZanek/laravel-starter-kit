<?php

declare(strict_types=1);

use App\Models\Permission;

test('to array', function (): void {
    $permission = Permission::factory()->create()->fresh();

    expect(array_keys($permission->toArray()))->toEqual([
        'id',
        'name',
        'guard_name',
        'created_at',
        'updated_at',
    ]);
});
