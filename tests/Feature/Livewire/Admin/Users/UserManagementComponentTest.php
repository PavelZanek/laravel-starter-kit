<?php

declare(strict_types=1);

use App\Enums\Users\DefaultRoleEnum;
use App\Enums\Users\PreferredLocaleEnum;
use App\Livewire\App\Admin\Users\UserManagementComponent;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\seed;
use function Pest\Livewire\livewire;

beforeEach(function (): void {
    seed(RoleSeeder::class);

    actingAs(
        User::factory()
            ->withPersonalTeam()
            ->withRole(DefaultRoleEnum::SUPER_ADMIN->value)
            ->create()
    );
});

it('can render the component', function (): void {
    User::factory(10)->withRole()->create();

    livewire(UserManagementComponent::class)
        ->assertStatus(200)
        ->assertViewIs('livewire.app.admin.user.user-management-component');
});

it('can sort items', function (): void {
    $item1 = User::factory()->create(['created_at' => now()->subDay()]);
    $item2 = User::factory()->create(['created_at' => now()]);

    livewire(UserManagementComponent::class)
        ->call('sortBy', 'created_at')
        ->assertSeeInOrder([$item1->name, $item2->name]);
});

it('toggles sort direction when sorting by the same field', function (): void {
    $component = livewire(UserManagementComponent::class);

    $component->call('sortBy', 'name')
        ->assertSet('sortDirection', 'desc');
});

it('can search items', function (): void {
    $item1 = User::factory()->create(['name' => 'Foo']);
    $item2 = User::factory()->create(['name' => 'Bar']);

    livewire(UserManagementComponent::class)
        ->set('search', 'Foo')
        ->assertSee($item1->name)
        ->assertDontSee($item2->name);
});

it('filters users by selected role', function (): void {
    $userWithRole = User::factory()->withRole()->create();

    $userWithoutRole = User::factory()->create();

    livewire(UserManagementComponent::class)
        ->set('selectedRole', $userWithRole->roles->first()->id)
        ->assertSee($userWithRole->name)
        ->assertDontSee($userWithoutRole->name);
});

it('can confirm item add', function (): void {
    livewire(UserManagementComponent::class)
        ->call('confirmItemAdd')
        ->assertSet('confirmingItemManage', true);
});

it('can create an item', function (): void {
    $data = [
        'modelData' => [
            'name' => 'User',
            'email' => 'user@test.com',
            // 'preferred_locale' => PreferredLocaleEnum::CS->value,
        ],
        'relations' => [
            'role' => Role::query()->where('name', DefaultRoleEnum::SUPER_ADMIN)->first()->id,
        ],
    ];

    livewire(UserManagementComponent::class)
        ->assertSet('form.modelData', [])
        ->set('form.modelData', $data['modelData'])
        ->set('form.relations.role', $data['relations']['role'])
        ->call('saveRecord')
        ->assertHasNoErrors()
        ->assertDispatched('swal:alert', type: 'success');

    assertDatabaseHas('users', [
        'name' => 'User',
        'email' => 'user@test.com',
        'preferred_locale' => PreferredLocaleEnum::EN->value,
    ]);
});

it('can confirm item edit', function (): void {
    $user = User::factory()->create();

    $component = livewire(UserManagementComponent::class)
        ->call('confirmItemEdit', $user)
        ->assertSet('confirmingItemManage', $user->id);

    expect($component->instance()->form->modelData)->toEqual([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
    ]);
});

it('can update an item', function (): void {
    $user = User::factory()->create();

    $data = [
        'modelData' => [
            'name' => 'User',
            'email' => 'user@test.com',
            // 'preferred_locale' => PreferredLocaleEnum::CS->value,
        ],
        'relations' => [
            'role' => Role::query()->where('name', DefaultRoleEnum::SUPER_ADMIN)->first()->id,
        ],
    ];

    livewire(UserManagementComponent::class)
        ->call('confirmItemEdit', $user)
        ->assertSet('confirmingItemManage', $user->id)
        ->assertSet('form.modelData', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ])
        ->set('form.modelData.name', $data['modelData']['name'])
        ->set('form.modelData.email', $data['modelData']['email'])
        ->set('form.relations.role', $data['relations']['role'])
        ->call('saveRecord')
        ->assertDispatched('swal:alert', type: 'success', title: __('common.flash_messages.updated'));

    assertDatabaseHas('users', [
        'name' => 'User',
        'email' => 'user@test.com',
        // 'preferred_locale' => PreferredLocaleEnum::EN->value,
    ]);
});

it('validates form inputs', function (): void {
    livewire(UserManagementComponent::class)
        ->set('form.modelData.name', '')
        ->call('saveRecord')
        ->assertHasErrors(['form.modelData.name' => 'required']);

    livewire(UserManagementComponent::class)
        ->set('form.modelData.email', 'not-an-email')
        ->call('saveRecord')
        ->assertHasErrors(['form.modelData.email' => 'email']);
});

it('can confirm item deletion', function (): void {
    $user = User::factory()->create();
    livewire(UserManagementComponent::class)
        ->call('confirmItemDeletion', $user)
        ->assertSet('confirmingItemDeletion', $user->id);
});

it('can delete an item', function (): void {
    $item = User::factory()->create();

    livewire(UserManagementComponent::class)
        ->call('deleteRecord', $item->id)
        ->assertDispatched('swal:alert');

    assertDatabaseMissing('users', ['id' => $item->id]);
});

it('can not delete an item if not superadmin or admin', function (User $user): void {
    actingAs($user);

    $item = User::factory()->create();

    livewire(UserManagementComponent::class)
        ->assertForbidden();

    assertDatabaseHas('users', ['id' => $item->id]);
})->with([
    fn () => User::factory()->withPersonalTeam()->withRole(DefaultRoleEnum::BASIC->value)->create(),
]);
