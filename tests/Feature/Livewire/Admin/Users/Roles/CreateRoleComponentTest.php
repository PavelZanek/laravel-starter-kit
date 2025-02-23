<?php

declare(strict_types=1);

use App\Enums\Users\DefaultRoleEnum;
use App\Enums\Users\RoleGuardEnum;
use App\Livewire\App\Admin\Users\Roles\CreateRoleComponent;
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
    $data = [
        'modelData' => [
            'name' => fake()->name,
            'guard_name' => fake()->randomElement(RoleGuardEnum::values()),
        ],
        //        'relations' => [
        //            'role' => Role::query()->where('name', DefaultRoleEnum::SUPER_ADMIN)->first()->id,
        //        ],
    ];

    livewire(CreateRoleComponent::class)
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
