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

it('returns a grouped permission select list', function (): void {
    Permission::factory()->create(['name' => 'users.view', 'guard_name' => 'web']);
    Permission::factory()->create(['name' => 'users.edit', 'guard_name' => 'web']);
    Permission::factory()->create(['name' => 'posts.create', 'guard_name' => 'web']);
    Permission::factory()->create(['name' => 'posts.delete', 'guard_name' => 'web']);

    $permissions = Permission::getPermissionSelectList();

    expect($permissions)->toBeArray()
        ->and(array_keys($permissions))->toMatchArray(['posts', 'users'])
        ->and($permissions['users'])->toBeArray()
        ->and($permissions['posts'])->toBeArray()
        ->and($permissions['users'])->toHaveCount(2)
        ->and($permissions['users'][0])->toHaveKeys(['id', 'name'])
        ->and($permissions['posts'])->toHaveCount(2)
        ->and($permissions['posts'][0])->toHaveKeys(['id', 'name']);

});
