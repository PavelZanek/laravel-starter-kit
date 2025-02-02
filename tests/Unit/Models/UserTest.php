<?php

declare(strict_types=1);

use App\Models\User;

test('to array', function (): void {
    $user = User::factory()->create()->fresh();

    expect(array_keys($user->toArray()))->toEqual([
        'id',
        'name',
        'email',
        'email_verified_at',
        'current_team_id',
        'profile_photo_path',
        'created_at',
        'updated_at',
        'two_factor_confirmed_at',
        'profile_photo_url',
    ]);
});
