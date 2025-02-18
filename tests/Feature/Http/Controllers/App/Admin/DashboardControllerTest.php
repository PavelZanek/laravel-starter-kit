<?php

declare(strict_types=1);

use App\Enums\Users\DefaultRoleEnum;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('allows specific role to display the admin dashboard - ', function (DefaultRoleEnum $role): void {
    actingAs(User::factory()->withPersonalTeam()->withRole($role->value)->create());

    get(route('admin.dashboard'))
        ->assertStatus(Response::HTTP_OK)
        ->assertViewIs('app.admin.dashboard.index');
})->with([DefaultRoleEnum::SUPER_ADMIN, DefaultRoleEnum::ADMIN]);

it('denies access to authenticated user for the index view', function (): void {
    actingAs(User::factory()->withPersonalTeam()->withRole()->create());

    get(route('admin.dashboard'))
        ->assertStatus(Response::HTTP_FORBIDDEN);
});
