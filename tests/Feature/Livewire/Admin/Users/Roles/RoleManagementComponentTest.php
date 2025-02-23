<?php

declare(strict_types=1);

use App\Enums\Users\DefaultRoleEnum;
use App\Livewire\App\Admin\Users\Roles\RoleManagementComponent;
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
    Role::factory(10)->create();

    livewire(RoleManagementComponent::class)
        ->assertStatus(200)
        ->assertViewIs('livewire.app.admin.users.roles.role-management-component');
});

it('can sort items', function (): void {
    $item1 = Role::factory()->create(['created_at' => now()->subDay()]);
    $item2 = Role::factory()->create(['created_at' => now()]);

    livewire(RoleManagementComponent::class)
        ->call('sortBy', 'created_at')
        ->assertSeeInOrder([$item1->name, $item2->name]);
});

it('toggles sort direction when sorting by the same field', function (): void {
    $component = livewire(RoleManagementComponent::class);

    $component->call('sortBy', 'name')
        ->assertSet('sortDirection', 'desc');
});

it('can search items', function (): void {
    $item1 = Role::factory()->create(['name' => 'Foo']);
    $item2 = Role::factory()->create(['name' => 'Bar']);

    livewire(RoleManagementComponent::class)
        ->set('search', 'Foo')
        ->assertSee($item1->name)
        ->assertDontSee($item2->name);
});

it('can confirm item deletion', function (): void {
    $item = Role::factory()->create([
        'is_default' => false,
    ]);

    livewire(RoleManagementComponent::class)
        ->call('confirmItemDeletion', $item)
        ->assertSet('confirmingItemDeletion', $item->id);
});

it('can delete an item', function (): void {
    $item = Role::factory()->create([
        'is_default' => false,
    ]);

    livewire(RoleManagementComponent::class)
        ->call('deleteRecord', $item->id)
        ->assertDispatched('swal:alert');

    assertDatabaseMissing('roles', ['id' => $item->id]);
});

it('can not delete a default item', function (): void {
    $item = Role::factory()->create([
        'is_default' => true,
    ]);

    livewire(RoleManagementComponent::class)
        ->call('deleteRecord', $item->id)
        ->assertSet('confirmingItemDeletion', null);

    assertDatabaseHas('roles', ['id' => $item->id]);
});

it('can not delete an item with users', function (): void {
    $item = Role::factory()->create([
        'is_default' => false,
    ]);

    $item->users()->attach(User::factory()->create());

    livewire(RoleManagementComponent::class)
        ->call('deleteRecord', $item->id)
        ->assertDispatched('swal:alert', type: 'error', title: __('roles.delete.flash_messages.delete_error'));

    assertDatabaseHas('roles', ['id' => $item->id]);
});
