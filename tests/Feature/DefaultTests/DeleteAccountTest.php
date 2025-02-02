<?php

declare(strict_types=1);

use App\Actions\Jetstream\DeleteUser;
use App\Models\Team;
use App\Models\User;
use Laravel\Jetstream\Contracts\DeletesTeams;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\DeleteUserForm;
use Livewire\Livewire;

test('user accounts can be deleted', function (): void {
    $this->actingAs($user = User::factory()->create());

    Livewire::test(DeleteUserForm::class)
        ->set('password', 'password')
        ->call('deleteUser');

    expect($user->fresh())->toBeNull();
})->skip(function (): bool {
    return ! Features::hasAccountDeletionFeatures();
}, 'Account deletion is not enabled.');

test('correct password must be provided before account can be deleted', function (): void {
    $this->actingAs($user = User::factory()->create());

    Livewire::test(DeleteUserForm::class)
        ->set('password', 'wrong-password')
        ->call('deleteUser')
        ->assertHasErrors(['password']);

    expect($user->fresh())->not->toBeNull();
})->skip(function (): bool {
    return ! Features::hasAccountDeletionFeatures();
}, 'Account deletion is not enabled.');

test('user deletion calls team deletion for owned teams', function (): void {
    // Create a user
    $user = User::factory()->create();

    // Create a team owned by the user
    $team = Team::factory()->create(['user_id' => $user->id]);
    $user->ownedTeams()->save($team);

    // Mock the DeletesTeams service
    $deletesTeamsMock = Mockery::mock(DeletesTeams::class);
    $deletesTeamsMock->shouldReceive('delete')
        ->once() // Expect the method to be called exactly once
        ->withArgs(fn (Team $t): bool => $t->id === $team->id);

    // Bind the mock to Laravel's container so that dependency injection works
    $this->instance(DeletesTeams::class, $deletesTeamsMock);

    // Execute the DeleteUser action
    $deleteUser = app(DeleteUser::class);
    $deleteUser->delete($user);

    // Assert that the user is deleted from the database
    expect(User::query()->find($user->id))->toBeNull();
});
