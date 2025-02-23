<?php

declare(strict_types=1);

use App\Enums\Users\DefaultRoleEnum;
use App\Enums\Users\RoleGuardEnum;
use App\Livewire\App\Admin\Users\Roles\UpdateRoleComponent;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
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
    $item = Role::factory()->create();

    livewire(UpdateRoleComponent::class, ['role' => $item])
        ->assertStatus(200)
        ->assertViewIs('livewire.app.admin.users.roles.role-form-component');
});

it('can update an item', function (): void {
    $guard = fake()->randomElement(RoleGuardEnum::values());

    $item = Role::factory()->create([
        'guard_name' => $guard,
        'is_default' => false,
    ]);

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

    livewire(UpdateRoleComponent::class, ['role' => $item])
        ->assertSet('form.modelData', [
            'name' => $item->name,
            'guard_name' => $item->guard_name,
        ])
        ->set('form.modelData.name', $data['modelData']['name'])
        ->set('form.modelData.guard_name', $data['modelData']['guard_name'])
        ->set('form.relations', $data['relations'])
        ->call('saveRecord')
        ->assertDispatched('swal:alert', type: 'success', title: __('common.flash_messages.updated'));

    assertDatabaseHas('roles', [
        'name' => $data['modelData']['name'],
        'guard_name' => $data['modelData']['guard_name'],
        'is_default' => $item->is_default,
    ]);

    assertDatabaseHas('role_has_permissions', [
        'role_id' => $item->id,
        'permission_id' => $permission1->id,
    ]);

    assertDatabaseHas('role_has_permissions', [
        'role_id' => $item->id,
        'permission_id' => $permission2->id,
    ]);
});

it('can remove permissions from role', function (): void {
    $guard = fake()->randomElement(RoleGuardEnum::values());

    [$permission1, $permission2] = Permission::factory()->count(2)->create([
        'guard_name' => $guard,
    ]);

    $role = Role::factory()->create([
        'guard_name' => $guard,
        'is_default' => false,
    ]);

    $role->permissions()->sync([$permission1->id, $permission2->id]);

    livewire(UpdateRoleComponent::class, ['role' => $role])
        ->set('form.relations', ['permissions' => [
            $permission1->id => true,
        ]])
        ->call('saveRecord')
        ->assertDispatched('swal:alert', type: 'success', title: __('common.flash_messages.updated'));

    assertDatabaseHas('role_has_permissions', [
        'role_id' => $role->id,
        'permission_id' => $permission1->id,
    ]);
    assertDatabaseMissing('role_has_permissions', [
        'role_id' => $role->id,
        'permission_id' => $permission2->id,
    ]);
});

it('can not update a default item', function (): void {
    $item = Role::factory()->create([
        'is_default' => true,
    ]);

    livewire(UpdateRoleComponent::class, ['role' => $item])
        ->call('saveRecord')
        ->assertForbidden();
});

it('validates form inputs', function (): void {
    $item = Role::factory()->create([
        'is_default' => false,
    ]);

    livewire(UpdateRoleComponent::class, ['role' => $item])
        ->set('form.modelData.name', '')
        ->call('saveRecord')
        ->assertHasErrors(['form.modelData.name' => 'required']);

    livewire(UpdateRoleComponent::class, ['role' => $item])
        ->set('form.modelData.guard_name', 'not-an-enum')
        ->call('saveRecord')
        ->assertHasErrors(['form.modelData.guard_name']);

    $existingItem = Role::factory()->create([
        'is_default' => $item->is_default,
    ]);
    livewire(UpdateRoleComponent::class, ['role' => $item])
        ->set('form.modelData.name', $existingItem->name)
        ->set('form.modelData.guard_name', $existingItem->guard_name)
        ->call('saveRecord')
        ->assertHasErrors(['form.modelData.name']);
});

it('can confirm item deletion', function (): void {
    $item = Role::factory()->create([
        'is_default' => false,
    ]);

    livewire(UpdateRoleComponent::class, ['role' => $item])
        ->call('confirmItemDeletion')
        ->assertSet('confirmingItemDeletion', true);
});

it('can delete an item', function (): void {
    $item = Role::factory()->create([
        'is_default' => false,
    ]);

    livewire(UpdateRoleComponent::class, ['role' => $item])
        ->call('deleteRecord')
        ->assertDispatched('swal:alert');

    assertDatabaseMissing('roles', ['id' => $item->id]);
});

it('can not delete a default item', function (): void {
    $item = Role::factory()->create([
        'is_default' => true,
    ]);

    livewire(UpdateRoleComponent::class, ['role' => $item])
        ->call('deleteRecord')
        ->assertForbidden();

    assertDatabaseHas('roles', ['id' => $item->id]);
});

it('can not delete an item with users', function (): void {
    $item = Role::factory()->create([
        'is_default' => false,
    ]);

    $item->users()->attach(User::factory()->create());

    livewire(UpdateRoleComponent::class, ['role' => $item])
        ->call('deleteRecord')
        ->assertDispatched('swal:alert', type: 'error', title: __('roles.delete.flash_messages.delete_error'));

    assertDatabaseHas('roles', ['id' => $item->id]);
});
