<?php

declare(strict_types=1);

use App\Actions\App\Admin\Users\UpdateUserAction;
use App\Enums\Users\PreferredLocaleEnum;
use App\Models\User;

it('can update a record', function (): void {
    $model = User::factory()->withRole()->create();

    $attributes = [
        'name' => fake()->firstName(),
        'email' => fake()->email(),
        'preferred_locale' => fake()->randomElement([
            PreferredLocaleEnum::CS->value,
            PreferredLocaleEnum::EN->value,
        ]),
        'notification_channels' => ['database' => true, 'mail' => fake()->boolean()],
    ];

    $model = (new UpdateUserAction)->execute($model, $attributes, $model->roles->first());

    expect($model)->toBeInstanceOf(User::class)
        ->and($model->name)->toBe($attributes['name'])
        ->and($model->email)->toBe($attributes['email'])
        ->and($model->preferred_locale->value)->toBe($attributes['preferred_locale'])
        ->and($model->notification_channels)->toBe($attributes['notification_channels']);
});
