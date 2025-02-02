<?php

declare(strict_types=1);

use App\Actions\Jetstream\AddTeamMember;
use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Events\AddingTeamMember;
use Laravel\Jetstream\Events\TeamMemberAdded;

test('authorized user can add a new team member', function (): void {
    Event::fake();

    $owner = User::factory()->create();
    $team = Team::factory()->create();
    $team->users()->attach($owner);

    $newMember = User::factory()->create();

    // We need to set the roles configuration to make Jetstream::hasRoles() = true
    config()->set('jetstream.roles', [
        'admin' => [
            'name' => 'Administrator',
            'permissions' => [],
        ],
    ]);

    Gate::partialMock()
        ->shouldReceive('forUser->authorize')
        ->once();

    // Calling the action itself
    app(AddTeamMember::class)->add(
        user: $owner,
        team: $team,
        email: $newMember->email,
        role: 'admin'
    );

    // Checking if the events were dispatched
    Event::assertDispatched(AddingTeamMember::class);
    Event::assertDispatched(TeamMemberAdded::class);

    // Checking if the user was actually added to the team
    expect($team->fresh()->users)->toHaveCount(2);
});

test('unauthorized user cannot add a new team member', function (): void {
    $owner = User::factory()->create();
    $team = Team::factory()->create();
    $team->users()->attach($owner);

    $newMember = User::factory()->create();

    // Simulating unsuccessful authorization
    Gate::partialMock()
        ->shouldReceive('forUser->authorize')
        ->andThrow(new AuthorizationException);

    app(AddTeamMember::class)->add(
        user: $owner,
        team: $team,
        email: $newMember->email,
        role: 'admin'
    );
})->throws(AuthorizationException::class);

test('it throws a validation exception if the user is already on the team', function (): void {
    $owner = User::factory()->create();
    $team = Team::factory()->create();
    $team->users()->attach($owner);

    // Adding a new user to the team
    $existingMember = User::factory()->create();
    $team->users()->attach($existingMember);

    Gate::partialMock()
        ->shouldReceive('forUser->authorize')
        ->once();

    app(AddTeamMember::class)->add(
        user: $owner,
        team: $team,
        email: $existingMember->email,
        role: 'admin'
    );
})->throws(ValidationException::class);

test('it throws a validation exception if the user does not exist in the database', function (): void {
    $owner = User::factory()->create();
    $team = Team::factory()->create();
    $team->users()->attach($owner);

    Gate::partialMock()
        ->shouldReceive('forUser->authorize')
        ->once();

    // Non-existent email
    app(AddTeamMember::class)->add(
        user: $owner,
        team: $team,
        email: 'doesnotexist@example.com',
        role: 'admin'
    );
})->throws(ValidationException::class);
