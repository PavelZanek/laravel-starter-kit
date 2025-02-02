<?php

declare(strict_types=1);

use App\Models\Team;
use App\Models\TeamInvitation;

test('to array', function (): void {
    $teamInvitation = TeamInvitation::factory()->create()->fresh();

    expect(array_keys($teamInvitation->toArray()))->toEqual([
        'id',
        'team_id',
        'email',
        'role',
        'created_at',
        'updated_at',
    ]);
});

it('belongs to a team', function (): void {
    $teamInvitation = TeamInvitation::factory()->create();

    expect($teamInvitation->team)
        ->not->toBeNull()
        ->toBeInstanceOf(Team::class);
});
