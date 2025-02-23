<?php

declare(strict_types=1);

use App\Enums\Users\DefaultRoleEnum;
use App\Enums\Users\RoleGuardEnum;
use App\Livewire\App\Admin\Users\RoleManagementComponent;
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
        ->assertViewIs('livewire.app.admin.roles.role-management-component');
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

it('can confirm item add', function (): void {
    livewire(RoleManagementComponent::class)
        ->call('confirmItemAdd')
        ->assertSet('confirmingItemManage', true);
});

it('can create an item', function (): void {
    $data = [
        'modelData' => [
            'name' => fake()->name,
            'guard_name' => fake()->randomElement(RoleGuardEnum::values()),
            // 'preferred_locale' => PreferredLocaleEnum::CS->value,
        ],
        //        'relations' => [
        //            'role' => Role::query()->where('name', DefaultRoleEnum::SUPER_ADMIN)->first()->id,
        //        ],
    ];

    livewire(RoleManagementComponent::class)
        ->assertSet('form.modelData', [])
        ->set('form.modelData', $data['modelData'])
        // ->set('form.relations.role', $data['relations']['role'])
        ->call('saveRecord')
        ->assertHasNoErrors()
        ->assertDispatched('swal:alert', type: 'success');

    assertDatabaseHas('roles', [
        'name' => $data['modelData']['name'],
        'guard_name' => $data['modelData']['guard_name'],
        'is_default' => false,
        // 'preferred_locale' => PreferredLocaleEnum::EN->value,
    ]);
});

it('can confirm item edit', function (): void {
    $item = Role::factory()->create([
        'is_default' => false,
    ]);

    $component = livewire(RoleManagementComponent::class)
        ->call('confirmItemEdit', $item)
        ->assertSet('confirmingItemManage', $item->id);

    expect($component->instance()->form->modelData)->toEqual([
        'id' => $item->id,
        'name' => $item->name,
        'guard_name' => $item->guard_name,
    ]);
});

it('can update an item', function (): void {
    $item = Role::factory()->create([
        'is_default' => false,
    ]);

    $data = [
        'modelData' => [
            'name' => fake()->name,
            'guard_name' => fake()->randomElement(RoleGuardEnum::values()),
            // 'preferred_locale' => PreferredLocaleEnum::CS->value,
        ],
        //        'relations' => [
        //            'role' => Role::query()->where('name', DefaultRoleEnum::SUPER_ADMIN)->first()->id,
        //        ],
    ];

    livewire(RoleManagementComponent::class)
        ->call('confirmItemEdit', $item)
        ->assertSet('confirmingItemManage', $item->id)
        ->assertSet('form.modelData', [
            'id' => $item->id,
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
        // 'preferred_locale' => PreferredLocaleEnum::EN->value,
    ]);
});

it('can not update a default item', function (): void {
    $item = Role::factory()->create([
        'is_default' => true,
    ]);

    $data = [
        'modelData' => [
            'name' => fake()->name,
            'guard_name' => fake()->randomElement(RoleGuardEnum::values()),
            // 'preferred_locale' => PreferredLocaleEnum::CS->value,
        ],
    ];

    livewire(RoleManagementComponent::class)
        ->call('confirmItemEdit', $item)
        ->assertSet('confirmingItemManage', null);

    assertDatabaseHas('roles', [
        'name' => $item->name,
        'guard_name' => $item->guard_name,
        'is_default' => $item->is_default,
        // 'preferred_locale' => PreferredLocaleEnum::EN->value,
    ]);
});

it('validates form inputs', function (): void {
    livewire(RoleManagementComponent::class)
        ->set('form.modelData.name', '')
        ->call('saveRecord')
        ->assertHasErrors(['form.modelData.name' => 'required']);

    livewire(RoleManagementComponent::class)
        ->set('form.modelData.guard_name', 'not-an-enum')
        ->call('saveRecord')
        ->assertHasErrors(['form.modelData.guard_name']);
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
        ->assertDispatched('swal:alert', type: 'error', title: __('roles.index.flash_messages.delete_error'));

    assertDatabaseHas('roles', ['id' => $item->id]);

});
