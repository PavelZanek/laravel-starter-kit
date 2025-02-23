<?php

declare(strict_types=1);

use App\Enums\Users\DefaultRoleEnum;
use App\Enums\Users\RoleGuardEnum;
use App\Livewire\App\Admin\Users\Roles\CreateRoleComponent;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

beforeEach(function (): void {
    actingAs(
        User::factory()
            ->withPersonalTeam()
            ->withRole(DefaultRoleEnum::SUPER_ADMIN->value)
            ->create()
    );
});

it('can render the component', function (): void {
    livewire(CreateRoleComponent::class)
        ->assertStatus(200)
        ->assertViewIs('livewire.app.admin.users.roles.role-form-component');
});

it('can create an item', function (): void {
    $guard = fake()->randomElement(RoleGuardEnum::values());

    [$permission1, $permission2] = Permission::factory()->count(2)->create([
        'guard_name' => $guard,
    ]);

    $data = [
        'modelData' => [
            'name' => fake()->name,
            'guard_name' => $guard,
        ],
        'relations' => [
            'permissions' => [
                $permission1->id => true,
                $permission2->id => true,
            ],
        ],
    ];

    livewire(CreateRoleComponent::class)
        ->assertSet('form.modelData', [])
        ->set('form.modelData', $data['modelData'])
        ->set('form.relations', $data['relations'])
        ->call('saveRecord')
        ->assertHasNoErrors()
        ->assertDispatched('swal:alert', type: 'success');

    assertDatabaseHas('roles', [
        'name' => $data['modelData']['name'],
        'guard_name' => $data['modelData']['guard_name'],
        'is_default' => false,
    ]);

    $newRole = Role::query()
        ->where('name', $data['modelData']['name'])
        ->where('guard_name', $guard)
        ->where('is_default', false)
        ->first();

    assertDatabaseHas('role_has_permissions', [
        'role_id' => $newRole->id,
        'permission_id' => $permission1->id,
    ]);

    assertDatabaseHas('role_has_permissions', [
        'role_id' => $newRole->id,
        'permission_id' => $permission2->id,
    ]);
});

it('validates form inputs', function (): void {
    livewire(CreateRoleComponent::class)
        ->set('form.modelData.name', '')
        ->call('saveRecord')
        ->assertHasErrors(['form.modelData.name' => 'required']);

    livewire(CreateRoleComponent::class)
        ->set('form.modelData.guard_name', 'not-an-enum')
        ->call('saveRecord')
        ->assertHasErrors(['form.modelData.guard_name']);

    $existingItem = Role::factory()->create();
    livewire(CreateRoleComponent::class)
        ->set('form.modelData.name', $existingItem->name)
        ->set('form.modelData.guard_name', $existingItem->guard_name)
        ->call('saveRecord')
        ->assertHasErrors(['form.modelData.name']);
});
