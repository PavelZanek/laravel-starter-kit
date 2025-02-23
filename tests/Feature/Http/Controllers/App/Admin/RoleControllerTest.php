<?php

declare(strict_types=1);

use App\Enums\Users\DefaultRoleEnum;
use App\Models\Role;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('allows specific role to display the index view - ', function (DefaultRoleEnum $role): void {
    actingAs(User::factory()->withPersonalTeam()->withRole($role->value)->create());

    $roles = Role::factory(5)->create();

    get(route('admin.roles.index'))
        ->assertStatus(Response::HTTP_OK)
        ->assertViewIs('app.admin.users.roles.index')
        ->assertSeeText($roles->random()->name);
})->with([DefaultRoleEnum::SUPER_ADMIN, DefaultRoleEnum::ADMIN]);

it('denies access to authenticated user for the index view', function (): void {
    actingAs(User::factory()->withPersonalTeam()->withRole()->create());

    get(route('admin.roles.index'))
        ->assertStatus(Response::HTTP_FORBIDDEN);
});

it('allows specific role to display the create view - ', function (DefaultRoleEnum $role): void {
    actingAs(User::factory()->withPersonalTeam()->withRole($role->value)->create());

    get(route('admin.roles.create'))
        ->assertStatus(Response::HTTP_OK)
        ->assertViewIs('app.admin.users.roles.create');
})->with([DefaultRoleEnum::SUPER_ADMIN, DefaultRoleEnum::ADMIN]);

it('denies access to authenticated user for the create view', function (): void {
    actingAs(User::factory()->withPersonalTeam()->withRole()->create());

    get(route('admin.roles.create'))
        ->assertStatus(Response::HTTP_FORBIDDEN);
});

it('allows specific role to display the edit view - ', function (DefaultRoleEnum $role): void {
    actingAs(User::factory()->withPersonalTeam()->withRole($role->value)->create());

    $role = Role::factory()->create([
        'is_default' => false,
    ]);

    get(route('admin.roles.edit', $role))
        ->assertStatus(Response::HTTP_OK)
        ->assertViewIs('app.admin.users.roles.edit')
        ->assertSeeText($role->name);
})->with([DefaultRoleEnum::SUPER_ADMIN, DefaultRoleEnum::ADMIN]);

it('denies access to authenticated user for the edit view', function (): void {
    actingAs(User::factory()->withPersonalTeam()->withRole()->create());

    $role = Role::factory()->create([
        'is_default' => false,
    ]);

    get(route('admin.roles.edit', $role))
        ->assertStatus(Response::HTTP_FORBIDDEN);
});

it('denies access to authenticated user for the edit view when role is default', function (): void {
    actingAs(User::factory()->withPersonalTeam()->withRole()->create());

    $role = Role::factory()->create([
        'is_default' => true,
    ]);

    get(route('admin.roles.edit', $role))
        ->assertStatus(Response::HTTP_FORBIDDEN);
});
