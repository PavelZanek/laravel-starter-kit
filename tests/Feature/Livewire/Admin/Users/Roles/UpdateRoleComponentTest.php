<?php

declare(strict_types=1);

use App\Enums\Users\DefaultRoleEnum;
use App\Enums\Users\RoleGuardEnum;
use App\Livewire\App\Admin\Users\Roles\UpdateRoleComponent;
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
    $item = Role::factory()->create([
        'is_default' => false,
    ]);

    $data = [
        'modelData' => [
            'name' => fake()->name,
            'guard_name' => fake()->randomElement(RoleGuardEnum::values()),
        ],
        //        'relations' => [
        //            'role' => Role::query()->where('name', DefaultRoleEnum::SUPER_ADMIN)->first()->id,
        //        ],
    ];

    livewire(UpdateRoleComponent::class, ['role' => $item])
        ->assertSet('form.modelData', [
            'name' => $item->name,
            'guard_name' => $item->guard_name,
        ])
        ->set('form.modelData.name', $data['modelData']['name'])
        ->set('form.modelData.guard_name', $data['modelData']['guard_name'])
        // ->set('form.relations.role', $data['relations']['role'])
        ->call('saveRecord')
        ->assertDispatched('swal:alert', type: 'success', title: __('common.flash_messages.updated'));

    assertDatabaseHas('roles', [
        'name' => $data['modelData']['name'],
        'guard_name' => $data['modelData']['guard_name'],
        'is_default' => $item->is_default,
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
