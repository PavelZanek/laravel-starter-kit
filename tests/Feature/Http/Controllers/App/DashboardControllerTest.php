<?php

declare(strict_types=1);

use App\Enums\Users\DefaultRoleEnum;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('allows all roles to display the dashboard', function (DefaultRoleEnum $role): void {
    actingAs(User::factory()->withPersonalTeam()->withRole($role->value)->create());

    get(route('dashboard'))
        ->assertStatus(Response::HTTP_OK)
        ->assertViewIs('app.dashboard.index');
})->with([DefaultRoleEnum::SUPER_ADMIN, DefaultRoleEnum::ADMIN, DefaultRoleEnum::BASIC]);

it('denies access to unauthenticated user for the dashboard', function (): void {
get(route('dashboard'))
->assertStatus(Response::HTTP_FOUND)
->assertRedirect(route('login'));
    });
