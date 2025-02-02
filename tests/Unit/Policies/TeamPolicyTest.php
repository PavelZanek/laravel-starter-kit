<?php

declare(strict_types=1);

namespace Tests\Unit\Policies;

use App\Models\Team;
use App\Models\User;
use App\Policies\TeamPolicy;
use Mockery;

beforeEach(function (): void {
    $this->policy = new TeamPolicy;
});

it('allows viewing any team', function (): void {
    expect($this->policy->viewAny())->toBeTrue();
});

it('allows creating a team', function (): void {
    expect($this->policy->create())->toBeTrue();
});

it('allows viewing a team if user belongs to it', function (): void {
    $user = Mockery::mock(User::class);
    $team = Mockery::mock(Team::class);

    $user->shouldReceive('belongsToTeam')
        ->with($team)
        ->andReturn(true);

    expect($this->policy->view($user, $team))->toBeTrue();
});

it('denies viewing a team if user does not belong to it', function (): void {
    $user = Mockery::mock(User::class);
    $team = Mockery::mock(Team::class);

    $user->shouldReceive('belongsToTeam')
        ->with($team)
        ->andReturn(false);

    expect($this->policy->view($user, $team))->toBeFalse();
});

it('allows actions for team owners', function (string $method): void {
    $user = Mockery::mock(User::class);
    $team = Mockery::mock(Team::class);

    $user->shouldReceive('ownsTeam')
        ->with($team)
        ->andReturn(true);

    expect($this->policy->{$method}($user, $team))->toBeTrue();
})->with([
    'update',
    'delete',
    'addTeamMember',
    'updateTeamMember',
    'removeTeamMember',
]);

it('denies actions for non-owners', function (string $method): void {
    $user = Mockery::mock(User::class);
    $team = Mockery::mock(Team::class);

    $user->shouldReceive('ownsTeam')
        ->with($team)
        ->andReturn(false);

    expect($this->policy->{$method}($user, $team))->toBeFalse();
})->with([
    'update',
    'delete',
    'addTeamMember',
    'updateTeamMember',
    'removeTeamMember',
]);
